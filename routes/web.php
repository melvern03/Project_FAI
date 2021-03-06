<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
Use App\Model\h_transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

Route::middleware(["CheckAdmin"])->group(function(){
    Route::prefix("/")->group(function(){
        // User
        Route::get("/","userController@home");
        Route::view("/aboutUs","AboutUs");
        Route::view("/cart","cart");
        Route::view('/login', 'Login');
        Route::view('/register', 'Register');
        //End User

        //Shop
        Route::get('/shop', 'userController@shop')->name('shop');
        Route::any("/shop/sort","userController@shopSort");
        Route::any("/shop/{kategori}","userController@shopCategory");
        Route::any("/shop/{kategori}/sort","userController@shopCategorySort");
        Route::get('/addToCart', 'userController@addCart')->name('addCart');
        //End Shop
        //Detail
        Route::view('/detail','detail');
        Route::any('/detail/{hbaju}','userController@detail');
        Route::any('/detail/{hbaju}/{dbaju}','userController@detailItem');
        //EndDetail

        //Function Feedback
        Route::post("/AddCustomerFeedback","userController@AddFeedback");
        Route::get("/AddFeedbackFromFooter","userController@AddFeedbackFooter");

        Route::get("/cek","userController@cekSession");

        Route::middleware(["CheckLogin"])->group(function(){
            //Detail Transaksi
            Route::get("/DetailTransaksi/{id}","userController@getDataDetail");
            //End Detail

            //Review
            Route::post("/getDataForReview","userController@getDataReview");
            Route::view("/Review","Review");
            Route::post("/addReview","userController@addReview");
            //End Review

            Route::view("/History","HistoryTrans");
            Route::get("/profile","userController@showProfile");
            Route::post("/profile/{data}","userController@profileChange");
            Route::post("/uploadNewFile","MainController@addNewFile");

            //Transaksi
            Route::view('/cart', 'Cart');
            Route::get("/addJumlahCart","cartcontroler@AddItem");
            Route::get("/minusJumlahCart","cartcontroler@MinusItem");
            Route::get('/hapus/{id}','cartcontroler@hapuscart');
            Route::get('/pilih/{id}/{harga}','cartcontroler@kirim');
            Route::post('/checkout','cartcontroler@checkout');
            Route::get("/OrderFinishUser","userController@finishOrder");
            Route::view('/trans', 'Track');
            Route::get("/addPromoCode","cartcontroler@addPromoCode");
            //End Transaksi

            Route::view("/Feedback","feedbackUser");
        });

    });
});
Route::middleware(["CheckUser"])->group(function(){

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

    //Admin List & Reg
    Route::view("/list","admin.adminList");
    Route::view("/RegAdmin","admin.regAdmin");
    Route::post("/addNewAdmin","AdminController@adminReg");
    Route::get("/DeleteAdmin","AdminController@DeleteAdmin");
    Route::get("/ChangeStatus","AdminController@AdminStatus");
    //End Admin List & reg

    //Admin Transaksi
    Route::view("/ListTransaksi","admin.transaksi");
    Route::get("/ListTransaksi/ProcessOrder","AdminController@ProcessOrder");
    Route::get("/ListTransaksi/getDetail","AdminController@getDataJual");
    Route::view("/ListTransaski/History","admin.listDone");
    Route::get("/ListTransaksi/InvalidPayment","AdminController@InvalidPayment");
    Route::get("/ListTransaksi/FinishOrder","AdminController@FinishOrder");
    //End Admin Transaksi

    // Function Users
    Route::view("/listUsers","admin.listUsers");
    Route::get("/listUsers/statusChange","AdminController@UserStatus");
    Route::get("/listUsers/DeleteUser","AdminController@DeleteUsers");
    //End Functio Users

    //Function Kategory
    Route::view("/Kategori","admin.listKategory");
    Route::view("/Kategori/Add","admin.addKategory");
    Route::post("/Kategori/Add/AddNew","AdminController@AddNewKategori");
    //End Function Kategory

    //Function Promo
    Route::view("/Promo","admin.listPromo");
    Route::view("/Promo/Add","admin.addPromo");
    Route::post("/Promo/Add/AddPromo","AdminController@AddNewPromo");
    Route::get("/Promo/GetdataPromo","AdminController@GetDataPromo");
    Route::get("/Promo/editPromo","AdminController@EditPromo");
    Route::get("/Promo/DeletePromo","AdminController@DeletePromo");
    //End Function Promo

    //Function Laporan
    Route::view("/Report","admin.laporan");
    Route::get("/Report/GetData","AdminController@getDataReport");
    Route::get("/Report/GetDataBaju","AdminController@getDataReportBaju");
    //End Function Laporan

    //Function Feedback
    Route::view("/Feedback","admin.listFeedback");
});
});



Route::post("/regCheck","MainController@regCheck");
Route::post("/regAdmin","AdminController@adminReg");
Route::post("/logCheck","MainController@logCheck");
Route::post("/logAdmin","AdminController@adminLog");
Route::get("/logAuth","MainController@logout");
Route::get("/logAuthAdmin","AdminController@logAdmin");

//Verifikasi without middleware
Route::view("/verifikasi","verifikasi");
Route::post("/verifikasiData","MainController@verifikasi");
Route::get("/VerifByEmail/{id}/{kode}","MainController@VerifikasiByEmail");

Route::view("/getTimeStamp","admin.testChart");
