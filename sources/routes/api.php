<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get('shops/status', 'ApiController@shoplistStatus');
//Route::get('shops/{id}/status', 'ApiController@shopDetailStatus');
//Route::get('shops', 'ShopController@index');
//Route::get('shops/{id}', 'ShopController@show');
//Route::get('shops/{id}/chats', 'ApiController@Index');
//Route::post('shops/{id}/chats', 'ApiController@store')->name('shops/chat');
Route::get('sys-files/raw-data/{id}', 'SysFilesController@raw')->name('sys-files/raw');

Route::group(['middleware' => ['auth:api']], function() {

    Route::get('/me', 'UsersController@me');
    Route::post('sys-files/temp', 'SysFilesController@temp')->name('sys-files/temp');
    Route::put('sys-files/register', 'SysFilesController@register')->name('sys-files/register');
    Route::delete('sys-files/{id}', 'SysFilesController@destroy')->name('sys-files/destroy');
    Route::get('sys-files/thumbnail/{id}', 'SysFilesController@showThumbnail')->name('sys-files/showThumbnail');
    Route::get('sys-files/{id}', 'SysFilesController@show')->name('sys-files/show');

    $Resources = \Mopi::getResources();

    $Base_Res = array();
    foreach ($Resources as $name => $Resource) {
        $names = explode('/', $name);
        $controller_name_tmp = array_shift($names);
        $controller_name_tmps = explode('-', $controller_name_tmp);
        $controller_name_array = array();
        foreach ($controller_name_tmps as $s) {
            $controller_name_array[] = ucwords(strtolower($s));
        }
        $controller_name = implode($controller_name_array);
        if ($controller_name) {
            if (count($names)) {
                $method_name = $names[0];
                if (isset($Resource->method)) {
                    $method = (string) $Resource->method;
                } else if (false !== strpos($method_name, "store")) {
                    $method = 'post';
                } else if (false !== strpos($method_name, "update")) {
                    $method = 'put';
                } else if (false !== strpos($method_name, "delete")) {
                    $method = 'delete';
                } else {
                    $method = 'get';
                }
                Route::$method($name, $controller_name . 'Controller'. '@' . $method_name)->name($name);
            } else {
                $Base_Res[$name] = $controller_name;
            }
        }
    }
    foreach ($Base_Res as $a => $b) {
        Route::resource($a, $b . 'Controller', ['except' => ['create', 'edit']]);
    }

});