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
            return redirect()->route('register');
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

        // return redirect()->intended(RouteServiceProvider::HOME);
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
    
//     protected function authenticated(Request $request, $user)
// {
//     switch ($user->department) {
//         case 'employee':
//             // 一般社員 → 問い合わせフォーム
//             return redirect()->route('employee.inquiry');

//         case 'it':
//             // IT部門 → タスク振り分けページ
//             return redirect()->route('it.tasks.index');

//         case 'software':
//             return redirect()->route('software.tasks.index');

//         case 'hardware':
//             return redirect()->route('hardware.tasks.index');

//         case 'network':
//             return redirect()->route('network.tasks.index');

//         case 'admin':
//             return redirect()->route('admin.dashboard');

//         default:
//             // 未定義の部門はトップページなどに飛ばす
//             return redirect('/');
//     }
// }

}
