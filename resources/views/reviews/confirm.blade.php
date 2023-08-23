@extends('layouts.html')
@extends('layouts.header')
@section('content')

<style>
    .evaluation{
  display: flex;
  flex-direction: row-reverse;
  justify-content: center;
}
.evaluation input[type='radio']{
  display: none;
}
.evaluation label{
  position: relative;
  padding: 10px 10px 0;
  color: gray;
  cursor: pointer;
  font-size: 50px;
}
.evaluation label .text{
  position: absolute;
  left: 0;
  top: 0;
  right: 0;
  text-align: center;
  font-size: 12px;
  color: gray;
}
.evaluation label:hover,
.evaluation label:hover ~ label,
.evaluation input[type='radio']:checked ~ label{
  color: #ffcc00;
}
</style>
<head>
    <!-- 他のメタタグやスタイルシートのリンクなど -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center my-5">内容確認</h1>
            <form action="{{ route('reviewListBack') }}" method="POST">
                @csrf
                <fieldset>
                    
                    <label>評価 <span class="badge bg-danger">必須</span></label>
                    <div class="evaluation form-group">
                        <?php
                        $selectedStar = session('oldInput')['star'];
                        for ($i = 5; $i >= 1; $i--) {
                            $checked = ($selectedStar == $i) ? 'checked' : '';
                            echo '<input id="star'.$i.'" type="radio" name="star" value="'.$i.'" '.$checked.' />';
                            echo '<label for="star'.$i.'"><span class="text">';
                            if ($i === 5) {
                                echo '最高';
                            } elseif ($i === 4) {
                                echo '良い';
                            } elseif ($i === 3) {
                                echo '普通';
                            } elseif ($i === 2) {
                                echo '悪い';
                            } else {
                                echo '最悪';
                            }
                            echo '</span>★</label>';
                        }
                        ?>
                    </div>


                    <div class="form-group">
                    <label for="nickname" class="col-form-label text-center text-break">ニックネーム <span class="badge bg-danger">必須</span></label>
                        <input id="nickname" type="text" class="form-control" name="nickname" value="{{ session('oldInput')['nickname'] ?? '' }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="comment" class="col-form-label text-center text-break">投稿内容</label>
                        <textarea id="comment" class="form-control" name="comment" rows="7" readonly>{{session('oldInput')['comment'] ?? ''}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="dog_size" class="col-form-label custom-label">犬の大きさ</label>
                        <input id="dog_size" type="text" class="form-control" name="dog_size" value="{{ convertDogSize(session('oldInput')['dog_size']) }}" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="photos" class="col-form-label text-center">写真</label>
                        <input id="photos" type="file" class="form-control" name="photos" value="{{session('oldInput')['photos'] ?? ''}}">
                    </div>

                    <div class="form-group">
                        <input type="hidden" id="institution_id" name="institution_id" value="{{session('oldInput')['institution_id'] ?? ''}}">
                    </div>

                </fieldset>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-custom-width">登録</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

<?php
use Illuminate\Support\Facades\Auth;

   function convertDogSize($sizeValue) {
    switch ($sizeValue) {
        case 2:
            return '小型';
        case 1:
            return '中型';
        case 0:
            return '大型';
        default:
            return '未指定';
    }
}



?>