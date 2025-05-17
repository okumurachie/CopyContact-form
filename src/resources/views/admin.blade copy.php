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
                            <!-- @foreach($categories as $category)
                            <option class="category-select" value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->content }}
                            </option>
                            @endforeach -->
                        </select>
                        <select name="created_at" class="date-of-contact">
                            <input type="date"></input>
                        </select>
                        <div class="search-form__button">
                            <button class="search-form__button-submit" type="submit">検索</button>
                        </div>
                        <div class="reset-search-form__button">
                            <input type="reset" value="リセット">
                        </div>
                    </div>
                    <div class="export-paginate">
                        <p class="export">エクスポート</p>
                        <div class="pagination">
                            <p>ここにページネートのリンクを貼ります。</p>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection