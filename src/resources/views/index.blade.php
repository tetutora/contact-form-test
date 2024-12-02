@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact-form">
    <div class="contact-form__title">
        <p>Contact</p>
    </div>
    <div class="contact-table">
        <form action="/confirm" method="post">
    @csrf
    <table class="contact-table__inner">
        <tr class="contact-table__row">
            <th class="contact-table__header">お名前<span>※</span></th>
            <td class="contact-table__input-name">
                <input class="contact-table__input-last-name" type="text" name="last_name" placeholder="例：山田" value="{{ old('last_name', session('contact.last_name')) }}">
                @error('last_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <input class="contact-table__input-first-name" type="text" name="first_name" placeholder="例：太郎" value="{{ old('first_name', session('contact.first_name')) }}">
                @error('first_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </td>
        </tr>
        <tr class="contact-table__row">
            <th class="contact-table__header">性別<span>※</span></th>
            <td class="contact-table__input-gender">
                <div class="contact-table__gender">
                    <label>
                        <input type="radio" name="gender" value="男性" {{ (old('gender', session('contact.gender')) == '男性' || old('gender') == null) ? 'checked' : '' }}>男性
                    </label>
                    <label>
                        <input type="radio" name="gender" value="女性" {{ old('gender', session('contact.gender')) == '女性' ? 'checked' : '' }}>女性
                    </label>
                    <label>
                        <input type="radio" name="gender" value="その他" {{ old('gender', session('contact.gender')) == 'その他' ? 'checked' : '' }}>その他
                    </label>
                </div>
                @error('gender')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </td>
        </tr>
        <tr class="contact-table__row">
            <th class="contact-table__header">メールアドレス<span>※</span></th>
            <td class="contact-table__input-email">
                <input type="email" name="email" placeholder="例：test@example.com" class="contact-table__input-email-content" value="{{ old('email', session('contact.email')) }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </td>
        </tr>
        <tr class="contact-table__row">
            <th class="contact-table__header">電話番号<span>※</span></th>
            <td class="contact-table__input-tel">
                <input class="contact-table__tel" type="text" id="tel1" name="tel1" maxlength="5" size="4" placeholder="090" value="{{ old('tel1', session('contact.tel1')) }}"> -
                <input class="contact-table__tel" type="text" id="tel2" name="tel2" maxlength="5" size="5" placeholder="1234" value="{{ old('tel2', session('contact.tel2')) }}"> -
                <input class="contact-table__tel" type="text" id="tel3" name="tel3" maxlength="5" size="5" placeholder="5678" value="{{ old('tel3', session('contact.tel3')) }}">
                @error('tel1')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('tel2')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('tel3')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </td>
        </tr>
        <tr class="contact-table__row">
            <th class="contact-table__header">住所<span>※</span></th>
            <td class="contact-table__input-address">
                <input class="contact-table__address" type="text" name="address" placeholder="例：東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address', session('contact.address')) }}">
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </td>
        </tr>
        <tr class="contact-table__row">
            <th class="contact-table__header">建物名</th>
            <td class="contact-table__input-building">
                <input class="contact-table__building" type="text" name="building" placeholder="例:千駄ヶ谷マンション101" value="{{ old('building', session('contact.building')) }}">
            </td>
        </tr>
        <tr class="contact-table__row">
            <th class="contact-table__header">お問い合せの種類<span>※</span></th>
            <td class="contact-table__input-category">
                <select name="category" class="contact-table__select">
                    <option value="">選択してください</option>
                    <option value="ご質問" {{ old('category', session('contact.category')) == 'ご質問' ? 'selected' : '' }}>ご質問</option>
                    <option value="ご意見" {{ old('category', session('contact.category')) == 'ご意見' ? 'selected' : '' }}>ご意見</option>
                    <option value="その他" {{ old('category', session('contact.category')) == 'その他' ? 'selected' : '' }}>その他</option>
                </select>
                @error('category')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </td>
        </tr>
        <tr class="contact-table__row">
            <th class="contact-table__header">お問い合せ内容<span>※</span></th>
            <td class="contact-table__input-content">
                <textarea name="detail" class="contact-table__content" placeholder="お問い合せ内容をご記載ください" rows="10">{{ old('detail', session('contact.detail')) }}</textarea>
                @error('detail')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </td>
        </tr>
    </table>
    <div class="contact-form__button">
    <button class="contact-form__button-submit" type="submit">確認画面</button>
</div>
</form>

    </div>
</div>
@endsection
