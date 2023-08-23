@extends('layouts.html')
@extends('layouts.header')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center">施設登録 確認</h1>
            <form action="{{ route('institution-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <fieldset>
                    <div class="form-group">
                        <label for="name" class="col-form-label text-center">施設名 <span class="badge bg-danger">必須</span></label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ session('oldInput.name') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-form-label text-center">メールアドレス <span class="badge bg-danger"></span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ session('oldInput.email') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="tel" class="col-form-label text-center">施設の電話番号 <span class="badge bg-danger">必須</span></label>
                        <input id="tel" type="tel" class="form-control @error('tel') is-invalid @enderror" name="tel" value="{{ session('oldInput.tel') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-form-label text-center">住所 <span class="badge bg-danger">必須</span></label>
                        <input id="address" type="text" class="form-control text-break @error('address') is-invalid @enderror" name="address" value="{{ session('oldInput.address') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="latitude" class="col-form-label text-center">緯度 <span class="badge bg-primary">住所より自動入力</span></label>
                        <input id="latitude" type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{ session('oldInput.latitude') }}"  readonly>
                    </div>
                    <div class="form-group">
                        <label for="longitude" class="col-form-label text-center">経度 <span class="badge bg-primary">住所より自動入力</span></label>
                        <input id="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{ session('oldInput.longitude') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-form-label text-center text-break">説明</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ session('oldInput.description') }}</textarea readonly>
                    </div>

                    <div class="form-group">
                        <label for="okPetSize" class="col-form-label text-center">可能なペットの大きさ <span class="badge bg-danger">必須</span></label>
                        <select id="okPetSize" class="form-control" name="okPetSize" required>
                            <option value="0" @if(session('oldInput.okPetSize') == 0) selected @endif>大型</option>
                            <option value="1" @if(session('oldInput.okPetSize') == 1) selected @endif>中型</option>
                            <option value="2" @if(session('oldInput.okPetSize') == 2) selected @endif>小型</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category" class="col-form-label text-center">カテゴリー <span class="badge bg-danger">必須</span></label>
                        <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" required>
                            <option value="">カテゴリーを選択してください</option>
                            <option value="park" @if(old('category', $oldInput['category'] ?? '') === 'park') selected @endif>公園</option>
                            <option value="water" @if(old('category', $oldInput['category'] ?? '') === 'water') selected @endif>川や海、湖</option>
                            <option value="campground" @if(old('category', $oldInput['category'] ?? '') === 'campground') selected @endif>キャンプ場</option>
                            <option value="hotel" @if(old('category', $oldInput['category'] ?? '') === 'hotel') selected @endif>宿泊施設</option>
                            <option value="restaurant" @if(old('category', $oldInput['category'] ?? '') === 'restaurant') selected @endif>食事</option>
                            <option value="supermarket" @if(old('category', $oldInput['category'] ?? '') === 'supermarket') selected @endif>ショッピング</option>
                            <option value="leisure" @if(old('category', $oldInput['category'] ?? '') === 'leisure') selected @endif>その他レジャー施設</option>
                            <option value="other" @if(old('category', $oldInput['category'] ?? '') === 'other') selected @endif>その他</option>
                        </select>
                        @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                    <label for="website" class="col-form-label text-center text-break">公式ウェブサイト</label>
                        <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ session('oldInput.website') }}" readonly>
                    </div>

                    <input type="hidden" name="photos" value="{{ session('oldInput.photos') }}" readonly>
                    
                </fieldset>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-custom-width">登録する</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-custom-width">戻る</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

