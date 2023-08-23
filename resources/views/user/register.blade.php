@extends('layouts.html')
@extends('layouts.header')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center display-5 mb-4">新規登録</h1>
            <form action="registration" method="POST">
                @csrf
                <fieldset>
                    <div class="form-group">
                        <label for="name" class="col-form-label text-center">氏名 <span class="badge bg-danger">必須</span></label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ session('user.name') }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-form-label text-center">メールアドレス <span class="badge bg-danger">必須</span></label>
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ session('user.email') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-form-label text-center">パスワード <span class="badge bg-danger">必須</span></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" name="password" value="{{ old('password') }}" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                </fieldset>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-custom-width">登録</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* カスタムCSS */
    .btn-custom-width {
        width: 120px; 
    }
</style>
@endsection