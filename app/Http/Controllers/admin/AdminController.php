<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('is_admin', true)->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,super_admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully!');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully!');
    }

    public function resetPassword(Request $request, User $admin)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password reset successfully!');
    }
}