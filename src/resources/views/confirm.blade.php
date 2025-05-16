@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm-content">
    <h2 class="title">Confirm</h2>

    <form class="confirm-table__form" method="POST" action="{{route('send')}}">
        @csrf
        <table class="confirm-table">
            <tr class="confirm-table-row">
                <th class="heading">お名前</th>
                <td class="input">{{ $inputs['last_name'] }} {{ $inputs['first_name'] }}</td>
            </tr>
            <tr class="confirm-table-row">
                <th class="heading">性別</th>
                <td class="input">{{ $inputs['gender_label'] }}</td>
            </tr>
            <tr class="confirm-table-row">
                <th class="heading">メールアドレス</th>
                <td class="input">{{ $inputs['email'] }}</td>
            </tr>
            <tr class="confirm-table-row">
                <th class="heading">電話番号</th>
                <td class="input">{{ $inputs['tel'] }}</td>
            </tr>
            <tr class="confirm-table-row">
                <th class="heading"></th>
                <td class="input">{{ $inputs['address'] }}</td>
            </tr>
            <tr class="confirm-table-row">
                <th class="heading"></th>
                <td class="input">{{ $inputs['building'] ?? '（未入力）' }}</td>
            </tr>
            <tr class="confirm-table-row">
                <th class="heading"></th>
                <td class="input">{{ $inputs['category_name'] }}</td>
            </tr>
            <tr class="confirm-table-row">
                <th class="heading"></th>
                <td class="input">{!! nl2br(e($inputs['detail'])) !!}</td>
            </tr>
        </table>

        {{-- hidden input --}}
        @foreach($inputs as $key => $value)
        @if(!in_array($key, ['gender_label', 'tel', 'category_name']))
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
        @endforeach
        <div class="button-flex-wrapper">
            <div class="send_form_button">
                <button class="submit-button">送信</button>
            </div>
    </form>
    <form method="POST" name="form_button" action="{{route('confirm')}}">
        @csrf
        <div class="back_form_button">
            <input type="hidden" name="back" value="true">
            @foreach ($inputs as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @endforeach
            <button type="submit" name="back" value="true" class="back-button">修正</button>
        </div>
    </form>
</div>
</div>
@endsection