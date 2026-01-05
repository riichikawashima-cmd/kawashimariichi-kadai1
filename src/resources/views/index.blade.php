@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="form__content">
    <div class="create-form">
        <h1 class="create-form__item">Contact</h1>
    </div>
    <div class="contact-form__content">
        <form class="form" action="{{ url('/confirm') }}" method="POST">
            @csrf
            {{-- お名前 --}}
            <div class="form__group">
                <div class="form__label-area">
                    <span class="label">お名前</span>
                    <span class="required">※</span>
                </div>
                <div class="form__input-area name-inputs">
                    <div class="input-wrapper">
                        <input type="text" name="last_name" placeholder="例）山田" value="{{ old('last_name') }}">
                        @error('last_name') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div class="input-wrapper">
                        <input type="text" name="first_name" placeholder="例）太郎" value="{{ old('first_name') }}">
                        @error('first_name') <div class="error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- 性別 --}}
            <div class="form__group">
                <div class="form__label-area">
                    <span class="label">性別</span>
                    <span class="required">※</span>
                </div>
                <div class="form__input-area gender-inputs">
                    <label><input type="radio" name="gender" value="1" {{ old('gender') == 1 ? 'checked' : '' }}> 男性</label>
                    <label><input type="radio" name="gender" value="2" {{ old('gender') == 2 ? 'checked' : '' }}> 女性</label>
                    <label><input type="radio" name="gender" value="3" {{ old('gender') == 3 ? 'checked' : '' }}> その他</label>
                </div>
                @error('gender') <div class="error">{{ $message }}</div> @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="form__group">
                <div class="form__label-area">
                    <span class="label">メールアドレス</span>
                    <span class="required">※</span>
                </div>
                <div class="form__input-area">
                    <input type="email" name="email" placeholder="例:test@example.com" value="{{ old('email') }}">
                    @error('email') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- 電話番号 --}}
            <div class="form__group">
                <div class="form__label-area">
                    <span class="label">電話番号</span>
                    <span class="required">※</span>
                </div>
                <div class="form__input-area tel-inputs">
                    <div class="input-wrapper">
                        <input type="tel" name="tel1" placeholder="080" value="{{ old('tel1') }}">
                        @error('tel1') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <span class="tel-hyphen">-</span>
                    <div class="input-wrapper">
                        <input type="tel" name="tel2" placeholder="1234" value="{{ old('tel2') }}">
                        @error('tel2') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <span class="tel-hyphen">-</span>
                    <div class="input-wrapper">
                        <input type="tel" name="tel3" placeholder="5678" value="{{ old('tel3') }}">
                        @error('tel3') <div class="error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- 住所 --}}
            <div class="form__group">
                <div class="form__label-area">
                    <span class="label">住所</span>
                    <span class="required">※</span>
                </div>
                <div class="form__input-area">
                    <input type="text" name="address" placeholder="例：東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
                    @error('address') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- 建物名 --}}
            <div class="form__group">
                <div class="form__label-area">
                    <span class="label">建物名</span>
                </div>
                <div class="form__input-area">
                    <input type="text" name="building" placeholder="例：千駄ヶ谷マンション101" value="{{ old('building') }}">
                </div>
            </div>

            {{-- お問い合わせの種類 --}}
            <div class="form__group">
                <div class="form__label-area">
                    <span class="label">お問い合わせの種類</span>
                    <span class="required">※</span>
                </div>
                <div class="form__input-area">
                    <select name="category_id">
                        <option value="" selected>選択してください</option>
                        @foreach ($categories as $id => $label)
                        <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>

                    @error('category_id') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- お問い合わせ内容 --}}
            <div class="form__group">
                <div class="form__label-area">
                    <span class="label">お問い合わせ内容</span>
                    <span class="required">※</span>
                </div>
                <div class="form__input-area">
                    <textarea name="content" rows="5" placeholder="お問い合わせ内容をご記載ください">{{ old('content') }}</textarea>
                    @error('content') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- ボタン --}}
            <div class="form__button">
                <button type="submit" class="form__button-submit">確認画面</button>
            </div>
        </form>
    </div>
</div>

@endsection