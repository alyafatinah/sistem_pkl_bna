<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show login page
     */
    public function create(): View
    {
        return view('auth.login');
    }


    /**
     * Handle login request (WITHOUT REMEMBER TOKEN)
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input login (username atau email)
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Coba login TANPA remember token
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // Auth attempt WITHOUT remember
        if (!Auth::attempt($credentials, false)) {
            throw ValidationException::withMessages([
                'username' => 'Username atau password salah.',
            ]);
        }

        // Regenerasi session agar aman (prevent fixation)
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }


    /**
     * Logout user (destroy session)
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        // Hapus session total
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
