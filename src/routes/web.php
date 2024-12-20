<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
// use Maatwebsite\Excel\Facades\Excel;

// ルートの基本設定
Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::get('/thanks', function () {
    return view('thanks');
});
Route::post('/thanks', [ContactController::class, 'store']);
Route::post('/admin', [ContactController::class, 'store'])->name('contact.submit');

// 新規登録ルート
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ログインルート
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// 認証が必要な管理画面ルート（`prefix` と `middleware` の両方を使う）
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
    Route::get('/{id}', [AdminController::class, 'show']);
    Route::delete('/{id}', [AdminController::class, 'destroy']);
});

// エクスポート機能（管理画面用）
Route::get('/export', function () {
    $contacts = App\Models\Contact::all();

});
