@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

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
                        <option value="0">全て</option>
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
                        <option value="4">ショップへのお問い合わせ</option>
                        <option value="5">その他</option>
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
        {{ $contacts->links('vendor.pagenation.custom') }}
        </div>
    </div>
    <a href="{{ route('admin.export') }}">
        <button type="button" class="export-button">エクスポート</button>
    </a>

    <div class="data-table">
        <table class="data-table__inner">
            <tr class="data-table__row">
                <th class="data-table__header-name">お名前</th>
                <th class="data-table__header-gender">性別</th>
                <th class="data-table__header-email">メールアドレス</th>
                <th class="data-table__header-category">お問い合せの種類</th>
                <th class="data-table__header"></th>
            </tr>
            @foreach ($contacts as $contact)
            <tr class="data-table__row">
                <td class="data-table__name">
                    {{ $contact->last_name }} {{ $contact->first_name }}
                </td>
                <td class="data-table__gender">
                    @if ($contact->gender == 1) 男性
                    @elseif ($contact->gender == 2) 女性
                    @else その他
                    @endif
                </td>
                <td class="data-table__email">
                    {{ $contact->email }}
                </td>
                <td class="data-table__category_id">
                    @if ($contact->category_id == 1) 商品のお届けについて
                    @elseif ($contact->category_id == 2) 商品の交換について
                    @elseif ($contact->category_id == 3) 商品トラブル
                    @elseif ($contact->category_id == 4) ショップへの問い合わせ
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
<!-- モーダルのHTML -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">✖️</span>
        <div id="modal-content">
            <!-- 詳細情報がここに表示されます -->
        </div>
        <div class="delete-button">
            <button id="delete-button" class="delete-button-submit" onclick="deleteContact()">削除</button>
        </div>
    </div>
</div>

<script>
    // モーダルを開く関数
    function openModal(button) {
        // ボタンから取得したIDを使ってデータを取得する処理
        const contactId = button.getAttribute('data-id');
        currentContactId = contactId;

        // ここでAjaxを使って、詳細情報をサーバーから取得する
        fetch(`/admin/${contactId}`)
            .then(response => response.json())
            .then(data => {
                // モーダル内のコンテンツを更新
                document.getElementById('modal-content').innerHTML = `
                    <p><strong>お名前:</strong> ${data.name}</p>
                    <p><strong>メールアドレス:</strong> ${data.email}</p>
                    <p><strong>性別:</strong> ${data.gender}</p>
                    <p><strong>電話番号:</strong> ${data.tel}</p>
                    <p><strong>住所:</strong> ${data.address}</p>
                    <p><strong>建物名:</strong> ${data.building}</p>
                    <p><strong>お問い合せの種類:</strong> ${data.category}</p>
                    <p><strong>内容:</strong> ${data.detail}</p>
                `;
                // モーダルを表示
                document.getElementById('modal').style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching contact details:', error);
            });
    }

    // モーダルを閉じる関数
    function closeModal() {
        document.getElementById('modal').style.display = 'none';
    }

    // 削除ボタンをクリックしたときの処理
    function deleteContact() {
        if (currentContactId === null) {
            alert("削除対象が選択されていません");
            return;
        }
        // サーバーに削除リクエストを送信
        fetch(`/admin/${currentContactId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                alert("削除しました");

                // モーダルを閉じる
                closeModal();

                // ページをリロードして削除を反映させる
                window.location.reload();
            } else {
                alert("削除に失敗しました");
            }
        })
        .catch(error => {
            console.error('Error deleting contact:', error);
            alert("削除に失敗しました");
        });
    }

    // モーダルの外をクリックした場合にも閉じる
    window.onclick = function(event) {
        if (event.target === document.getElementById('modal')) {
            closeModal();
        }
    }
</script>
@endsection
