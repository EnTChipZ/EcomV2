<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('storefront.about');
    }

    public function contact(): View
    {
        return view('storefront.contact');
    }

    public function checkout(): View
    {
        $sessionId = session()->getId();
        $cart = \App\Models\Cart::query()
            ->when(auth()->check(), fn ($q) => $q->where('user_id', auth()->id()), fn ($q) => $q->where('session_id', $sessionId))
            ->with(['items.variant.product.images'])
            ->first();

        return view('storefront.checkout', compact('cart'));
    }

    public function place(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:32'],
            'email' => ['required', 'email'],
            'gateway' => ['required', 'in:cod'],
        ]);

        return back()->with('toast', 'COD checkout captured. Order pipeline is still a stub in this slice.');
    }

    public function profile(): View
    {
        return view('storefront.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
            'phone' => ['nullable', 'string', 'max:32'],
        ]);

        $request->user()->update($data);

        return back()->with('toast', 'Account info saved');
    }

    public function help(): View
    {
        return view('storefront.help');
    }
}
