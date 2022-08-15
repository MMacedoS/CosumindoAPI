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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/authorization', 'App\Http\Controllers\configApiController@tokenKey');


Route::get('/categorias', 'App\Http\Controllers\CategoryController@index')->name('categorias.index')->middleware('auth');

Route::get('/categorias/atualiza', 'App\Http\Controllers\CategoryController@store')->name('atualizaCateg')->middleware('auth');

Route::get('/categorias/subcategoria/{id}', 'App\Http\Controllers\CategoryController@childrens')->name('categoria.filhos')->middleware('auth');

Route::get('/categorias/subcategoria/1/{id}', 'App\Http\Controllers\SubCategoryController@index')->name('subcategoria.filhos')->middleware('auth');

Route::get('/categorias/subcategoria/1/2/{id}', 'App\Http\Controllers\ChildCategoryController@index')->name('childcategoria.filhos')->middleware('auth');

Route::get('/categorias/subcategoria/1/2/3/{id}', 'App\Http\Controllers\ChildrenCategoryController@index')->name('childrencategoria.filhos')->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

    Route::resource('config', 'App\Http\Controllers\configApiController');

    Route::get('/{id}', 'App\Http\Controllers\configApiController@authorization')->name('authorization');


});

Route::resource('categorias', 'App\Http\Controllers\CategoryController')->middleware('auth');
