@extends('layouts.html')
@extends('layouts.header')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center display-5 mb-4">登録内容確認</h1>
                <fieldset>
                    <div class="form-group">
                        <label for="name" class="col-form-label text-center">氏名</label>
                        <input type="text" name="name" class="form-control" value="{{ session('user.name') }}" readonly>
                    </div>
                    <div class="form-group mb-4">
                        <label for="email" class="col-form-label text-center">メールアドレス</label>
                        <input type="text" name="email" class="form-control" value="{{ session('user.email') }}" readonly>
                    </div>
                    
                </fieldset>
                
                <div class="d-flex justify-content-around">
                    <form action="{{ route('userRegister') }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-custom-width">戻る</button>
                    </form>
                    <form action="{{ route('registerComplete') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-custom-width">登録</button>
                    </form>
                </div>
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