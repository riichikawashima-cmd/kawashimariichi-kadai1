@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')

<div class="confirm-content">
    <h1 class="confirm-title">Confirm</h1>
    <form action="{{ url('/thanks') }}" method="POST">
        @csrf
        <table class="confirm-table">
            <tr>
                <th>お名前</th>
                <td>{{ $contact['last_name'] }} {{ $contact['first_name'] }}</td>
            </tr>
            <tr>
                <th>性別</th>
                <td>
                    @if($contact['gender'] == 1)
                    男性
                    @elseif($contact['gender'] == 2)
                    女性
                    @else
                    その他
                    @endif
                </td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{ $contact['email'] }}</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>{{ $contact['tel1'] }}{{ $contact['tel2'] }}{{ $contact['tel3'] }}</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>{{ $contact['address'] }}</td>
            </tr>
            <tr>
                <th>建物名</th>
                <td>{{ $contact['building'] }}</td>
            </tr>
            <tr>
                <th>お問い合わせの種類</th>
                <td>{{ $categories[$contact['category_id']] ?? '' }}</td>
            </tr>
            <tr>
                <th>お問い合わせ内容</th>
                <td>
                    <p>{{ $contact['content'] }}</p>
                </td>
            </tr>
        </table>
    </form>
    <div class="confirm-buttons">
        <form action="{{ url('/thanks') }}" method="POST">
            @csrf
            @foreach ($contact as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button type="submit" class="btn btn-submit">送信</button>
        </form>
        <form action="{{ url('/back') }}" method="POST">
            @csrf
            @foreach($contact as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button type="submit" class="btn btn-back">修正</button>
        </form>
    </div>
</div>

@endsection