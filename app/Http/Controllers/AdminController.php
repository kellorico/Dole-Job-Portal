<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {

        $admins = User::where('role', 'admin')->get();
        return inertia('Admin/AdminList', [
            'admins' => $admins
        ]);
    }

    public function showLoginForm()
    {
        return Inertia::render('Admin/Auth/Login');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin-login'))->with('success', 'You have been logged out.');
    }

    public function create()
    {

        return inertia('Admin/AddAdmin');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|confirmed'
        ]);

        $validated['role'] = 'admin';

        User::create($validated);

        return back()->with([
            'success' => 'Admin Successfully Created'
        ]);
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|confirmed|min:6',
        ]);

        $admin = User::where('role', 'admin')->findOrFail($id);

        $admin->username = $validated['username'];
        $admin->email = $validated['email'];

        if (!empty($validated['password'])) {
            $admin->password = bcrypt($validated['password']);
        }

        $admin->save();

        return back()->with('success', 'Admin updated successfully.');
    }


    public function delete($id)
{
    $admin = User::where('role', 'admin')->findOrFail($id);
    $admin->delete();

    return redirect()->back()->with('success', 'Admin deleted successfully.');
}


}
