<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Boba Catcher | Pro Edition</title>
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #a855f7;
            --bg-dark: #0f172a;
            --milk: #ffffff;
            --poison: #ff4444;
            --boss-gold: #fbbf24;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { overflow: hidden; font-family: 'Inter', sans-serif; background: var(--bg-dark); color: white; }
        
        #game-board {
            width: 100vw; height: 100vh;
            background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);
            position: relative; overflow: hidden; 
            transition: background 0.5s, box-shadow 0.2s;
        }

        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 500;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            font-weight: 600;
            backdrop-filter: blur(5px);
            cursor: pointer;
        }
        .btn-back:hover { background: var(--poison); }

        #ui-layer { position: absolute; top: 20px; left: 50%; transform: translateX(-50%); z-index: 100; display: flex; gap: 15px; }
        .stat-card { background: rgba(30, 41, 59, 0.9); padding: 10px 20px; border-radius: 12px; text-align: center; min-width: 110px; border: 1px solid rgba(255,255,255,0.1); }
        .stat-label { font-size: 0.7rem; color: var(--secondary); font-weight: 800; display: block; margin-bottom: 5px; }
        
        #cup { width: 90px; height: 110px; position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); z-index: 10; pointer-events: none; }
        .cup-body { position: absolute; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.1); border: 2px solid rgba(255, 255, 255, 0.3); border-radius: 0 0 20px 20px; overflow: hidden; }
        .milk-level { position: absolute; bottom: 0; width: 100%; height: 0%; background: var(--milk); transition: 0.3s; box-shadow: 0 -5px 15px rgba(255,255,255,0.3); }

        .boba { width: 30px; height: 30px; border-radius: 50%; position: absolute; z-index: 5; }
        .boba.normal { background: radial-gradient(circle at 30% 30%, #5d4037, #2d1b15); }
        .boba.poison { background: radial-gradient(circle at 30% 30%, #ff4444, #660000); box-shadow: 0 0 15px var(--poison); }

        .overlay { position: absolute; inset: 0; background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(15px); display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 200; }
        .btn-play { padding: 15px 45px; background: linear-gradient(135deg, var(--primary), var(--secondary)); border: none; border-radius: 50px; color: white; font-weight: 700; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; }
        .btn-secondary { padding: 12px 25px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 50px; color: white; cursor: pointer; margin-top: 10px; }
        
        #leaderboard-modal { position: absolute; inset: 0; background: rgba(15, 23, 42, 0.98); z-index: 600; display: none; flex-direction: column; align-items: center; justify-content: center; }
        .score-row { display: flex; justify-content: space-between; width: 320px; padding: 15px; margin: 5px; background: rgba(255,255,255,0.05); border-radius: 10px; }
        .rank-1 { border: 2px solid var(--boss-gold); color: var(--boss-gold); }
        .hidden { display: none !important; }
    </style>
</head>
<body>

    <div class="btn-back" onclick="window.location.href='{{ url('/') }}'">⬅ LOBBY</div>

    <div id="game-board">
        <div id="ui-layer">
            <div class="stat-card"><span class="stat-label">LEVEL</span><span id="lvl-val" style="font-size: 1.5rem;">1</span></div>
            <div class="stat-card"><span class="stat-label">HEALTH</span><span id="lives-val" style="font-size: 1.5rem;">❤️❤️❤️</span></div>
            <div class="stat-card"><span class="stat-label">SCORE</span><span id="score-val" style="font-size: 1.5rem;">0</span></div>
        </div>

        <div id="cup">
            <div class="cup-body"><div class="milk-level" id="milk-fill"></div></div>
        </div>

        <div id="start-screen" class="overlay">
            <h1 style="font-size: 4rem; margin-bottom: 10px;">BOBA QUEST</h1>
            <p style="color: #94a3b8; margin-bottom: 25px;">Reach Level 40 • Full Heal Every Level</p>
            <button class="btn-play" onclick="initGame()">Enter The Lab</button>
            <button class="btn-secondary" onclick="showLeaderboard()">🏆 Scoreboard</button>
        </div>

        <div id="leaderboard-modal">
            <h1 style="color: var(--boss-gold); margin-bottom: 20px;">HALL OF FAME</h1>
            <div id="leaderboard-list"></div>
            <button class="btn-secondary" onclick="closeLeaderboard()">Close</button>
        </div>

        <div id="game-over-screen" class="overlay hidden">
            <h2 id="death-msg" style="color: var(--poison); font-size: 3.5rem;">WASTED</h2>
            <p style="font-size: 1.5rem; margin: 15px 0;">Final Score: <span id="final-score">0</span></p>
            <button class="btn-play" onclick="location.reload()">Try Again</button>
        </div>
    </div>

    <script>
        let game = { score: 0, level: 1, lives: 3, maxLives: 3, active: false, speed: 4.5, spawnRate: 850 };
        let bobas = [];
        let loops = { spawn: null, physics: null };

        const board = document.getElementById('game-board');
        const cup = document.getElementById('cup');

        board.addEventListener('mousemove', (e) => {
            if (!game.active) return;
            cup.style.left = e.clientX + 'px';
        });

        async function initGame() {
            board.style.cursor = 'none';
            document.querySelector('.btn-back').style.display = 'none';
            document.getElementById('start-screen').classList.add('hidden');
            game.active = true;
            startLevel();
        }

        function startLevel() {
            game.isBoss = (game.level % 10 === 0);
            game.maxLives = game.isBoss ? 5 : 3;
            game.lives = game.maxLives;
            updateUI();
            startLoops();
        }

        function startLoops() {
            clearInterval(loops.spawn);
            clearInterval(loops.physics);
            loops.spawn = setInterval(spawnBoba, game.spawnRate);
            loops.physics = setInterval(updatePhysics, 16);
        }

        function spawnBoba() {
            if (!game.active) return;
            const bobaEl = document.createElement('div');
            const isPoison = Math.random() < (0.15 + (game.level * 0.01));
            bobaEl.className = 'boba ' + (isPoison ? 'poison' : 'normal');
            
            const x = Math.random() * (window.innerWidth - 60) + 30;
            bobaEl.style.left = x + 'px'; bobaEl.style.top = '-50px';
            board.appendChild(bobaEl);
            bobas.push({ el: bobaEl, x: x, y: -50, type: isPoison?'poison':'normal', speed: game.speed + Math.random()*2 });
        }

        function updatePhysics() {
            if (!game.active) return;
            const cupRect = cup.getBoundingClientRect();
            for (let i = bobas.length - 1; i >= 0; i--) {
                let b = bobas[i]; b.y += b.speed; b.el.style.top = b.y + 'px';
                
                if (b.y > (window.innerHeight - 130) && b.y < (window.innerHeight - 40) && b.x > cupRect.left && b.x < cupRect.right) {
                    if (b.type === 'poison') handleHit(); else handleScore();
                    removeBoba(i);
                } else if (b.y > window.innerHeight) {
                    if (b.type === 'normal') handleHit();
                    removeBoba(i);
                }
            }
        }

        function handleScore() {
            game.score++;
            document.getElementById('score-val').innerText = game.score;
            document.getElementById('milk-fill').style.height = ((game.score % 10) * 10) + '%';
            if (game.score % 10 === 0) levelUp();
        }

        function levelUp() {
            game.level++;
            game.speed += 0.5;
            game.spawnRate = Math.max(200, game.spawnRate - 50);
            document.getElementById('lvl-val').innerText = game.level;
            game.lives = game.maxLives;
            updateUI();
        }

        function handleHit() {
            game.lives--;
            updateUI();
            
            board.style.boxShadow = "inset 0 0 150px rgba(255, 0, 0, 0.7)";
            setTimeout(() => {
                board.style.boxShadow = "none";
            }, 200);

            if (game.lives <= 0) endGame();
        }

        function updateUI() {
            document.getElementById('lives-val').innerText = "❤️".repeat(game.lives) + "🖤".repeat(game.maxLives - game.lives);
        }

        function removeBoba(idx) { bobas[idx].el.remove(); bobas.splice(idx, 1); }

        async function endGame() {
            game.active = false;
            board.style.cursor = 'default';
            document.querySelector('.btn-back').style.display = 'block';
            clearInterval(loops.spawn); clearInterval(loops.physics);
            
            document.getElementById('final-score').innerText = game.score;
            document.getElementById('game-over-screen').classList.remove('hidden');

            const name = prompt("Enter your name for the Scoreboard:") || "Anonymous";
            
            try {
                const response = await fetch('{{ url("/api/save-score") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ name: name, score: game.score })
                });
                const result = await response.json();
                console.log(result);
            } catch (error) {
                console.error('Error saving score:', error);
            }
        }

        async function showLeaderboard() {
            try {
                const response = await fetch('{{ url("/api/leaderboard") }}');
                const topScores = await response.json();
                const list = document.getElementById('leaderboard-list');
                list.innerHTML = '';
                topScores.forEach((data, index) => {
                    const row = document.createElement('div');
                    row.className = `score-row ${index === 0 ? 'rank-1' : ''}`;
                    row.innerHTML = `<span>#${index+1} ${escapeHtml(data.name)}</span> <strong>${data.score}</strong>`;
                    list.appendChild(row);
                });
                document.getElementById('leaderboard-modal').style.display = 'flex';
            } catch (error) {
                console.error('Error loading leaderboard:', error);
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function closeLeaderboard() { document.getElementById('leaderboard-modal').style.display = 'none'; }
    </script>
</body>
</html>