<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingResultController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// ホーム画面のルートを再設定
Route::get('/', [TrainingResultController::class,'home'])->name('home');

// 一覧画面のルートを設定
Route::get('/training_result', [TrainingResultController::class,'index'])->name('training_result.index');


// // 詳細画面用のルートを設定
// // URLに引数（id）を設定することにより、idをコントローラーで取得し、使用する。
Route::get('/training_result/{id}', [TrainingResultController::class,'show'])->name('training_result.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/training_result/create',[TrainingResultController::class, 'create'])->name('training_result.create');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 詳細画面用のルートを設定
// // URLに引数（id）を設定することにより、idをコントローラーで取得し、使用する。
// Route::get('/training_result/{id}', [TrainingResultController::class,'show'])->name('training_result.show');


require __DIR__.'/auth.php';
