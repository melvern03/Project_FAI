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
    if(Auth::check()){
        if(Auth::user()->jabatan != "Member"){
            Auth::logout();
        }
    }
    Route::view('/aboutUsPage', 'AboutUs');
    Route::view('/login', 'Login');
    Route::view('/register', 'Register');
    Route::view('/shop', 'shop');
    Route::view('/detail', 'detail');
    Route::get('/',function(){
        if(Auth::check()){
            if(Auth::user()->jabatan != "Member"){
                Auth::logout();
            }
        }
        return view("Home");
    });
});


Route::prefix("admin")->group(function() {

    Route::view("/", "admin.loginAdmin");

    Route::view("/home","admin.main");
    Route::post("/addBaju","AdminController@addBaju");
});

Route::post("/regCheck","MainController@regCheck");
Route::post("/logCheck","MainController@logCheck");
Route::post("/logAdmin","AdminController@adminLog");
Route::get("/logAuth","MainController@logout");
