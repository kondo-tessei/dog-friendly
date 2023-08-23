<?php
use App\Http\Controllers\TopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\Institution;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//新規登録//

Route::get('/', function () {
    return View::make('user.register');
});

Route::get('/userRegister', [UserController::class, 'register'])->name('userRegister');
Route::post('/registration', [UserController::class, 'store'])->name('registration.store');
Route::post('/registerComplete', [UserController::class, 'complete'])->name('registerComplete');




//ログイン関連//

Route::get('/roguin', [UserController::class, 'roguin'])->name('roguin');


Route::post('/roguinCheck', function () {
    $credentials = request()->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $auths = Auth::user();
        $institutions = Institution::all()->toArray();
        return view('top.dog-friendly', compact('institutions','auths'));
       
    } else {
        // 認証失敗時の処理
        return back()->withErrors(['error' => '認証に失敗しました。']);
    }
});

Route::get('/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    $institutions = app(TopController::class)->map();

    return view('top.dog-friendly', compact('institutions'));
});







//パスワード変更//
Route::get('/RePassword', [UserController::class, 'RePassword'])->name('RePassword');
Auth::routes();
Route::post('/RePassword-mail-complete', [UserController::class, 'RepasswordMail'])->name('Repassword-mail');
Route::post('/password/reset/password-complete', [UserController::class, 'PasswordComplete'])->name('password-complete');
Route::get('/password/reset/register', [UserController::class, 'PasswordComplete'])->name('password-complete');
Route::get('/passwordComplete', [UserController::class, 'PWcomplete']);

Route::get('/dog-friendly', [TopController::class, 'top'])->name('top');
Route::get('/reset-password/{token}', function ($token) {
    return view('user.changePassword', ['token' => $token]);
});

Route::get('/reset-password/{token}/{email}', function ($token, $email) {
    return view('user.changePassword', ['token' => $token, 'email' => $email]);
})->middleware('guest')->name('password.reset');









Route::post('/password', function (Request $request) {
    $request->validate([
        'password' => 'required|confirmed|min:8',
    ]);

    // リセットリンクをクリックした後のリクエストに含まれるトークンやメールアドレスを表示

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->save();
        }
    );

    // パスワードリセットの結果を表示

    return $status === Password::PASSWORD_RESET
        ? view('user.password-complete')
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.update');





//施設登録関連
Route::get('/institution-register', function () {
    if (Auth::check()) {
        return view('institution.regster');
    } else {
        return view('user.roguin', ['message' => '施設登録にはログインが必要です。']);
    }
});
Route::post('/institution-confirm', [TopController::class, 'confirm'])->name('institution-cofirm');
Route::get('/institution-confirm', [TopController::class, 'confirm'])->name('institution-cofirm');
Route::post('/institution-store', [TopController::class, 'store'])->name('institution-store');




Route::get('/ok', function () {
    return view('top.map.select');
});
Route::get('/seach', [TopController::class, 'search'])->name('search');




Route::get('/info/${id}', [TopController::class, 'getFacilityInfo']);









//レビュー

Route::get('/reviewList', [ReviewController::class, 'list'])->name('reviewList');

Route::get('/reviewRegister/{id}', function ($id) {
    return view('reviews.reviewRegister', ['institutionId' => $id]);
})->name('reviewRegister');

Route::post('/reviewConfirm', [ReviewController::class, 'confirm'])->name('reviewConfirm');

Route::post('/reviewList', [ReviewController::class, 'store'])->name('reviewListBack');