<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// お問い合わせフォーム関連
Route::match(['get', 'post'], '/', [FormController::class, 'index']); // PG01 入力ページ
Route::post('/confirm', [FormController::class, 'confirm']);          // PG02 確認ページ
Route::post('/back', function (Illuminate\Http\Request $request) {    // 入力へ戻る（入力保持）
    return redirect('/')->withInput($request->all());
});
Route::post('/thanks', [FormController::class, 'store']);             // PG03 サンクスページ（送信処理）

// 管理画面関連
Route::get('/admin', [AdminController::class, 'index']);              // PG04 管理画面
Route::post('/delete/{id}', [AdminController::class, 'destroy'])      // PG07 削除
    ->name('contact.delete');
Route::get('/search', [AdminController::class, 'search']);            // PG05 検索
Route::get('/reset', [AdminController::class, 'reset']);              // PG06 検索リセット
Route::get('/export', [AdminController::class, 'export'])             // PG11 エクスポート（CSV）
    ->name('contact.export');

// ユーザー認証関連
Route::get('/register', [AuthController::class, 'showRegisterForm']); // PG08 ユーザー登録（表示）
Route::post('/register', [AuthController::class, 'register']);        // PG08 ユーザー登録（処理）
Route::get('/login', function () {                                    // PG09 ログイン（表示）
    return response()
        ->view('auth.login')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
})->name('login');

Route::post('/logout', [AuthController::class, 'logout'])             // PG10 ログアウト（処理）
    ->name('logout');
Route::get('/logged-out', [AuthController::class, 'showLogoutPage'])  // PG10 ログアウト後ページ（表示）
    ->name('logout.page');
