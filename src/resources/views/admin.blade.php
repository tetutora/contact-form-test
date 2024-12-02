@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

<style>
    svg.w-5.h-5 {
        /* paginateメソッドの矢印の大きさ調整のために追加 */
        width: 30px;
        height: 30px;
    }
</style>

@section('content')
<div class="admin-form">
    <div class="form__header">
        <p class="form__header-title">Admin</p>
    </div>
    <div class="search-list">
        <form action="" method="get">
            <div class="search-form">
                <div class="search-form__keyword">
                    <input class="search-keyword" type="search" name="keyword" placeholder="お名前、メールアドレスなどを入力" id="">
                </div>
                <div class="search-select__gender">
                    <select class="select__gender" name="gender" id="">
                        <option value="">性別</option>
                        <option value="1">男性</option>
                        <option value="2">女性</option>
                        <option value="3">その他</option>
                    </select>
                </div>
                <div class="search-select__category">
                    <select class="select__category" name="category" id="">
                        <option value="">お問い合せの種類</option>
                        <option value="1">商品のお届けについて</option>
                        <option value="2">商品の交換について</option>
                        <option value="3">商品トラブル</option>
                        <option value="3">ショップへのお問い合わせ</option>
                        <option value="3">その他</option>
                    </select>
                </div>
                <div class="search-data">
                    <input class="search-date-picker" type="date" name="date" id="date-picker" class="date-picker">
                </div>
                <div class="search__button">
                    <button type="submit" class="search__button-submit">検索</button>
                    <button class="search__button-reset" type="reset" onclick="window.location.href = '{{ url()->current() }}';">リセット</button>

                </div>
            </div>
        </form>
    </div>
    <div class="pagination-container">
        <div class="Pagination">
        {{ $contacts->links() }}
        </div>
    </div>

    <div class="data-table">
        <table class="data-table__inner">
            <tr class="data-table__row">
                <th class="data-table__header">お名前</th>
                <th class="data-table__header">性別</th>
                <th class="data-table__header">メールアドレス</th>
                <th class="data-table__header">お問い合せの種類</th>
                <th class="data-table__header"></th>
            </tr>
            @foreach ($contacts as $contact)
            <tr class="data-table__row">
                <td class="data-table__name">{{ $contact->last_name }} {{ $contact->first_name }}</td>
                <td class="data-table__gender">
                    @if ($contact->gender == 1) 男性
                    @elseif ($contact->gender == 2) 女性
                    @else その他
                    @endif
                </td>
                <td class="data-table__email">{{ $contact->email }}</td>
                <td class="data-table__category_id">
                    @if ($contact->category_id == 1) ご質問
                    @elseif ($contact->category_id == 2) ご意見
                    @else その他
                    @endif
                </td>
                <td class="table__button">
                    <button type="button" class="data-table__button" onclick="openModal(this)" data-id="{{ $contact->id }}">詳細</button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
