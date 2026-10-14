<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ])->onlyInput('email');
        }

        $user = Auth::user();

        if ($user->status !== UserStatus::Active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = $user->status === UserStatus::PendingApproval
                ? 'Your account is pending approval. You cannot sign in yet.'
                : 'Your account is not active.';

            return back()->withErrors(['email' => $message])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->to($this->safeHome($request, $user));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function safeHome(Request $request, $user): string
    {
        $home = $this->homeFor($user);
        $intended = $request->session()->pull('url.intended');

        if ($user->hasAnyRole(['admin', 'seller', 'courier', 'logistics'])) {
            return $home;
        }

        if (! is_string($intended) || $intended === '') {
            return $home;
        }

        $path = parse_url($intended, PHP_URL_PATH) ?: $intended;
        foreach (['/admin', '/seller', '/courier', '/logistics'] as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix.'/')) {
                return $home;
            }
        }

        return $intended;
    }

    private function homeFor($user): string
    {
        if ($user->hasRole('admin')) {
            return route('admin.dashboard');
        }
        if ($user->hasRole('seller')) {
            return route('seller.dashboard');
        }
        if ($user->hasRole('courier')) {
            return route('courier.dashboard');
        }
        if ($user->hasRole('logistics')) {
            return route('logistics.dashboard');
        }

        return route('buyer.home');
    }
}
