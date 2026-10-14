@extends('layouts.dashboard')
@section('title', 'Admin')
@section('nav')
    <a class="active" href="{{ route('admin.dashboard') }}">01_Admin_Dashboard 1</a>
    <a href="{{ route('admin.verifications') }}">Admin 1 · Verifications</a>
    <a href="{{ route('admin.cms') }}">Admin 2 · CMS</a>
    <a href="{{ route('admin.users') }}">Admin 3 · Users</a>
    <a href="{{ route('admin.disputes') }}">Disputes_Admin</a>
    <a href="{{ route('admin.reports') }}">13_Reports_Analytics 1</a>
@endsection
@section('content')
    <h1>Admin dashboard</h1>
    <p>Pending registrations: {{ $pendingCount }}</p>
    <p>Frame: {{ $figma }}</p>
@endsection
