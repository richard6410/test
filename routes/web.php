<?php

use Illuminate\Support\Facades\Route;

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

/* Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
 */

Route::get('/', function () {
    return view('welcome');
});


Route::get('/public', function () {
    return view('public');
})->middleware(['auth'])->name('public');

require __DIR__.'/auth.php';



Route::get('/products','App\Http\Controllers\ProductController@index')->name('products.index');

Route::get('/products/create', 'App\Http\Controllers\ProductController@create')->name('product.create');
Route::post('/products/store', 'App\Http\Controllers\ProductController@store')->name('product.store');

Route::get('/products/edit/{product}', 'App\Http\Controllers\ProductController@edit')->name('product.edit');
Route::put('/products/edit/{product}', 'App\Http\Controllers\ProductController@update')->name('product.update');

Route::get('/products/show/{product}', 'App\Http\Controllers\ProductController@show')->name('product.show');

Route::delete('/products/destroy/{product}', 'App\Http\Controllers\ProductController@destroy')->name('product.destroy');

Route::get('/product/search', 'App\Http\Controllers\ProductController@search')->name('product.search');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/products/sort/{column}/{direction}', 'ProductController@index')->name('products.sort');

