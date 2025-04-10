<?php

use App\Http\Controllers\Admin\FaqsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    // return view('welcome');
    return redirect('super_admin');
});

Route::prefix('super_admin')->as('super_admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/change', [HomeController::class, 'change'])->name('change');
    Route::post('/updatePassword', [HomeController::class, 'updatePassword'])->name('password.update');

    Route::prefix('faqs')->as('faqs.')->group(function () {
        Route::get('/', [FaqsController::class, 'index'])->name('index');
        Route::post('store', [FaqsController::class, 'store'])->name('store');
        Route::post('update/{id}', [FaqsController::class, 'update'])->name('update');
        Route::post('delete', [FaqsController::class, 'delete'])->name('delete');
        Route::post('/import-faqs', [FaqsController::class, 'importFaqs'])->name('import');
    });



});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
