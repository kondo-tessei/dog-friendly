@extends('layouts.html')
@extends('layouts.header')
@section('content')

<div class="container mt-5 mb-5">
    <div class="text-center">
        <h1 class="text-center display-5 mb-4">登録完了しました。</h1>
    </div>
    <div class="text-center justify-content-center"> 
        <form action="{{ route('roguin') }}" method="get">
            @csrf
            <div class="text-center mt-5 mb-5">
                <button type="submit" class="btn btn-primary btn-custom-width mt-5">ログインへ</button>
            </div>
        </form>
    </div>
</div>


<style>
    /* カスタムCSS */
    .btn-custom-width {
        width: 120px; 
    }
</style>

@endsection