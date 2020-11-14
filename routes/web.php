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
    // User
    Route::get("/","userController@home");
    Route::view("/aboutUs","AboutUs");
    Route::view('/aboutUsPage', 'AboutUs');
    Route::view("/verifikasi","verifikasi");
    Route::post("/verifikasiData","MainController@verifikasi");
    Route::view("/cart","cart");
    Route::view('/login', 'Login');
    Route::view('/register', 'Register');
    //End User

    //Shop
    Route::get('/shop', 'userController@shop')->name('shop');
    Route::post("/shop/{kategori}","userController@shopCategory");
    Route::post("/shop/sortBy/{kategori}","userController@shopCategorySort");
    Route::get('/addToCart', 'userController@addCart')->name('addCart');
    //End Shop

    //Transaksi
    Route::view('/cart', 'Cart');
    Route::get('/hapus/{id}','cartcontroler@hapuscart');
    Route::get('/pilih/{id}/{harga}','cartcontroler@kirim');
    Route::post('/checkout','cartcontroler@checkout');
    Route::view('/trans', 'Track');
    //End Transaksi
    Route::get("/cek","userController@cekSession");

    Route::view("/history","HistoryTrans");
    Route::view("/profile","profile");

});




Route::prefix("admin")->group(function() {

    Route::view("/", "admin.loginAdmin");

    Route::view("/home","admin.main");

    // Model & Variant
    Route::view("/addBaju","admin.adminAddBaju");
    Route::post("/addNew","AdminController@addBaju");
    Route::get("/home/variant", "AdminController@searchVariant");
    Route::get("/home/getDataBaju","AdminController@searchData");
    Route::get("/home/editVariant","AdminController@editData");
    Route::get("/home/deleteVariant","AdminController@deleteVariant");
    Route::post("/home/AddVariant","AdminController@addVariant");
    Route::post("/home/addMoreVariant","AdminController@addMoreVariant");
    // end Model & Variant

    Route::view("/list","admin.adminList");
    Route::view("/RegAdmin","admin.regAdmin");
    Route::post("/addNewAdmin","AdminController@adminReg");

    //Admin Transaksi
    Route::view("/ListTransaksi","admin.transaksi");
});


Route::post("/regCheck","MainController@regCheck");
Route::post("/regAdmin","AdminController@adminReg");
Route::post("/logCheck","MainController@logCheck");
Route::post("/logAdmin","AdminController@adminLog");
Route::get("/logAuth","MainController@logout");
Route::get("/logAuthAdmin","AdminController@logAdmin");
