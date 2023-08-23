@extends('layouts.html')
@extends('layouts.header')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center display-5 mb-4">パスワード再設定</h1>
        
            <form action="RePassword-mail-complete" method="POST">
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
                </fieldset>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-custom-width mt-5">メールに送信</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    /* カスタムCSS */
    .btn-custom-width {
        width: 140px; 
    }
</style>


@endsection