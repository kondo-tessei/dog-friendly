<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<style>
    .fas {
        color: #ffcc00; /* 星の色 */
    }
    /* スタイルをここに記述するか、外部CSSファイルに分離して適用する */
    .facility-container {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .facility-image {
        width: 150px;
        height: 150px;
        margin-right: 20px;
    }

    .facility-info {
        flex: 1;
    }

    .facility-name {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .facility-address {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .facility-phone {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .facility-review-link {
        font-size: 14px;
        margin-bottom: 10px;
        display: block; /* ボタンをブロック要素にする */
    }

    .facility-website {
        font-size: 16px;
        text-align: right;
        text-decoration: none;
        color: blue;
    }
</style>

@isset($results)
<div class="container-fluid">
    <div class="row justify-content-center">
        @foreach ($results as $institution)
        <div class="facility-container">
            <img class="facility-image" src="/teethe.shop/dog-friendly/public/photos/{{ $institution->photos }}" alt="施設写真">
            <div class="facility-info">
                <div class="facility-name">{{ $institution->name }}</div>
                <div class="facility-address">住所: {{ $institution->address }}</div>
                <div class="facility-phone">電話番号: {{ $institution->tel }}</div>
                <div class="facility-review">平均評価:
                    @php
                        $averageRating = $institution->reviews->avg('evaluation');
                        $fullStars = floor($averageRating);
                        $halfStar = $averageRating - $fullStars >= 0.5;
                    @endphp

                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $fullStars)
                            <i class="fas fa-star"></i>
                        @elseif ($i == $fullStars + 1 && $halfStar)
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>

                
                <a class="facility-review-link" href="{{ route('reviewList', ['id' => $institution->id]) }}">口コミ一覧へ</a>
            </div>
            <div>
            @if ($institution->website)
                <a class="facility-website" href="{{ $institution->website }}" target="_blank">
                    <button>公式サイト</button>
                </a>
            @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="row text-center">
   
        {{ $results->links('pagination::semantic-ui') }}
    </div>
</div>
@endisset


