@extends('layouts.storefront')

@section('title', 'Chackout')
@section('crumb')
    <a href="{{ route('about') }}">pages</a>
    <span>/</span>
    <span>checkout</span>
@endsection

@section('content')
@php $items = $cart?->items ?? collect(); $total = $items->sum(fn ($i) => $i->unit_price * $i->quantity); @endphp
<section class="s3-main" data-figma="Chackout 7:1501">
    <h3 style="padding:48px 48px 0;margin:0;">checkout</h3>
    <div class="s3-check">
        <div>
            <div class="s3-alert">
                @guest Returning customer? <a href="{{ route('login') }}">Click here to log in</a>
                @else Signed in as {{ auth()->user()->email }}
                @endguest
            </div>
            <form id="checkout-form" method="post" action="{{ route('checkout.place') }}">
                @csrf
                <h3>Billing Detail</h3>
                <div class="s3-two">
                    <div class="s3-field"><label>First Name</label><input name="first_name" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required></div>
                    <div class="s3-field"><label>Last Name</label><input name="last_name" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required></div>
                </div>
                <div class="s3-field"><label>Company Name (optional)</label><input name="company"></div>
                <div class="s3-field">
                    <label>Country / Region</label>
                    <select name="country"><option>Philippines</option><option>United States (US)</option></select>
                </div>
                <div class="s3-field"><label>Street Address</label><input name="street" placeholder="House number and street name ..." required></div>
                <div class="s3-field"><input name="street2" placeholder="Apartment, suite, unit, etc (Optional)"></div>
                <div class="s3-field"><label>Town / City</label><input name="city" required></div>
                <div class="s3-field">
                    <label>State / County</label>
                    <select name="province"><option>Laguna</option><option>Metro Manila</option></select>
                </div>
                <div class="s3-field"><label>Zip Code</label><input name="zip"></div>
                <div class="s3-field"><label>Phone Number</label><input name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required></div>
                <div class="s3-field"><label>Email Address</label><input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required></div>
                <label style="display:flex;gap:8px;margin:12px 0 24px;"><input type="checkbox" name="create_account"> Create an account?</label>
                <h3>Additional Information</h3>
                <div class="s3-field">
                    <label>Order Notes (optional)</label>
                    <textarea name="notes" placeholder="Note about your order, e.g. special note for delivery"></textarea>
                </div>
                <input type="hidden" name="gateway" value="cod">
            </form>
        </div>
        <aside>
            <div class="s3-alert">Have a coupon? Click here to enter your code</div>
            <h3>Your Order</h3>
            <div class="s3-ordercard">
                <div class="s3-line"><span>Product</span><span>sub total</span></div>
                @forelse($items as $item)
                    <div class="s3-line" style="align-items:flex-start;">
                        <div style="display:flex;gap:12px;">
                            @if($item->variant?->product?->primaryImage())
                                <img src="{{ asset($item->variant->product->primaryImage()->path) }}" alt="" width="60" height="60" style="object-fit:contain;background:#f7f7fb;">
                            @endif
                            <div>
                                {{ $item->variant?->product?->name }}<br>
                                <small>x {{ $item->quantity }}</small>
                            </div>
                        </div>
                        <strong>${{ number_format($item->unit_price * $item->quantity, 2) }}</strong>
                    </div>
                @empty
                    <p>Cart is empty.</p>
                @endforelse
                <p>Worldwide Standard Shipping Free <span style="float:right;">+ $0.00</span></p>
                <div class="s3-line" style="border:0;"><strong>Order Total</strong><strong>${{ number_format($total, 2) }}</strong></div>
            </div>
            <div class="s3-paymethods">
                <label><input type="radio" name="pay_ui" disabled> Direct Bank Transfer</label>
                <label><input type="radio" name="pay_ui" checked> Cash on Delivery</label>
                <label><input type="radio" name="pay_ui" disabled> Paypal <img src="{{ asset('images/storefront/paypal.svg') }}" alt="" width="59" height="15"></label>
                <button class="s3-btn wide" type="submit" form="checkout-form">place order</button>
            </div>
        </aside>
    </div>
</section>
@endsection
