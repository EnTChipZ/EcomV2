@extends('layouts.dashboard')
@section('title', 'Admin 1')
@section('nav')
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a class="active" href="{{ route('admin.verifications') }}">Admin 1 · Verifications</a>
@endsection
@section('content')
    <h1>Admin 1 — verification queue</h1>
    @if (session('status')) <p>{{ session('status') }}</p> @endif
    @forelse ($users as $user)
        <div style="background:#fff;padding:16px;margin-bottom:12px;">
            <strong>{{ $user->name }}</strong> · {{ $user->email }} · {{ $user->roles->pluck('name')->join(', ') }}
            <form method="post" action="{{ route('admin.verifications.decide', $user) }}" style="margin-top:8px;">
                @csrf
                <textarea name="notes" placeholder="Notes"></textarea>
                <button name="decision" value="approved">Approve</button>
                <button name="decision" value="rejected">Reject</button>
            </form>
        </div>
    @empty
        <p>No pending buyer/seller/logistics accounts.</p>
    @endforelse
@endsection
