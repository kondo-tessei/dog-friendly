@extends('layouts.html')

@section('content')

@extends('layouts.header')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYhCrtxpRpGJ05J1T20H2hrEaQsfaClY4&callback=initMap&libraries=places" async defer></script>
<script>
  (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
    key: "AIzaSyBYhCrtxpRpGJ05J1T20H2hrEaQsfaClY4",
    // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
    // Add other bootstrap parameters as needed, using camel case.
  });
</script>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center">施設登録</h1>
            <form action="/institution-confirm" method="POST" enctype="multipart/form-data">
                @csrf
                <fieldset>
                    <div class="form-group">
                        <label for="name" class="col-form-label text-center">施設名 <span class="badge bg-danger">必須</span></label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{session('oldInput')['name'] ?? ''}}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-form-label text-center">メールアドレス <span class="badge bg-danger"></span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{session('oldInput')['email'] ?? ''}}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tel" class="col-form-label text-center">施設の電話番号 <span class="badge bg-danger">必須</span></label>
                        <input id="tel" type="tel" class="form-control @error('tel') is-invalid @enderror" name="tel" value="{{session('oldInput')['tel'] ?? ''}}" required>
                        @error('tel')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-form-label text-center">住所 <span class="badge bg-danger">必須</span></label>
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{session('oldInput')['address'] ?? ''}}" required onchange="geocodeAddress()">
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="latitude" class="col-form-label text-center">緯度 <span class="badge bg-primary">住所より自動入力</span></label>
                        <input id="latitude" type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{session('oldInput')['latitude'] ?? ''}}" required readonly>
                        @error('latitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="longitude" class="col-form-label text-center">経度 <span class="badge bg-primary">住所より自動入力</span></label>
                        <input id="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{session('oldInput')['longitude'] ?? ''}}" required readonly>
                        @error('longitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-form-label text-center">説明</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{session('oldInput')['description'] ?? ''}}"rows="4"></textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="okPetSize" class="col-form-label text-center">可能なペットの大きさ<span class="badge bg-danger">必須</span></label>
                        <select id="okPetSize" class="form-control @error('okPetSize') is-invalid @enderror" name="okPetSize" required>
                            <option value="">カテゴリーを選択してください</option>
                            <option value="2" @if(old('okPetSize', isset($oldInput['okPetSize']) ? $oldInput['okPetSize'] : '') === '2') selected @endif>小型以下</option>
                            <option value="1" @if(old('okPetSize', isset($oldInput['okPetSize']) ? $oldInput['okPetSize'] : '') === '1') selected @endif>中型以下</option>
                            <option value="0" @if(old('okPetSize', isset($oldInput['okPetSize']) ? $oldInput['okPetSize'] : '') === '0') selected @endif>全て</option>
                        </select>
                        @error('okPetSize')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category" class="col-form-label text-center">カテゴリー <span class="badge bg-danger">必須</span></label>
                        <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" required>
                            <option value="">カテゴリーを選択してください</option>
                            <option value="park" @if(old('category', $oldInput['category'] ?? '') === 'park') selected @endif>公園</option>
                            <option value="water" @if(old('category', $oldInput['category'] ?? '') === 'water') selected @endif>川や海、湖</option>
                            <option value="campground" @if(old('category', $oldInput['category'] ?? '') === 'campground') selected @endif>キャンプ場</option>
                            <option value="hotel" @if(old('category', $oldInput['category'] ?? '') === 'hotel') selected @endif>宿泊施設</option>
                            <option value="restaurant" @if(old('category', $oldInput['category'] ?? '') === 'restaurant') selected @endif>食事</option>
                            <option value="supermarket" @if(old('category', $oldInput['category'] ?? '') === 'supermarket') selected @endif>ショッピング</option>
                            <option value="leisure" @if(old('category', $oldInput['category'] ?? '') === 'leisure') selected @endif>その他レジャー施設</option>
                            <option value="other" @if(old('category', $oldInput['category'] ?? '') === 'other') selected @endif>その他</option>
                        </select>
                        @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="website" class="col-form-label text-center">公式ウェブサイト</label>
                        <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{session('oldInput')['website'] ?? ''}}">
                        @error('website')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
                
                </fieldset>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-custom-width">登録</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function geocodeAddress() {
        var geocoder = new google.maps.Geocoder();
        var address = document.getElementById('address').value;
        
        geocoder.geocode({ 'address': address }, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
                
                return true;
            } else {
                alert('住所から緯度経度を取得できませんでした。');
                return false;
            }
        });
    }
</script>
<style>
    /* カスタムCSS */
    .btn-custom-width {
        width: 120px; 
    }
</style>
@endsection