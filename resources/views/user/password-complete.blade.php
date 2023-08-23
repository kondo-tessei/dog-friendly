@extends('layouts.html')
@extends('layouts.header')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1 class="mt-3 display-5 mb-4">パスワード再設定が完了しました。</h1>
        </div>
        <div class="d-flex justify-content-center mt-5">
            <a href="{{ route('roguin') }}" class="btn btn-primary btn-custom-width mr-2">ログインへ</a>
            <div class="mx-2"></div> 
            <a href="{{ route('top') }}" class="btn btn-primary btn-custom-width">トップページへ</a>
        </div>
    </div>
</div>
<style>
    /* カスタムCSS */
    .btn-custom-width {
        width: 130px; 
    }
</style>


@endsection