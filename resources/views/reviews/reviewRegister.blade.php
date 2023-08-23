
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

@extends('layouts.html')
@extends('layouts.header')
@section('content')



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center my-5">レビュー登録</h1>
            <form action="{{ route('reviewConfirm') }}" method="POST">
                @csrf
                <fieldset>
                    
                    <label>評価 <span class="badge bg-danger">必須</span></label>
                    <div class="evaluation form-group">
                        <input id="star1" type="radio" name="star" value="5" />
                        <label for="star1"><span class="text">最高</span>★</label>
                        <input id="star2" type="radio" name="star" value="4" />
                        <label for="star2"><span class="text">良い</span>★</label>
                        <input id="star3" type="radio" name="star" value="3" />
                        <label for="star3"><span class="text">普通</span>★</label>
                        <input id="star4" type="radio" name="star" value="2" />
                        <label for="star4"><span class="text">悪い</span>★</label>
                        <input id="star5" type="radio" name="star" value="1" />
                        <label for="star5"><span class="text">最悪</span>★</label>
                    </div>

                    <div class="form-group ">
                        <label for="nickname" class="col-form-label text-center">ニックネーム <span class="badge bg-danger">必須</span></label>
                        <input id="nickname" type="text" class="form-control @error('name') is-invalid @enderror" name="nickname" value="{{session('oldInput')['nickname'] ?? ''}}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="comment" class="col-form-label text-center">投稿内容</label>
                        <textarea id="comment" class="form-control @error('comment') is-invalid @enderror" name="comment" value="{{session('oldInput')['comment'] ?? ''}}"rows="7"></textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group ">
                        <label for="dog_size" class="col-form-label custom-label">犬の大きさ</label>
                        <div class="btn-group" role="group">
                            <label class="btn btn-secondary active custom-label2">
                                <input type="radio" name="dog_size" id="small" value="2" checked>
                                <i class="fas fa-dog"></i> 小型
                            </label>
                            <label class="btn btn-secondary custom-label2">
                                <input type="radio" name="dog_size" id="medium" value="1">
                                <i class="fas fa-dog"></i> 中型
                            </label>
                            <label class="btn btn-secondary custom-label2">
                                <input type="radio" name="dog_size" id="large" value="0">
                                <i class="fas fa-dog"></i> 大型
                            </label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="photos" class="col-form-label text-center">写真</label>
                        <input id="photos" type="file" class="form-control @error('photos') is-invalid @enderror" name="photos" value="{{session('oldInput')['photos'] ?? ''}}">
                        @error('photos')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                

                    <div class="form-group">
                        <input type="hidden" id="institution_id" name="institution_id" value="{{ $institutionId }}">
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