@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
@endsection

@section('content')
<div class="admin-form">
    <div class="admin-form__content">
        <div class="admin-form__heading">
            <h2 class="title">Admin</h2>
        </div>
        <div class="admin-form__body">
            <div class="search-item__group">
                <form action="{{route('search')}}" class="search-items" method="GET">
                    @csrf
                    <div class="search-item-form__group">
                        <div class="search-name">
                            <input type="text" name="keyword" class="name__input" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">
                        </div>
                        <div class="search-gender">
                            <select name="gender" class="gender__select">
                                <option value="" hidden {{request('gender') === null ? 'selected' : ''}}>性別</option>
                                <option value="all" {{ request('gender') === 'all' ? 'selected' : '' }}>全て</option>
                                <option value="1" class="gender__select__input">男性</option>
                                <option value="2" class="gender__select__input">女性</option>
                                <option value="3" class="gender__select__input">その他</option>
                            </select>
                        </div>
                        <div class="search-category">
                            <select name="category_id" id="category" class="form-control">
                                <option value="" hidden>お問い合わせの種類</option>
                                @foreach($categories as $category)
                                <option class="category-select" value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->content }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="search-date">
                            <input type="date" name="created_at" class="date-of-contact" value="{{request('created_at')}}">
                        </div>
                        <div class="form__button__group">
                            <div class="search-form__button">
                                <button class="search-form__button-submit" type="submit">検索</button>
                            </div>
                            <div class="reset-search-form__button">
                                <button type="button" onclick="location.href='{{ route('admin') }}'">リセット</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="export-paginate">
                <p class="export">エクスポート</p>
                <div class="pagination">
                    {{$contacts->links('vendor.pagination.default')}}
                </div>
            </div>
            <div class="contact-list__table">
                <table class="contact__table">
                    <tr class="contact__table__row">
                        <th class="name">お名前</th>
                        <th class="gender">性別</th>
                        <th class="email">メールアドレス</th>
                        <th class="category">お問い合わせの種類</th>
                        <th class="detail"></th>
                    </tr>
                    @php
                    $genderMap = ['1' => '男性', '2' => '女性', '3' => 'その他'];
                    @endphp

                    @foreach($contacts as $contact)
                    <tr class="contact__table__row">
                        <td class="td-name">{{$contact->last_name . ' ' . $contact->first_name}}</td>
                        <td class="td-gender">{{ $genderMap[$contact->gender] ?? '不明' }}</td>
                        <td class="td-email">{{$contact->email}}</td>
                        <td class="td-category">{{$contact->category->content ?? '不明' }}</td>
                        <td class="td-detail">
                            <div class="modal__window">
                                <a href="{{ route('admin', ['detail' => $contact->id]) }}" class="modal__window__button">詳細</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @if($detailContact)
        <div class="modal-show">
            <div id="modal" class="modal_is-active">
                <div class="modal-content">
                    <a href="{{ route('admin') }}" class="modal-close-button" aria-label="閉じる">&times;</a>
                    <div class="modal__content__inner">
                        <table class="modal__table">
                            @php
                            $genderMap = ['1' => '男性', '2' => '女性', '3' => 'その他'];
                            @endphp
                            <tr class="modal__table__row">
                                <th class="modal__table__th">お名前</th>
                                <td class="modal__table__td">{{ $detailContact->last_name . ' ' . $detailContact->first_name }}</td>
                            </tr>
                            <tr class="modal__table__row">
                                <th class="modal__table__th">性別</th>
                                <td class="modal__table__td">{{ $genderMap[$detailContact->gender] ?? '不明' }}</td>
                            </tr>
                            <tr class="modal__table__row">
                                <th class="modal__table__th">メールアドレス</th>
                                <td class="modal__table__td">{{ $detailContact->email }}</td>
                            </tr>
                            <tr class=" modal__table__row">
                                <th class="modal__table__th">電話番号</th>
                                <td class="modal__table__td">{{ str_replace('-','', $detailContact->tel) }}</td>
                            </tr>
                            <tr class="modal__table__row">
                                <th class="modal__table__th">住所</th>
                                <td class="modal__table__td">{{ $detailContact->address }}</td>
                            </tr>
                            <tr class="modal__table__row">
                                <th class="modal__table__th">建物名</th>
                                <td class="modal__table__td">{{ $detailContact->building }}</td>
                            </tr>
                            <tr class="modal__table__row">
                                <th class="modal__table__th">お問い合わせの種類</th>
                                <td class="modal__table__td">{{ $detailContact->category->content ?? '不明' }}</td>
                            </tr>
                            <tr class="modal__table__row">
                                <th class="modal__table__th">お問い合わせの内容</th>
                                <td class="modal__table__td">{{ $detailContact->detail }}</< /td>
                            </tr>
                        </table>
                        <form class="delete-contact" action="{{route('contact.softDelete', ['id' => $detailContact->id ])}}" method="post">
                            @csrf
                            <div class="delete-contact__button">
                                <button class="delete-contact__button-submit" type="submit">削除</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @endsection