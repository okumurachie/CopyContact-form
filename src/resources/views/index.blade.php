@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2 class="title">Contact</h2>
    </div>
    <form action="{{route('confirm')}}" class="contact-form__input" method="POST">
        @csrf
        <div class="contact-form__group">
            <div class="name-form__input">
                <label for="name" class="label-name">
                    お名前<span class="required-mark">※</span>
                </label>
                <div class="input-wrapper">
                    <div class="name-inputs">
                        <input type="text" name="last_name" class="last_name" placeholder="例：山田" value="{{ old('last_name') }}">
                        <input type="text" name="first_name" class="first_name" placeholder="例：太郎" value="{{ old('first_name') }}">
                    </div>
                    <div class="form__error">
                        @error('last_name')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form__error">
                        @error('first_name')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="gender-form__input">
                <label for="gender" class="label_gender">
                    性別<span class="required-mark">※</span>
                </label>
                <div class="input-wrapper">
                    <div class="gender-options">
                        <label class="gender-option">
                            <input type="radio" name="gender" value="1" {{ old('gender') == '1' ? 'checked' : '' }}>
                            <span class="custom-radio">男性</span>
                        </label>
                        <label class="gender-option">
                            <input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}>
                            <span class="custom-radio">女性</span>
                        </label>
                        <label class="gender-option">
                            <input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }}>
                            <span class="custom-radio">その他</span>
                        </label>
                    </div>
                    <div class="form__error">
                        @error('gender')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="email-form__input">
                <label for="email" class="label-email">
                    メールアドレス<span class="required-mark">※</span>
                </label>
                <div class="input-wrapper">
                    <input type="text" name="email" class="email" placeholder="例：test@example.com" value="{{ old('email') }}">
                    <div class="form__error">
                        @error('email')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="tel-form__input">
                <label for="tel" class="label-tel">
                    電話番号<span class="required-mark">※</span>
                </label>
                <div class="input-wrapper">
                    <div class="tel-inputs">
                        <input type="text" name="tel1" class="tel1" placeholder="例：090" value="{{ old('tel1') }}">
                        <span class="tel-separator">-</span>
                        <input type="text" name="tel2" class="tel2" placeholder="1234" value="{{ old('tel2') }}">
                        <span class="tel-separator">-</span>
                        <input type="text" name="tel3" class="tel3" placeholder="5678" value="{{ old('tel3') }}">
                    </div>
                    <div class="form__error">
                        @if ($errors->has('tel1') || $errors->has('tel2') || $errors->has('tel3'))
                        <p>電話番号を入力してください。</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="address-form__input">
                <label for="address" class="label-address">
                    住所<span class="required-mark">※</span>
                </label>
                <div class="input-wrapper">
                    <input type="text" name="address" class="address" placeholder="東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
                    <div class="form__error">
                        @error('address')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="building-form__input">
                <label for="building" class="label-address">建物名</label>
                <div class="input-wrapper">
                    <input type="text" name="building" class="building" placeholder="千駄ヶ谷マンション101" value="{{ old('building') }}">
                    <div class="form__error">
                        @error('building')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="category-form__input">
                <label for="category" class="label-category">
                    お問い合わせの種類<span class="required-mark">※</span>
                </label>
                <div class="input-wrapper">
                    <select name="category_id" id="category" class="form-control">
                        <option value="" hidden>選択してください</option>
                        @foreach($categories as $category)
                        <option class="category-select" value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                        @endforeach
                    </select>
                    <div class="form__error">
                        @error('category_id')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="detail-form__input">
                <label for="detail" class="label-detail">
                    お問い合わせの内容<span class="required-mark">※</span>
                </label>
                <div class="input-wrapper">
                    <textarea name="detail" id="detail" class="detail-input-form" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
                    <div class="form__error">
                        @error('detail')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="form__button">
            <button type="submit" class="button-link">確認画面</button>
        </div>
    </form>

</div>
@endsection