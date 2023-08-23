@extends('layouts.html')
@extends('layouts.header')
@section('content')
<head>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>  
<style>
    .custom-rounded-right {
    border-radius: 0 0.25rem 0.25rem 0;
}
@media screen and (max-width: 990px) {
    .btn{
        width: 100px;
    }
    .btn2{
        width: 200px;
    }
    
}
@media screen and (max-width: 600px) {
    .btn{
        width: 90px;
    }
    .btn2{
        width: 200px;
    }
}
@media screen and (min-width: 990px) {
    .btn{
        width: 150px;
    }
    .btn2{
        width: 200px;
    }
}
    .img-responsive{
        width: 70%;
        height: auto;
    }
</style>


    <p class="text-center fs-2 m-3">{{$institution->name}}</p>
    <img src="{{ asset('photos/' . $institution->photos) }}" class="mx-auto img-responsive" alt="写真">




    <div class="container">
    
        <div class="container d-flex justify-content-center h3 mt-5">
            @if($institution)
                <h2>{{ $institution->name }}のレビュー</h2>
            @else
                <h2>機関が見つかりません</h2>
            @endif
        </div>
        <div class="d-flex justify-content-center mt-3 mb-3">
            <a href="{{ route('reviewRegister', ['id' => $institution ? $institution->id : '']) }}" class="btn btn2 btn-primary">レビューを投稿する</a>
        </div>

        <form action="{{ route('reviewList') }}" method="GET" id="reviewFilterForm" class="container d-flex justify-content-center">
            <div class="btn-group" role="group" aria-label="並び替え">
                <!-- 投稿日時 -->
                @if (request('order_by') === 'created_at' && request('order_direction') === 'asc')
                    <a class="btn btn-primary" href="{{ route('reviewList', ['id' => $institution ? $institution->id : '', 'pet_size' => request('pet_size')]) }}">投稿日時</a>
                @else
                    <a class="btn btn-secondary" href="{{ route('reviewList', ['id' => $institution ? $institution->id : '', 'order_by' => 'created_at', 'order_direction' => 'asc', 'pet_size' => request('pet_size')]) }}">投稿日時</a>
                @endif
                
                <!-- 評価 -->
                @if (request('order_by') === 'evaluation' && request('order_direction') === 'asc')
                    <a class="btn btn-primary" href="{{ route('reviewList', ['id' => $institution ? $institution->id : '', 'pet_size' => request('pet_size')]) }}">評価</a>
                @else
                    <a class="btn btn-secondary" href="{{ route('reviewList', ['id' => $institution ? $institution->id : '', 'order_by' => 'evaluation', 'order_direction' => 'asc', 'pet_size' => request('pet_size')]) }}">評価</a>
                @endif

                <!-- ペットサイズ -->
                @php
                    $selectedPetSize = request('pet_size');
                @endphp
                @if ($selectedPetSize === '大型')
                    <a class="btn btn-primary" href="{{ route('reviewList', ['id' => $institution ? $institution->id : '', 'order_by' => request('order_by'), 'order_direction' => request('order_direction')]) }}">大型</a> 
                @else
                    <a class="btn btn-secondary" href="{{ route('reviewList', ['id' => $institution ? $institution->id : '', 'order_by' => request('order_by'), 'order_direction' => request('order_direction'), 'pet_size' => '大型']) }}">大型</a> 
                @endif

                @if ($selectedPetSize === '中型')
                    <a class="btn btn-primary" href="{{ route('reviewList', ['id' => $institution ? $institution->id : '', 'order_by' => request('order_by'), 'order_direction' => request('order_direction')]) }}">中型</a> 
                @else
                    <a class="btn btn-secondary" href="{{ route('reviewList', ['id' => $institution ? $institution->id : '', 'order_by' => request('order_by'), 'order_direction' => request('order_direction'), 'pet_size' => '中型']) }}">中型</a> 
                @endif

                @if ($selectedPetSize === '小型')
                    <a class="btn btn-primary rounded-end" href="{{ route('reviewList', ['id' => $institution ? $institution->id : '', 'order_by' => request('order_by'), 'order_direction' => request('order_direction')]) }}">小型</a> 
                @else
                    <a class="btn btn-secondary rounded-end" href="{{ route('reviewList', ['id' => $institution ? $institution->id : '', 'order_by' => request('order_by'), 'order_direction' => request('order_direction'), 'pet_size' => '小型']) }}">小型</a> 
                @endif

                
                </p>
                <input type="hidden" name="order_by" value="{{ request('order_by', 'created_at') }}" id="orderByInput">
                <input type="hidden" name="order_direction" value="{{ request('order_direction', 'desc') }}" id="orderDirectionInput">
                <input type="hidden" name="pet_size" value="{{ request('pet_size', '') }}" id="petSizeFilterInput">
            </div>
        </form>

        @if(count($reviews) > 0)
        <ul class="list-group">
            @foreach($reviews as $review)
            <li class="list-group-item">
                <div class="d-flex align-items-center">
                    <h3>{{ $review->nickname }} さん&nbsp;, &nbsp;&nbsp;&nbsp;評価&nbsp;:&nbsp;</h3>
                    <!-- 評価を星のアイコンで表示 -->
                    @php
                        $rating = $review->evaluation;
                        $full_stars = floor($rating);
                        $half_star = $rating - $full_stars >= 0.5;
                    @endphp
                    <div>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $full_stars)
                                <i class="fas fa-star text-warning"></i>
                            @elseif ($half_star && $i == $full_stars + 1)
                                <i class="fas fa-star-half-alt text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                    </div>
                </div>
                <p>投稿日&nbsp;:&nbsp;{{ $review->created_at }}</p>
                <p>投稿内容&nbsp;:</p>
                <p>{{ $review->comment }}</p>

            </li>
            @endforeach
        </ul>
        {{ $reviews->appends(request()->except('page'))->links('pagination::semantic-ui') }}
        @else
        <p class="text-center mt-5">まだレビューがありません</p>
        @endif
    </div>

@endsection


