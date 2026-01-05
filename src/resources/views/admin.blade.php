@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin">
    <h2 class="admin__title">Admin</h2>

    {{-- 検索フォーム --}}
    <form class="search-form" method="GET" action="{{ url('/search') }}">
        <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">

        <select name="gender">
            <option value="">性別</option>
            <option value="1" {{ request('gender') == 1 ? 'selected' : '' }}>男性</option>
            <option value="2" {{ request('gender') == 2 ? 'selected' : '' }}>女性</option>
            <option value="3" {{ request('gender') == 3 ? 'selected' : '' }}>その他</option>
        </select>

        <select name="category_id" class="select-category">
            <option value="">お問い合わせの種類</option>
            <option value="1" {{ request('category_id') == 1 ? 'selected' : '' }}>商品のお届けについて</option>
            <option value="2" {{ request('category_id') == 2 ? 'selected' : '' }}>商品の交換について</option>
            <option value="3" {{ request('category_id') == 3 ? 'selected' : '' }}>商品トラブル</option>
            <option value="4" {{ request('category_id') == 4 ? 'selected' : '' }}>ショップへのお問い合わせ</option>
            <option value="5" {{ request('category_id') == 5 ? 'selected' : '' }}>その他</option>
        </select>

        <input type="date" name="date" value="{{ request('date') }}">

        <button type="submit">検索</button>
        <a href="{{ url('/reset') }}" class="reset-btn">リセット</a>
    </form>

    {{-- ページネーション：検索/リセットの下、右寄せ --}}
    <div class="pagination-wrapper">
        {{ $contacts->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>

    {{-- エクスポート --}}
    <button class="export" id="export-btn">エクスポート</button>

    {{-- テーブル --}}
    <table class="admin-table">
        <thead>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                <td>{{ $contact->gender === 1 ? '男性' : ($contact->gender === 2 ? '女性' : 'その他') }}</td>
                <td>{{ $contact->email }}</td>
                <td>
                    @switch($contact->category_id)
                    @case(1) 商品のお届けについて @break
                    @case(2) 商品の交換について @break
                    @case(3) 商品トラブル @break
                    @case(4) ショップへのお問い合わせ @break
                    @case(5) その他 @break
                    @default -
                    @endswitch
                </td>
                <td>
                    <button type="button" class="detail-btn"
                        data-id="{{ $contact->id }}"
                        data-last_name="{{ $contact->last_name }}"
                        data-first_name="{{ $contact->first_name }}"
                        data-gender="{{ $contact->gender === 1 ? '男性' : ($contact->gender === 2 ? '女性' : 'その他') }}"
                        data-email="{{ $contact->email }}"
                        data-tel="{{ $contact->tel }}"
                        data-address="{{ $contact->address }}"
                        data-building="{{ $contact->building }}"
                        data-category="@switch($contact->category_id)
                            @case(1) 商品のお届けについて @break
                            @case(2) 商品の交換について @break
                            @case(3) 商品トラブル @break
                            @case(4) ショップへのお問い合わせ @break
                            @case(5) その他 @break
                            @default -
                            @endswitch"
                        data-detail="{{ $contact->detail }}">
                        詳細
                    </button>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- モーダル --}}
<div id="detail-modal" class="detail-modal">
    <div class="modal-inner">
        <span class="modal-close">&times;</span>
        <div class="modal-content"></div>

        {{-- 削除フォーム --}}
        <form id="delete-form" method="POST">
            @csrf
            <button type="submit" class="delete-btn">削除</button>
        </form>
    </div>
</div>
<div id="modal-overlay" class="modal-overlay"></div>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('detail-modal');
        const overlay = document.getElementById('modal-overlay');
        const modalContent = modal.querySelector('.modal-content');
        const closeBtn = modal.querySelector('.modal-close');
        const deleteForm = document.getElementById('delete-form');
        const exportBtn = document.getElementById('export-btn');

        // 詳細ボタン
        document.querySelectorAll('.detail-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const d = btn.dataset;

                // ★ここがポイント：2列(grid)のHTMLを作る
                modalContent.innerHTML = `
                <div class="modal-grid">
                    <div class="modal-label">お名前</div><div class="modal-value">${d.last_name} ${d.first_name}</div>
                    <div class="modal-label">性別</div><div class="modal-value">${d.gender}</div>
                    <div class="modal-label">メールアドレス</div><div class="modal-value">${d.email}</div>
                    <div class="modal-label">電話番号</div><div class="modal-value">${d.tel}</div>
                    <div class="modal-label">住所</div><div class="modal-value">${d.address}</div>
                    <div class="modal-label">建物名</div><div class="modal-value">${d.building ?? ''}</div>
                    <div class="modal-label">お問い合わせの種類</div><div class="modal-value">${d.category ?? ''}</div>
                    <div class="modal-label">お問い合わせ内容</div>
                    <div class="modal-value">${(d.detail ?? '').replace(/\n/g,'<br>')}</div>
                </div>
            `;

                deleteForm.action = `/delete/${d.id}`;

                modal.classList.add('active');
                overlay.classList.add('active');
            });
        });

        const close = () => {
            modal.classList.remove('active');
            overlay.classList.remove('active');
        };

        closeBtn.addEventListener('click', close);
        overlay.addEventListener('click', close);

        // 削除
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            }).then(res => {
                if (res.ok) location.reload();
                else alert('削除に失敗しました');
            }).catch(() => alert('削除に失敗しました'));
        });

        // エクスポート（検索条件付き）
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                const params = new URLSearchParams(window.location.search);
                window.location.href = "{{ route('contact.export') }}?" + params.toString();
            });
        }
    });
</script>
@endsection