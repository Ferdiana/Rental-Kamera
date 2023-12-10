<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
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

Route::group(['middleware' => "guest"], function() {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost']) ->name('register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
    Route::get('/', [LandingPageController::class, 'index']);

});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [HomeController::class, 'home']);
    Route::get('/product', [ProductController::class, 'product']);
    Route::get('/product/category/{category}', 'ProductController@showByCategory');
    Route::get('/product', [ProductController::class, 'product'])->name('product');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/show/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{transaction}/download', [TransactionController::class, 'download'])->name('transactions.download');

});


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');
    Route::get('/logout', [AdminAuthController::class, 'adminLogout'])->name('adminLogout');

    Route::group(['middleware' => 'adminauth'], function () {
        Route::get('/', function () {
            return view('welcome');
        })->name('adminDashboard');
        Route::get('posts/transaction/show-all', [PostController::class, 'showAllTransactions'])->name('admin.posts.transaction.show-all');
        Route::get('posts', [\App\Http\Controllers\Admin\PostController::class, 'index'])->name('admin.posts.index');
        Route::get('posts/create', [\App\Http\Controllers\Admin\PostController::class, 'create'])->name('admin.posts.create');
        Route::post('posts/store', [\App\Http\Controllers\Admin\PostController::class, 'store'])->name('admin.posts.store');
        Route::get('posts/show/{id}', [\App\Http\Controllers\Admin\PostController::class, 'show'])->name('admin.posts.show');
        Route::put('posts/update/{id}', [\App\Http\Controllers\Admin\PostController::class, 'update'])->name('admin.posts.update');
        Route::get('posts/edit/{id}', [\App\Http\Controllers\Admin\PostController::class, 'edit'])->name('admin.posts.edit');
        Route::delete('posts/destroy/{id}', [\App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('admin.posts.destroy');
    });
});


//Route::resource('/posts', \App\Http\Controllers\PostController::class);