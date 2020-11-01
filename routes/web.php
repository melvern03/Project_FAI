<?php

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

Route::prefix("/")->group(function(){
    Route::view('/aboutUsPage', 'AboutUs');
    Route::view('/login', 'Login');
    Route::view('/register', 'Register');
    Route::get('/shop', 'userController@shop')->name('shop');
    Route::post("/shop/sortBy","userController@shopSort");
    Route::post("/shop/{kategori}","userController@shopCategory");
    Route::post("/shop/sortBy/{kategori}","userController@shopCategorySort");
    Route::view('/detail', 'detail');
    Route::get('/', 'userController@home' );
});




Route::prefix("admin")->group(function() {

    Route::view("/", "admin.loginAdmin");

    Route::view("/home","admin.main");
    Route::post("/addBaju","AdminController@addBaju");
    Route::view("/regAdmin","admin.adminReg");
});


Route::post("/regCheck","MainController@regCheck");
Route::post("/regAdmin","AdminController@adminReg");
Route::post("/logCheck","MainController@logCheck");
Route::post("/logAdmin","AdminController@adminLog");
Route::get("/logAuth","MainController@logout");
