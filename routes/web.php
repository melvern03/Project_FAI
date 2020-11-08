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
    Route::get('/addToCart', 'userController@addCart')->name('addCart');
    Route::post("/shop/{kategori}","userController@shopCategory");
    Route::post("/shop/sortBy/{kategori}","userController@shopCategorySort");
    Route::view('/detail', 'detail');
    Route::view('/cart', 'Cart');
    Route::get('/pilih/{id}','cartcontroler@kirim');
    Route::post('/checkout','cartcontroler@checkout');
    Route::view('/trans', 'Track');
    Route::get("/","userController@home");
    Route::view("/aboutUs","AboutUs");
    Route::view("/cart","cart");

    Route::get("/sortBy","userController@shopSort");
    Route::get("/dbaju","userController@dbaju");
    Route::get("/cek","userController@cekSession");
});




Route::prefix("admin")->group(function() {

    Route::view("/", "admin.loginAdmin");

    Route::view("/home","admin.main");
    Route::view("/addBaju","admin.adminAddBaju");
    Route::post("/addNew","AdminController@addBaju");
    Route::get("/home/variant", "AdminController@searchVariant");
    Route::get("/home/getDataBaju","AdminController@searchData");
    Route::get("/home/editVariant","AdminController@editData");
    Route::get("/home/deleteVariant","AdminController@deleteVariant");
    Route::view("/regAdmin","admin.adminReg");
});


Route::post("/regCheck","MainController@regCheck");
Route::post("/regAdmin","AdminController@adminReg");
Route::post("/logCheck","MainController@logCheck");
Route::post("/logAdmin","AdminController@adminLog");
Route::get("/logAuth","MainController@logout");
Route::get("/logAuthAdmin","AdminController@logAdmin");
