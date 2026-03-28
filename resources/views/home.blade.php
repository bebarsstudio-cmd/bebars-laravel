@extends('layouts.app')

@section('title', 'Portfolio')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="glow-text">BEBARS GAMING</h1>
                    <div class="typed-container">
                        <span class="typed-text"></span>
                        <span class="cursor">&nbsp;</span>
                    </div>
                    <p>Passionate game developer and web creator, building amazing digital experiences with cutting-edge technology.</p>
                    <div class="hero-buttons">
                        <a href="#projects" class="btn-primary">View Projects</a>
                        <a href="#contact" class="btn-secondary">Contact Me</a>
                    </div>
                    <div class="social-links">
                        <a href="https://github.com/bebarsstudio-cmd" target="_blank"><i class="fab fa-github"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-discord"></i></a>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="image-wrapper">
                        <img src="{{ asset('images/Bebars.png') }}" alt="BEBARS-GAMING Avatar">
                        <div class="floating-shapes">
                            <div class="shape shape-1"></div>
                            <div class="shape shape-2"></div>
                            <div class="shape shape-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="mouse"></div>
        </div>
    </section>

    <!-- NEWS Section -->
    <section id="news" class="news-section">
        <div class="container">
            <h2 class="section-title">Latest <span>News</span></h2>
            <div class="news-grid">
                @forelse($news as $item)
                    <div class="news-card">
                        <div class="news-badge {{ $item->category }}">{{ getCategoryName($item->category) }}</div>
                        <div class="news-date"><i class="far fa-calendar-alt"></i> {{ $item->date->format('F j, Y') }}</div>
                        <h3 class="news-title">{{ $item->title }}</h3>
                        <p class="news-content">{{ Str::limit($item->content, 150) }}</p>
                        @if($item->author)
                            <div class="news-author"><i class="fas fa-user"></i> {{ $item->author }}</div>
                        @endif
                    </div>
                @empty
                    <div class="empty-news">No news yet. Check back soon!</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- VS Section -->
    <section id="vs" class="vs-section">
        <div class="container">
            <h2 class="section-title">Bebars <span>VS</span> Ahmed</h2>
            <p class="vs-subtitle">Who do you support? Vote for your favorite!</p>
            
            <div class="vs-container">
                <div class="vs-card bebars-card">
                    <div class="vs-avatar">
                        <img src="{{ asset('images/Bebars.png') }}" alt="Bebars">
                    </div>
                    <h3>BEBARS</h3>
                    <div class="like-counter">
                        <span id="bebarsLikes" class="like-count">{{ $votes['bebars'] }}</span>
                        <span class="like-label">Likes</span>
                    </div>
                    <button class="like-btn" onclick="addLike('bebars')">
                        <i class="fas fa-heart"></i> Support Bebars
                    </button>
                </div>
                
                <div class="vs-badge">
                    <span>VS</span>
                </div>
                
                <div class="vs-card ahmed-card">
                    <div class="vs-avatar">
                        <img src="{{ asset('images/ahmed.png') }}" alt="Ahmed" onerror="this.src='https://ui-avatars.com/api/?name=Ahmed&background=f39c12&color=fff&size=150'">
                    </div>
                    <h3>AHMED</h3>
                    <div class="like-counter">
                        <span id="ahmedLikes" class="like-count">{{ $votes['ahmed'] }}</span>
                        <span class="like-label">Likes</span>
                    </div>
                    <button class="like-btn" onclick="addLike('ahmed')">
                        <i class="fas fa-heart"></i> Support Ahmed
                    </button>
                </div>
            </div>
            
            <div class="vs-progress">
                <div class="progress-bar-container">
                    <div class="progress-bar-bebars" id="progressBebars" style="width: {{ $votes['total'] > 0 ? ($votes['bebars'] / $votes['total']) * 100 : 50 }}%"></div>
                    <div class="progress-bar-ahmed" id="progressAhmed" style="width: {{ $votes['total'] > 0 ? ($votes['ahmed'] / $votes['total']) * 100 : 50 }}%"></div>
                </div>
                <div class="progress-stats">
                    <span id="bebarsPercent">{{ $votes['total'] > 0 ? round(($votes['bebars'] / $votes['total']) * 100) : 50 }}</span>% - 
                    <span id="ahmedPercent">{{ $votes['total'] > 0 ? round(($votes['ahmed'] / $votes['total']) * 100) : 50 }}</span>%
                </div>
            </div>
        </div>
    </section>

    <!-- Feedback Section -->
    <section id="feedback" class="feedback-section">
        <div class="container">
            <h2 class="section-title">Send <span>Feedback</span></h2>
            <p class="feedback-subtitle">Found a bug? Have a suggestion? Let me know!</p>
            
            <div class="feedback-container">
                <div class="feedback-info">
                    <div class="feedback-icon"><i class="fas fa-bug"></i></div>
                    <h3>Report Issues</h3>
                    <p>Found something not working? Tell me about it and I'll fix it ASAP.</p>
                    
                    <div class="feedback-icon"><i class="fas fa-lightbulb"></i></div>
                    <h3>Suggest Features</h3>
                    <p>Have an idea for a new feature? I'd love to hear it!</p>
                    
                    <div class="feedback-email">
                        <i class="fas fa-envelope"></i>
                        <span>Direct: bebarsstudio@gmail.com</span>
                    </div>
                </div>
                
                <form class="feedback-form" id="feedbackForm" method="POST" action="{{ route('feedback.store') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <select name="type" required>
                            <option value="">Select Feedback Type</option>
                            <option value="bug">🐛 Bug Report</option>
                            <option value="feature">💡 Feature Suggestion</option>
                            <option value="improvement">⚡ Improvement Idea</option>
                            <option value="general">📝 General Feedback</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subject" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" rows="5" placeholder="Describe your feedback in detail..." required></textarea>
                    </div>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-paper-plane"></i> Send Feedback
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title">Contact <span>Me</span></h2>
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Let's Connect!</h3>
                    <p>Have a project in mind? Let's work together and create something amazing.</p>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h4>Email</h4>
                                <p>bebarsstudio@gmail.com</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-github"></i>
                            <div>
                                <h4>GitHub</h4>
                                <p>github.com/bebarsstudio-cmd</p>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="contact-form" method="POST" action="#">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
function addLike(user) {
    fetch(`/vote/${user}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateVotes(data.votes);
            showToast(data.message);
        } else {
            showToast(data.message, true);
        }
    });
}

function updateVotes(votes) {
    document.getElementById('bebarsLikes').textContent = votes.bebars;
    document.getElementById('ahmedLikes').textContent = votes.ahmed;
    
    const total = votes.bebars + votes.ahmed;
    const bebarsPercent = total > 0 ? (votes.bebars / total) * 100 : 50;
    const ahmedPercent = total > 0 ? (votes.ahmed / total) * 100 : 50;
    
    document.getElementById('progressBebars').style.width = `${bebarsPercent}%`;
    document.getElementById('progressAhmed').style.width = `${ahmedPercent}%`;
    document.getElementById('bebarsPercent').textContent = Math.round(bebarsPercent);
    document.getElementById('ahmedPercent').textContent = Math.round(ahmedPercent);
}

function showToast(message, isError = false) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.style.background = isError ? '#f44336' : 'linear-gradient(135deg, #667eea, #764ba2)';
    toast.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-triangle' : 'fa-check-circle'}"></i> ${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// Typing animation
const texts = ['Game Developer', 'Web Developer', 'Python Enthusiast', 'Open Source Contributor'];
let textIndex = 0, charIndex = 0, isDeleting = false;
const typedText = document.querySelector('.typed-text');

function type() {
    if (!typedText) return;
    const currentText = texts[textIndex];
    typedText.textContent = isDeleting ? currentText.substring(0, charIndex - 1) : currentText.substring(0, charIndex + 1);
    charIndex += isDeleting ? -1 : 1;
    
    if (!isDeleting && charIndex === currentText.length) {
        isDeleting = true;
        setTimeout(type, 2000);
    } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        textIndex = (textIndex + 1) % texts.length;
        setTimeout(type, 500);
    } else {
        setTimeout(type, isDeleting ? 50 : 100);
    }
}
type();
</script>
@endpush