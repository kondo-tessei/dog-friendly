@extends('layouts.html')
@extends('layouts.header')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center display-5 mb-4">ログイン</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="roguinCheck" method="POST">
                @csrf
                <fieldset>
                    <div class="form-group">
                    <label for="email" class="col-form-label text-center">メールアドレス</label>
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-form-label text-center">パスワード</label>
                        <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('RePassword') }}" class="btn btn-link">パスワードを忘れた場合</a>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-custom-width">ログイン</button>
                    </div>
                </fieldset>
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