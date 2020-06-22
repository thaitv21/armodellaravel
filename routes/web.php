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
    return redirect('/index');
});

Route::get('/index', 'FileController@show');

Route::get('/upload', 'FileController@showUpload');

Route::post('/upload', 'FileController@upload');

Route::get('/download/{filename}', 'FileController@download');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
