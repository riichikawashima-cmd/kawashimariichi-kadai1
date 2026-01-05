@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-page">
    <h1 class="login-title">Login</h1>
    <div class="login-box">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="test@example.com">
                @error('email')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" placeholder="password123">
                @error('password')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="login-btn">ログイン</button>
        </form>
    </div>
</div>
@endsection

{{-- 右上ボタン差し込み --}}
@section('header-btn')
<a href="{{ url('/register') }}" class="header-btn">register</a>
@endsection