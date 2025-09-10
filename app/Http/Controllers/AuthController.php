<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show registration form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle user registration
    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'username'      => 'required|string|max:255|unique:users',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:8|confirmed',
            'profile_image' => 'nullable|image|max:2048',
            'bio'           => 'nullable|string|max:500',
        ]);

        $user = User::create([
            'name'          => $request->name,
            'username'      => $request->username,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'bio'           => $request->bio,
            'profile_image' => $request->file('profile_image') ? $request->file('profile_image')->store('profiles', 'public') : 'default.png',
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }

    // Show login form
    public function showLogin()
    {
        // Check if there's a "remember me" cookie
        $rememberedEmail = Cookie::get('remembered_email');

        return view('auth.login', compact('rememberedEmail'));
    }

    // Handle user login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Check if "remember me" was selected
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            session(['user' => Auth::user()]);

            // Handle remember me functionality
            if ($remember) {
                                                                                    // Create a cookie to remember email for 30 days
                $cookie = Cookie::make('remembered_email', $request->email, 43200); // 30 days
                return redirect()->route('posts.index')->withCookie($cookie);
            } else {
                // Remove cookie if user did not select "remember me"
                Cookie::queue(Cookie::forget('remembered_email'));
            }

            return redirect()->route('posts.index');
        }

        return back()->withErrors([
            'email' => 'بيانات الاعتماد هذه لا تتطابق مع سجلاتنا.',
        ]);
    }

    // Handle user logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('user');

        // Remove "remember me" cookie on logout
        Cookie::queue(Cookie::forget('remembered_email'));

        return redirect('/login');
    }
}
