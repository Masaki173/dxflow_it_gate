<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

         $user = Auth::user();

    switch ($user->roleName()) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'employee':
            return redirect()->route('inquiry.form');
        case 'it':
            return redirect()->route('it.index');
        case 'software':
            return redirect()->route('software.index');
        case 'hardware':
            return redirect()->route('hardware.index');
        case 'network':
            return redirect()->route('network.index');
        default:
            return redirect('/');
    }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

}
