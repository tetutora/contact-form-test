@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm-content">
    <div class="confirm-content__title">
        <p>Confirm</p>
    </div>
    <div class="confirm-table">
        <form action="/thanks" method="get">
            @csrf
            <table class="confirm-table__inner">
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お名前</th>
                    <td class="confirm-table__input">
                        <input class="confirm-table__input-name" type="text" name="name" value="{{ $contact['last_name'] ?? '' }} {{ $contact['first_name'] ?? '' }}" readonly>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">性別</th>
                    <td class="confirm-table__input">
                        <input class="confirm-table__input-gender" type="text" name="gender" value="{{ $contact['gender'] ?? '' }}" readonly>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">メールアドレス</th>
                    <td class="confirm-table__input">
                        <input class="confirm-table__input-email" type="text" name="email" value="{{ $contact['email'] ?? '' }}" readonly>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">電話番号</th>
                    <td class="confirm-table__input">
                        <input class="confirm-table__input-tel" type="text" name="tel" value="{{ $contact['tel1'] ?? '' }} {{ $contact['tel2'] ?? '' }} {{ $contact['tel3'] ?? '' }}" readonly>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">住所</th>
                    <td class="confirm-table__input">
                        <input class="confirm-table__input-address" type="text" name="address" value="{{ $contact['address'] ?? '' }}" readonly>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">建物名</th>
                    <td class="confirm-table__input">
                        <input class="confirm-table__input-building" type="text" name="building" value="{{ $contact['building'] ?? '' }}" readonly>
                    </td>
                </tr>
                <tr class="confirm-table__row">
    <th class="confirm-table__header">お問い合せの種類</th>
    <td class="confirm-table__input">
        <input class="confirm-table__input-category" type="text" name="category" value="{{ $contact['category_name'] ?? '' }}" readonly>
    </td>
</tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合せ内容</th>
                    <td class="confirm-table__input">
                        <input class="confirm-table__input-content" type="text" name="detail" value="{{ $contact['detail'] ?? '' }}" readonly>
                    </td>
                </tr>
            </table>
            <div class="confirm-table__button">
                <button type="submit" class="confirm-table__button-submit">送信</button>
            </div>
        </form>
        <form action="/" method="get">
            @csrf
            <div class="confirm-table__button-correction">
                <button type="submit" class="confirm-table__button-correction-submit">修正</button>
            </div>
        </form>
    </div>
</div>
@endsection
