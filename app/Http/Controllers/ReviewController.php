<?php

namespace App\Http\Controllers;
use App\Models\Institution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    


    public function list(Request $request) {
        $order_by = $request->input('order_by', 'created_at');
        $order_direction = $request->input('order_direction', 'desc');
        $pet_size = $request->input('pet_size', '');
        $institution_id = $request->input('id');
        
        $query = Review::query();
    
        // インスティテューションIDが指定されている場合は、該当するレビューのみ取得
        if ($institution_id) {
            $query->where('institution_id', $institution_id);
        }
    
        // ペットサイズのフィルタリング
        if ($pet_size === '大型' || $pet_size === '中型' || $pet_size === '小型') {
            $query->where('pet_size', $pet_size);
        }
    
        // 並び替え
        $query->orderBy($order_by, $order_direction);
    
        // ページネーションを追加
        $reviews = $query->paginate(10); // 1ページに10件表示
    
        $institution = Institution::find($institution_id);
        
        return view('reviews.list', compact('reviews', 'institution'));
        
    }


    public function confirm(Request $request){
        $request->session()->put('oldInput', $request->input());
        return view('reviews.confirm');
    }


        public function store(Request $request)
    {
        // フォームからのデータを受け取る
        $data = $request->all();
        $data['user_id'] = Auth::id();
        // データベースに保存する
        $review = new Review();
    
        $review->user_id = $data['user_id'];
        $review->evaluation = $data['star'];
        $review->nickname = $data['nickname'];
        $review->pet_size = $data['dog_size'];
        $review->comment = $data['comment'];
        $review->institution_id = $data['institution_id'];
    
        
    
        $review->save();
        $InstitutionId = $request->input('institution_id');
        $reviews = Review::where('institution_id', $InstitutionId)->paginate(10);
        $institution = Institution::where('id', $InstitutionId)->first();
        
    return view('reviews.list', compact('institution','reviews'));

    
     
    }
}
