<?php

use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', 'userController@home' );

Route::view('/aboutUsPage', 'AboutUs');
Route::view('/login', 'Login');
Route::view('/cart', 'Cart');
Route::view('/register', 'Register');
Route::get('/shop', 'userController@shop')->name('shop');
Route::view('/detail', 'detail');
Route::get("/logout",function(){
    if(Session::has("userLog")){
        Session::forget("userLog");
    }
    return redirect("/login");
});

Route::post("/shop/sortBy","userController@shopSort");
Route::post("/shop/{kategori}","userController@shopCategory");
Route::post("/shop/sortBy/{kategori}","userController@shopCategorySort");
Route::post("/regCheck","MainController@regCheck");
Route::post("/logCheck","MainController@logCheck");
