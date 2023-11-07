<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

App::setLocale('ja');
//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home', static function(){
    return view('home');
});

//Route::get('/admin/', function () {
//    if (Auth::check()) {
//        return view('admin');
//    }
//    return redirect('/login');
//});
//    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware(['auth:web'])->group(static function () {
    Route::get('/users', [UsersController::class,'index']);
    Route::post('/users', [UsersController::class, 'create']);
    // Vue.jsアプリへのアクセス
    Route::get('/admin', static function () {
        if (Auth::check()) {
            return view('admin');
        }
        return redirect('/login');
//        return view('admin');
    });

    Route::get('/admin/{any}', static function () {
        return view('admin');
    })->where('any', '.*');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/shop/detail/{number}', function () {
    return view('welcome');
})->where('number', '[0-9]+');

