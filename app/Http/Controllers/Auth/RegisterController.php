<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return inertia('Auth/Register');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|lowercase|email|max:255',
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::create($credentials);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
