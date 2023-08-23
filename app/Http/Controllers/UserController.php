<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Models\User;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomPasswordResetMail;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {

    }


    public function register(Request $request)
    {
        $oldInput = $request->old();
        return view('user.register', compact('oldInput'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
        // バリデーションが成功した場合の処理
        $request->session()->put('user', $validatedData);

        return view('user.registerConfirm');
    }


    public function complete(Request $request)
    {
        $userData = $request->session()->get('user');
        User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password'])
        ]);

        $request->session()->forget('user');

        return view('user.registerComplete');
    }


    public function roguin(Request $request)
    {
        return view('user.roguin');
    }


    public function RePassword(Request $request)
    {
       return view('user.RePassword');
    }



  
    // パスワードリセットリクエストを受け付けるメソッド
    public function RePasswordMail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        // パスワードリセットリンクの生成とトークンの取得
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        if ($status === Password::RESET_LINK_SENT) {
            
    
            return view('user.RePassword-mail', ['email' => $request->email]);
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }

   

    public function PasswordComplete(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        // リセットリンクをクリックした後のリクエストに含まれるトークンやメールアドレスを表示
        dd($request->token, $request->email);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        // パスワードリセットの結果を表示
        dd($status);

        return $status === Password::PASSWORD_RESET
            ? view('user.password-complete')
            : back()->withErrors(['email' => __($status)]);
    }



    public function PWcomplete()
    {
        return view('user.password-complete');
    }

  
}

