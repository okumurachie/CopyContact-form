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
                <form action="" class="search-items" method=GET>
                    @csrf
                    <div class="search-item-form__group">
                        <div class="search-name">
                            <input type="text" name="name" class="name" placeholder="名前やメールアドレスを入力してください" value="">
                        </div>
                        <div class="search-gender">
                            <select name="gender" class="gender__select">
                                <option value="" hidden>性別</option>
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
                            <input type="date" name="created_at" class="date-of-contact">
                        </div>
                        <div class="form__button__group">
                            <div class="search-form__button">
                                <button class="search-form__button-submit" type="submit">検索</button>
                            </div>
                            <div class="reset-search-form__button">
                                <input type="reset" value="リセット">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="export-paginate">
                <p class="export">エクスポート</p>
                <div class="pagination">
                    <p>ここにページネートのリンクを貼ります。</p>
                </div>
            </div>
            <div class="contact-list__table">
                <table class="contact__table">
                    <tr class="contact__table__row">
                        <th class="name">お名前</th>
                        <th class="gender">性別</th>
                        <th class="email">メールアドレス</th>
                        <th class="category">お問い合わせの種類</th>
                        <th></th>
                    </tr>
                    <tr class="contact__table__row">
                        <td class="td-name"></td>
                        <td class="td-gender"></td>
                        <td class="td-email"></td>
                        <td class="td-category"></td>
                        <td class="td-detail"></td>
                    </tr>
                    <tr class="contact__table__row">
                        <td class="td-name">山田 太郎</td>
                        <td class="td-gender">男性</td>
                        <td class="td-email">test@example.com</td>
                        <td class="td-category">商品の交換について</td>
                        <td class="td-detail">
                            <div class="modal__window">
                                <button class="modal__window__button">詳細</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection