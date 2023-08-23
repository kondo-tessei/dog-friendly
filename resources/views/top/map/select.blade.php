
<style>
        /* select要素の縦幅を100pxに設定 */
        select.form-control {
            height: 60px;
        }
        .custom-label {
            font-weight: bold;
            color: blue; /* 赤色のテキスト */
            font-size: 18px; /* フォントサイズ18px */
            background-color: #f0f0f0; /* 背景色を灰色に設定 */
            padding: 5px 10px; /* パディングを追加してスペースを調整 */
            border-radius: 5px; /* 角丸にする */
        }
        .custom-label2 {
            height: 58px;
            width: 80px;
            line-height: 40px;
        }
</style>
<div class="container-fluid">
    <div class="row justify-content-center">
        

            <form action="{{ route('search') }}" method="GET">
                @csrf
                <fieldset>
                <div class="form-group row mt-5">
                    <div class="col-md-6 mt-3">
                        <label for="region" class="col-form-label custom-label">地方選択</label>
                        <select id="region" class="form-control" name="region">
                            <option value="">地方を選択してください</option>
                            <option value="hokkaido" @if(request('region') === 'hokkaido') selected @endif>北海道</option>
                            <option value="tohoku" @if(request('region') === 'tohoku') selected @endif>東北</option>
                            <option value="kanto" @if(request('region') === 'kanto') selected @endif>関東</option>
                            <option value="chubu" @if(request('region') === 'chubu') selected @endif>中部</option>
                            <option value="kinki" @if(request('region') === 'kinki') selected @endif>近畿</option>
                            <option value="chugoku" @if(request('region') === 'chugoku') selected @endif>中国</option>
                            <option value="shikoku" @if(request('region') === 'shikoku') selected @endif>四国</option>
                            <option value="kyushu" @if(request('region') === 'kyushu') selected @endif>九州</option>
                        </select>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="prefecture" class="col-form-label text-center custom-label">都道府県選択</label>
                        <select id="prefecture" class="form-control" name="prefecture" disabled>
                        <option value="">@if(session('selected_prefecture')) {{ session('selected_prefecture') }} @else 地方を選択してください @endif</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4 mt-3">
                        <label for="dog_size" class="col-form-label text-center custom-label">犬の大きさ:</label>
                        <select name="dog_size" id="dog_size" class="form-control">
                            <option value="">選択してください</option>
                            <option value="2" @if(request('dog_size') === '2') selected @endif>小型</option>
                            <option value="1" @if(request('dog_size') === '1') selected @endif>中型</option>
                            <option value="0" @if(request('dog_size') === '0') selected @endif>大型</option>
                        </select>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label for="category" class="col-form-label text-center custom-label">カテゴリー選択:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">選択してください</option>
                            <option value="park" @if(request('category') === 'park') selected @endif>公園</option>
                            <option value="water" @if(request('category') === 'water') selected @endif>川や海、湖</option>
                            <option value="campground" @if(request('category') === 'campground') selected @endif>キャンプ場</option>
                            <option value="hotel" @if(request('category') === 'hotel') selected @endif>宿泊施設</option>
                            <option value="restaurant" @if(request('category') === 'restaurant') selected @endif>食事</option>
                            <option value="supermarket" @if(request('category') === 'supermarket') selected @endif>ショッピング</option>
                            <option value="leisure" @if(request('category') === 'leisure') selected @endif>その他レジャー施設</option>
                            <option value="other" @if(request('category') === 'other') selected @endif>その他</option>
                            <!-- 他のカテゴリーのオプションを追加 -->
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end mt-3">
                        <button type="submit" class="btn btn-primary btn-lg">検索</button>
                    </div>
                </div>
                </fieldset>
            </form>
        </div>



        <div class="btn-group mt-4">
            <a href="{{ route('search', ['sort' => 'averageRating']) }}" class="btn btn-secondary">
                <i class="fas fa-sort-amount-down"></i> 平均評価順
            </a>
            <a href="{{ route('search', ['sort' => 'reviewCount']) }}" class="btn btn-secondary">
                <i class="fas fa-sort-amount-down"></i> 評価数順
            </a>
        </div>


</div>

<script>
  const prefecturesInRegion = {
    hokkaido: ['北海道'],
    tohoku: ['青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県'],
    kanto: ['東京都', '神奈川県', '埼玉県', '千葉県', '茨城県', '栃木県', '群馬県'],
    chubu: ['愛知県', '岐阜県', '静岡県', '三重県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県'],
    kinki: ['大阪府', '京都府', '兵庫県', '奈良県', '滋賀県', '和歌山県'],
    chugoku: ['広島県', '岡山県', '山口県', '鳥取県', '島根県'],
    shikoku: ['徳島県', '香川県', '愛媛県', '高知県'],
    kyushu: ['福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'],
  };

  // 都道府県のセレクトボックスを取得
  const prefectureSelect = document.getElementById('prefecture');

  // 都道府県の選択肢を更新する関数
  function updatePrefectures(region) {
    // 都道府県の選択肢をクリア
    prefectureSelect.innerHTML = '';

    // 選択された地方に応じて都道府県の選択肢を生成
    const prefectures = prefecturesInRegion[region] || [];
    if (prefectures.length > 1) { // 都道府県が1つ以上ある場合は全ての都道府県を追加
      const optionAll = document.createElement('option');
      optionAll.value = ''; // 空文字列の値を設定
      optionAll.textContent = '全ての県'; // オプションの表示テキストを設定
      prefectureSelect.appendChild(optionAll);
    }
    for (const prefecture of prefectures) {
      const option = document.createElement('option');
      option.value = prefecture;
      option.textContent = prefecture;
      prefectureSelect.appendChild(option);
    }

    // 都道府県のセレクトボックスを有効化
    prefectureSelect.disabled = false;
  }

  // 地方の選択肢が変更されたら都道府県の選択肢を更新
  const regionSelect = document.getElementById('region');
  regionSelect.addEventListener('change', () => {
    const selectedRegion = regionSelect.value;
    updatePrefectures(selectedRegion);
  });

  // 初期表示時に都道府県の選択肢を更新
  const initialRegion = regionSelect.value;
  updatePrefectures(initialRegion);
</script>





