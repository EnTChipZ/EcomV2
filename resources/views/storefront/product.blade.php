@extends('layouts.storefront')

@section('title', $product->name)
@section('crumb')
    <a href="{{ route('products.index') }}">Shop</a>
    <span>/</span>
    <a href="{{ route('products.index', ['category' => $product->category?->slug]) }}">{{ $product->category?->name }}</a>
    <span>/</span>
    <span>{{ $product->name }}</span>
@endsection

@section('content')
@php
    $variant = $product->defaultVariant();
    $images = $product->images;
    $main = $product->primaryImage();
@endphp
<section class="s3-main" data-figma="Single Product 1:3733">
    <div class="s3-pdp">
        <div class="s3-gallery">
            <div class="s3-gallery-main">
                @if($main)
                    <img src="{{ asset($main->path) }}" alt="{{ $product->name }}">
                @endif
                <span class="s3-new">new</span>
            </div>
            <div class="s3-thumbs">
                @forelse($images as $image)
                    <img src="{{ asset($image->path) }}" alt="">
                @empty
                    <span></span><span></span><span></span>
                @endforelse
            </div>
        </div>
        <div>
            <div class="s3-stars">★★★★★ <span style="color:#888;">(5)</span></div>
            <h1>{{ $product->name }}</h1>
            <div class="pdp-price">${{ number_format($variant?->price ?? 0, 2) }}
                @if($variant?->compare_at_price) - ${{ number_format($variant->compare_at_price, 2) }} @endif
            </div>
            <ul class="s3-bullets">
                <li>Intel LGA 1700 Socket: Supports 13th & 12th Gen Intel Core</li>
                <li>DDR5 Compatible: 4*SMD DIMMs with XMP 3.0 Memory</li>
                <li>Commanding Power Design: Twin 16+1+2 Phases Digital VRM</li>
            </ul>
            <span class="s3-chip">free shipping</span>
            <span class="s3-chip">free gift</span>
            <div style="margin:16px 0;">
                <strong>Color:</strong> Midnight Blue
                <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:8px;">
                    @foreach($images->take(3) as $image)
                        <img src="{{ asset($image->path) }}" alt="" width="45" height="35" style="object-fit:contain;background:#f7f7fb;">
                    @endforeach
                </div>
                <p style="margin-top:12px;"><strong>memory size:</strong> 128GB</p>
                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                    @foreach(['64GB','128GB','256GB','512GB'] as $mem)
                        <span style="border:1px solid #e5e5ee;padding:8px 16px;font-size:13px;">{{ $mem }}</span>
                    @endforeach
                </div>
            </div>
            <div class="s3-gift">
                <img src="{{ asset('images/storefront/gift.svg') }}" alt="" width="90">
                <div>
                    <p>Buy 2 items get 1 free gift</p>
                    <p>Buy 3 items extra 10% off</p>
                    <small>Promotion will expires in: 9h00pm, 25/5/2024</small>
                </div>
            </div>
            <div class="s3-meta">
                <div><strong>SKU:</strong> {{ $variant?->sku }}</div>
                <div><strong>Category:</strong> {{ $product->category?->name }}</div>
                <div><strong>Brand:</strong> {{ $product->seller?->sellerProfile?->business_name ?? 'JEAP' }}</div>
            </div>
        </div>
        <aside>
            <div class="s3-paycard">
                <small>Total Price:</small>
                <div class="price">${{ number_format($variant?->price ?? 0, 2) }}</div>
                <p class="in-stock">● In stock</p>
                <form method="post" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_variant_id" value="{{ $variant?->id }}">
                    <div class="s3-qty" style="width:100%;height:53px;border-radius:4px;">
                        <button type="button" onclick="this.nextElementSibling.stepDown()">−</button>
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                    </div>
                    <button class="s3-add" type="submit">Add To Cart</button>
                </form>
                <a class="s3-buy" href="{{ route('products.pay', $product->slug) }}">buy with <img src="{{ asset('images/storefront/paypal.svg') }}" alt=""></a>
                <p style="font-size:13px;margin-top:16px;">Wishlist · Compare</p>
                <small>Guaranteed Safe Checkout</small>
                <img src="{{ asset('images/storefront/pay.svg') }}" alt="" style="display:block;margin-top:8px;">
            </div>
            <div class="s3-paycard" style="margin-top:10px;">
                <small>Quick Order 24/7</small>
                <h5>{{ config('jeap.hotline') }}</h5>
            </div>
            <p style="margin-top:12px;">🚚 Ships from Philippines</p>
        </aside>
    </div>
    <div class="s3-related">
        <h3>frequently bought together</h3>
        <div class="s3-relgrid">
            @foreach(($related ?? collect())->take(5) as $item)
                @php $v = $item->defaultVariant(); $img = $item->primaryImage(); @endphp
                <article class="s3-relcard">
                    <a href="{{ route('products.show', $item->slug) }}">
                        @if($img)<img src="{{ asset($img->path) }}" alt="{{ $item->name }}">@endif
                        <h6>{{ $item->name }}</h6>
                        <div class="price">${{ number_format($v?->price ?? 0, 2) }}</div>
                    </a>
                </article>
            @endforeach
        </div>
        <h3 style="margin-top:40px;">related products</h3>
        <div class="s3-relgrid">
            @foreach(($related ?? collect())->take(5) as $item)
                @php $v = $item->defaultVariant(); $img = $item->primaryImage(); @endphp
                <article class="s3-relcard">
                    <a href="{{ route('products.show', $item->slug) }}">
                        @if($img)<img src="{{ asset($img->path) }}" alt="{{ $item->name }}">@endif
                        <div class="s3-stars">★★★★★</div>
                        <h6>{{ $item->name }}</h6>
                        <div class="price">${{ number_format($v?->price ?? 0, 2) }}</div>
                        <span class="s3-chip">free shipping</span>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
