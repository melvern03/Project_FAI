<?php

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

Route::get('/', function () {
    return view('Home');
});

Route::view('/aboutUsPage', 'AboutUs');
Route::view('/login', 'Login');
Route::view('/register', 'Register');
Route::get("/logout",function(){
    if(Session::has("userLog")){
        Session::forget("userLog");
    }
    return redirect("/login");
});

Route::post("/regCheck","MainController@regCheck");
Route::post("/logCheck","MainController@logCheck");
