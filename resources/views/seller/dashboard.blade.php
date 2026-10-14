@extends('layouts.dashboard')
@section('title', 'seller_center')
@section('nav')
    <a class="active" href="{{ route('seller.dashboard') }}">Dashboard</a>
    <a href="{{ route('seller.catalog') }}">Catalog Manager</a>
    <a href="{{ route('seller.orders') }}">Orders</a>
    <a href="{{ route('seller.promos') }}">Store Promos</a>
    <a href="{{ route('seller.shipments') }}">10_Shipment_Management 1</a>
@endsection
@section('content')
    <h1>seller_center</h1>
    <p>Confirm / prepare / pack / waybill flows come next.</p>
@endsection
