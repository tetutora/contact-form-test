<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Exports\ContactsExport;
use Maatwebsite\Excel\Facades\Excel;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm']);
// Route::post('/submit', [ContactController::class, 'store'])->name('contact.submit');
Route::post('/admin', [ContactController::class, 'store'])->name('contact.submit');
Route::get('/thanks', function () {
    return view('thanks');
});
Route::post('/thanks', function () {
    return view('thanks');
});


// 新規登録ルート
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ログインルート
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// 認証が必要な管理画面ルート
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');  // 管理画面
});

Route::middleware(['auth'])->group(function () {
    // admin という名前のルートを定義
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

Route::get('/admin/{id}', [AdminController::class, 'show']);
Route::delete('/admin/{id}', [AdminController::class, 'destroy']);
Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');


Route::get('/export', function () {
    $contacts = App\Models\Contact::all();
});
