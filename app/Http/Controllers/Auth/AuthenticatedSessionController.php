<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    // في method store
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        
        // التحقق من حالة تفعيل الحساب
        if (!Auth::user()->is_active) {
            Auth::logout();
            return back()->with([
                'error' => __('Your account has been deactivated. Please contact administrator.'),
            ]);
        }
    
        $request->session()->regenerate();
    
        return redirect()->intended(route('dashboard', absolute: false))->with('success', __('Welcome Back ').Auth::user()->name);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
