@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-page">
    <h1 class="register-title">Register</h1>
    <div class="register-box">
        {{-- バリデーションエラー --}}

        <form action="{{ url('/register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">お名前</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="山田 太郎">
                @error('name')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="test@example.com">
                @error('email')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" placeholder="coachtechno6">
                @error('password')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="register-btn">登録</button>
        </form>
    </div>
</div>
@endsection