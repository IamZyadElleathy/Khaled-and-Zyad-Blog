<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\UserProfile;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function loadRegisterForm()
    {
        if (Auth::check()) {
            return redirect($this->getRedirectPath());
        }
        return view("register");
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);
        
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 0,
            ]);

            $user->profile()->create([]);

            Auth::login($user);
            return redirect($this->getRedirectPath())->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function loadLoginPage()
    {
        if (Auth::check()) {
            return redirect($this->getRedirectPath());
        }
        return view('login-page');
    }

    public function LoginUser(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        try {
            if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect($this->getRedirectPath());
            }

            return back()->withInput()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Login failed. Please try again.');
        }
    }

    public function LogoutUser(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login/form');
    }

    public function forgotPassword()
    {
        if (Auth::check()) {
            return redirect($this->getRedirectPath());
        }
        return view('forgot-password');
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users']
        ]);

        try {
            $user = User::where('email', $request->email)->firstOrFail();
            $token = Str::random(64);
            $url = URL::signedRoute('password.reset', ['token' => $token]);

            PasswordReset::where('email', $request->email)->delete();
            
            PasswordReset::create([
                'email' => $request->email,
                'token' => $token,
                'user_id' => $user->id,
                'created_at' => now(),
            ]);

            Mail::send('forgotPasswordMail', [
                'url' => $url,
                'email' => $request->email,
                'title' => 'Password Reset',
                'body' => 'Please click the link below to reset your password'
            ], function($message) use ($request) {
                $message->to($request->email)->subject('Reset Password');
            });

            return back()->with('success', 'Password reset link sent to your email.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send reset link. Please try again.');
        }
    }

    public function loadResetPassword(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $resetData = PasswordReset::where('token', $request->token)
            ->where('created_at', '>', now()->subHours(24))
            ->firstOrFail();

        $user = User::findOrFail($resetData->user_id);
        return view('reset-password', compact('user'));
    }

    public function ResetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        try {
            $user = User::findOrFail($request->user_id);
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            PasswordReset::where('user_id', $user->id)->delete();
            return redirect('/login/form')->with('success', 'Password changed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reset password. Please try again.');
        }
    }

    protected function getRedirectPath()
    {
        return Auth::user()->isAdmin() ? '/admin/home' : '/user/home';
    }

    public function load404()
    {
        return response()->view('404', [], 404);
    }
}
