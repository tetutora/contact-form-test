@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__content">
    <div class="register__content-inner">
        <div class="register__content-title">
            <p>Register</p>
        </div>
        <div class="register-form">
            <form class="register-form__inner" action="/register" method="post">
                @csrf
                <div class="register-form__input">
                    <div class="register-fom__input-name">
                        <div class="input-label">お名前</div>
                        <input type="text" name="name" class="input-name" placeholder="例:山田　太郎" value="{{ old('name') }}">
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="register-form__input">
                    <div class="register-fom__input-email">
                        <div class="input-label">メールアドレス</div>
                        <input type="email" name="email" class="input-email" placeholder="例:test@example.com" value="{{ old('email') }}">
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="register-form__input">
                    <div class="register-fom__input-pass">
                        <div class="input-label">パスワード</div>
                        <input type="password" name="password" class="input-pass" placeholder="例:asdfghjkl">
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="register-form__input">
                    <div class="register-fom__input-pass_confirmation">
                        <div class="input-label">パスワード確認</div>
                        <input type="password" name="password_confirmation" class="input-pass" placeholder="確認用パスワード">
                    </div>
                </div>
                <div class="register-form__button">
                    <button type="submit" class="register-form__button-submit">登録</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
