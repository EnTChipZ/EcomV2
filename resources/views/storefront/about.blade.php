@extends('layouts.storefront')

@section('title', 'About')
@section('crumb')
    <span>About</span>
@endsection

@section('content')
<section class="s3-main" data-figma="About 1:4158">
    <div class="s3-about-hero">
        <div class="s3-maincard">
            <img src="{{ asset('images/storefront/about-banner.svg') }}" alt="">
            <div class="s3-stats">
                <p><strong>our purpose is to enrich and transform lives through the power of technology</strong></p>
                <div>
                    <h2>$12,5M</h2>
                    <small>total revenue from 2001 - 2023</small>
                </div>
                <div>
                    <h2>12K+</h2>
                    <small>orders delivered successful on everyday</small>
                </div>
                <div>
                    <h2>725+</h2>
                    <small>store and office in PH and worldwide</small>
                </div>
            </div>
        </div>
    </div>
    <div class="s3-about-split">
        <img src="{{ asset('images/storefront/about-side.svg') }}" alt="">
        <div class="s3-infocard">
            <p>We connect millions of buyers and sellers around the world, empowering people & creating economic opportunity for all.</p>
            <p>Within our markets, millions of people around the world connect, both online and offline, to make, sell and buy unique goods. We also offer a wide range of Seller Services and tools that help creative entrepreneurs start, manage & scale their businesses.</p>
            <a class="s3-btn" href="{{ route('products.index') }}" style="background:#fff;color:#111;">▶ our showreel</a>
        </div>
    </div>
    <div class="s3-feats">
        <article class="s3-feat">
            <h3>100% authentic</h3>
            <p>JEAP just distribute 100% authorized products & guarantee quality. Pickup and delivery stay on our own hub-and-spoke network.</p>
        </article>
        <article class="s3-feat">
            <h3>fast</h3>
            <p>Fast shipping with a lots of option to delivery. 100% guarantee that your goods alway on time and perserve quality.</p>
        </article>
        <article class="s3-feat">
            <h3>affordable</h3>
            <p>We offer an affordable & competitive price with a lots of special promotions.</p>
        </article>
    </div>
    <div style="padding:0 30px 40px;">
        <h3>our mission and vision</h3>
        <p>JEAP is a Philippine multi-vendor marketplace with in-house logistics. Sellers pack, pickup riders bring parcels to the sorting center, and delivery riders take them to buyers. Commission is 10% when an order is completed.</p>
        <img src="{{ asset('images/storefront/about-wide.svg') }}" alt="" style="width:100%;height:400px;object-fit:cover;margin-top:20px;">
    </div>
</section>
@endsection
