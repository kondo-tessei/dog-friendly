<?php

namespace App\Http\Controllers;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class TopController extends Controller
{
    public function Top()
    {
        $institutions = Institution::all()->toArray();
        return view('top.dog-friendly', compact('institutions'));
    }




    private function convertToJapanesePrefectureName($englishPrefectureName)
{
    $englishToJapanese = [
        'Hokkaido' => '北海道',
        'Aomori' => '青森県',
        'Iwate' => '岩手県',
        'Miyagi' => '宮城県',
        'Akita' => '秋田県',
        'Yamagata' => '山形県',
        'Fukushima' => '福島県',
        'Ibaraki' => '茨城県',
        'Tochigi' => '栃木県',
        'Gunma' => '群馬県',
        'Saitama' => '埼玉県',
        'Chiba' => '千葉県',
        'Tokyo' => '東京都',
        'Kanagawa' => '神奈川県',
        'Niigata' => '新潟県',
        'Toyama' => '富山県',
        'Ishikawa' => '石川県',
        'Fukui' => '福井県',
        'Yamanashi' => '山梨県',
        'Nagano' => '長野県',
        'Gifu' => '岐阜県',
        'Shizuoka' => '静岡県',
        'Aichi' => '愛知県',
        'Mie' => '三重県',
        'Shiga' => '滋賀県',
        'Kyoto' => '京都府',
        'Osaka' => '大阪府',
        'Hyogo' => '兵庫県',
        'Nara' => '奈良県',
        'Wakayama' => '和歌山県',
        'Tottori' => '鳥取県',
        'Shimane' => '島根県',
        'Okayama' => '岡山県',
        'Hiroshima' => '広島県',
        'Yamaguchi' => '山口県',
        'Tokushima' => '徳島県',
        'Kagawa' => '香川県',
        'Ehime' => '愛媛県',
        'Kochi' => '高知県',
        'Fukuoka' => '福岡県',
        'Saga' => '佐賀県',
        'Nagasaki' => '長崎県',
        'Kumamoto' => '熊本県',
        'Oita' => '大分県',
        'Miyazaki' => '宮崎県',
        'Kagoshima' => '鹿児島県',
        'Okinawa' => '沖縄県',
    ];

    return $englishToJapanese[$englishPrefectureName] ?? $englishPrefectureName;
}
    





    public function store(Request $request)
    {
        //dd($request->all());
    // バリデーション
    $validatedData = $request->validate([
        'name' => 'required|max:128',
        'email' => 'nullable|email',
        'tel' => 'required|max:12',
        'address' => 'required|max:255',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'description' => 'nullable',
        'category' => 'required|max:50',
        'website' => 'nullable|max:255',
        'photos' => 'nullable',
        'prefecture' => 'nullable',
        'okPetSize' => 'nullable',
    ]);
       
    // ログインしているユーザーのIDをregistrant_idに設定
    $validatedData['registrant_id'] = Auth::user()->id;
    

    // 写真の処理
    if ($request->hasFile('photos')) {
        $image = $request->file('photos');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('photos'), $imageName);
        $validatedData['photos'] = $imageName;
    }



    // 緯度経度から都道府県を取得
    $apiKey = 'AIzaSyBYhCrtxpRpGJ05J1T20H2hrEaQsfaClY4';
    $latitude = $validatedData['latitude'];
    $longitude = $validatedData['longitude'];
    
    $geocodeResponse = Http::get("https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}");

        
    if ($geocodeResponse->successful()) {
        $geocodeData = $geocodeResponse->json();
        $results = $geocodeData['results'];
        foreach ($results as $result) {
            $addressComponents = $result['address_components'];
            foreach ($addressComponents as $component) {
                if (in_array('administrative_area_level_1', $component['types'])) {
                    // 都道府県が見つかったらprefectureにセット
                    $validatedData['prefecture'] = $component['long_name'];
                    break;
                }
            }
        }
        
    } else {

        $validatedData['prefecture'] = '';
    }
        $validatedData['prefecture'] = $this->convertToJapanesePrefectureName($validatedData['prefecture']);
        // データベースに保存
        
        Institution::create($validatedData);

        // 登録完了ページにリダイレクト
        $institutions = Institution::all()->toArray();
            return view('top.dog-friendly', compact('institutions'));
        }

    public function confirm(Request $request)
    {
        // 確認画面の表示処理
        $request->session()->put('oldInput', $request->input());
        $oldInput = session('oldInput', []);
        if ($request->hasFile('photos')) {
            $image = $request->file('photos');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('photos'), $imageName);
            $request->session()->put('oldInput.photos', $imageName);
        }
        
        return view('institution.confirm', compact('oldInput'));
    }






    public function map()
    {
        $institutions = Institution::all()->toArray();
        return view('top.dog-friendly', compact('institutions'));
    }



    public function search(Request $request)
    {   
        $region = $request->input('region');
        $prefecture = $request->input('prefecture');
        $dogSize = $request->input('dog_size');
        $category = $request->input('category');
        
        // フォームのデータを使って絞り込み検索クエリを作成
        session(['selected_prefecture' => $prefecture]);
        
        $query = Institution::query();

        
        
        if ($region === 'hokkaido' && is_null($prefecture)) {
            $query->whereIn('prefecture', ['北海道']);
        } elseif ($region === 'tohoku' && is_null($prefecture)) {
            $query->whereIn('prefecture', ['青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県']);
        } elseif ($region === 'kanto' && is_null($prefecture)) {
            $query->whereIn('prefecture', ['東京都', '神奈川県', '埼玉県', '千葉県', '茨城県', '栃木県', '群馬県']);
        } elseif ($region === 'chubu' && is_null($prefecture)) {
            $query->whereIn('prefecture', ['愛知県', '岐阜県', '静岡県', '三重県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県']);
        } elseif ($region === 'kinki' && is_null($prefecture)) {
            $query->whereIn('prefecture', ['大阪府', '京都府', '兵庫県', '奈良県', '滋賀県', '和歌山県']);
        } elseif ($region === 'chugoku' && is_null($prefecture)) {
            $query->whereIn('prefecture', ['広島県', '岡山県', '山口県', '鳥取県', '島根県']);
        } elseif ($region === 'shikoku' && is_null($prefecture)) {
            $query->whereIn('prefecture', ['徳島県', '香川県', '愛媛県', '高知県']);
        } elseif ($region === 'kyushu' && is_null($prefecture)) {
            $query->whereIn('prefecture', ['福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県']);
        } elseif (!is_null($prefecture)) {
            // 都道府県が選択されている場合は該当する都道府県のみを対象に検索
            $query->where('prefecture', $prefecture);
        } elseif (is_null($region) && is_null($prefecture)) {
            $query->whereIn('prefecture', ['北海道','青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県','東京都', '神奈川県', '埼玉県', '千葉県', '茨城県', '栃木県', '群馬県','大阪府', '京都府', '兵庫県', '奈良県', '滋賀県', '和歌山県','広島県', '岡山県', '山口県', '鳥取県', '島根県','徳島県', '香川県', '愛媛県', '高知県','福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県']);
        }
        
        
        
        
            if ($dogSize !== null) {
                if ($dogSize == 0) {
                    $query->whereIn('okPetSize', [0, 1, 2]);
                } elseif ($dogSize == 1) {
                    $query->whereIn('okPetSize', [1, 2]);
                } elseif ($dogSize == 2) {
                    $query->whereIn('okPetSize', [2]);
                }
            }
       
       
        
        if ($category !== null) {
            $query->where('category', $category);
        }
      
        // 検索結果を取得
        $perPage = 5; // 1ページあたりの表示数
        $results =  $query->paginate($perPage);
        $currentPage = request('page', 1); 
        
        $institutions = Institution::all()->toArray();
        $averageRatings = [];
        foreach ($results as $result) {
            $averageRating = $result->reviews->avg('evaluation');
            $averageRatings[$result->id] = $averageRating;
        }
        
        $sort = $request->input('sort', 'default'); // ユーザーの選択を取得

        if ($sort === 'averageRating') {
            $results = $query->orderByDesc(DB::raw('(SELECT AVG(evaluation) FROM reviews WHERE reviews.institution_id = institutions.id)'))->paginate($perPage);
        } elseif ($sort === 'reviewCount') {
            $results = $query->withCount('reviews')->orderBy('reviews_count', 'desc')->paginate($perPage);
        } else {
            $results = $query->paginate($perPage); // デフォルトの並び順
        }
        
        return view('top.dog-friendly', compact('institutions','results', 'averageRatings'));
    }

    public function getFacilityInfo($id)
    {
        $facility = Institution::find($id); // 施設IDに基づいてデータベースから施設情報を取得
        
        return response()->json($facility); // 取得した施設情報をJSON形式で返す
    }
}




