<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ユーザー登録フォーム表示
    public function showRegisterForm()
    {
        return view('auth.register'); // Blade ファイルを表示
    }

    // ユーザー登録処理
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user); // 登録後に自動ログイン

        return redirect('/admin'); // 管理画面に遷移
    }

    // POST /logout 用の既存ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();                        // ログアウト
        $request->session()->invalidate();      // セッション破棄
        $request->session()->regenerateToken(); // CSRFトークン再生成

        return redirect()->route('logout.page');            // ログイン画面へリダイレクト
    }

    // GET /logout 用の新しいログアウトページ表示
    public function showLogoutPage(Request $request)
    {
        Auth::logout();                        // ログアウト
        $request->session()->invalidate();      // セッション破棄
        $request->session()->regenerateToken(); // CSRFトークン再生成

        return view('auth.logout');            // ログアウトページ表示
    }
}
