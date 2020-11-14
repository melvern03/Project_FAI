<?php

namespace App\Http\Controllers;

use App\Http\Resources\resDbaju;
use App\Http\Resources\resourcesSort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class userController extends Controller
{
    public function addCart(Request $req){
        if (Auth::check()){
            $cart = Session::get('cart');
            if(isset($cart[Auth::user()->nama_user])){
                if(isset($cart[Auth::user()->nama_user][$req->idDbaju])){
                    $cart[Auth::user()->nama_user][$req->idDbaju]['qty'] += 1;
                }else{
                    $cart[Auth::user()->nama_user][$req->idDbaju] = array('id_dbaju' => $req->idDbaju,
                                                                          'id_hbaju' => $req->idHbaju,
                                                                          'qty' => 1);
                }
            }else{
                $cart[Auth::user()->nama_user][$req->idDbaju] = array('id_dbaju' => $req->idDbaju,
                                                                          'id_hbaju' => $req->idHbaju,
                                                                          'qty' => 1);
            }
            Session::put('cart', $cart);
        }

    }
    public function shop(){
        $barang["Hbaju"] = DB::table('h_baju')->get();
        $barang["baju"] = DB::table('d_baju')->get();
        return view("shop")->with($barang);
    }
    public function dbaju(Request $req){
        $dBarang = DB::table('d_baju as d')
        ->where('d.ID_HBAJU','=',$req->hbaju)
        ->get();
        return resDbaju::collection($dBarang);
    }
    public function home(){
        $barang["newArrival"] = DB::table('h_baju as h')
        ->join('d_baju as d', 'h.ID_HBAJU', '=', 'd.ID_HBAJU')
        ->select('d.ID_DBAJU as ID_DBAJU', 'h.gambar as gambar', 'h.harga as harga', 'd.NAMA_BAJU as nama', 'd.ukuran as ukuran', 'd.warna as warna')
        ->orderBy('h.time_added', 'desc')
        ->get();
        return view("Home")->with($barang);
    }
    public function shopSort(Request $req){
        if($req->btnSort == 'tertinggi'){
            $barang['Hbaju'] = DB::table('h_baju')
            ->orderBy('harga', 'desc')
            ->get();
        }else if($req->btnSort == 'terendah'){
            $barang['Hbaju'] = DB::table('h_baju')
            ->orderBy('harga', 'asc')
            ->get();
        }else if($req->btnSort == 'terbaru'){
            $barang['Hbaju'] = DB::table('h_baju')
            ->orderBy('time_added', 'desc')
            ->get();
        }else if($req->btnSort == 'terlama'){
            $barang['Hbaju'] = DB::table('h_baju')
            ->orderBy('time_added', 'asc')
            ->get();
        }else{
            return redirect("shop");
        }
        $barang["baju"] = DB::table('d_baju')->get();
        return view("shop")->with($barang);
    }
    public function shopCategory(Request $req){
        if($req->btnKategori){
            $barang['baju'] = DB::table('d_baju')->where('ID_KATEGORI',$req->btnKategori)->get();
            foreach ($barang['baju'] as $key => $value) {
                $barang["Hbaju"] = DB::table('h_baju')->where('ID_HBAJU',$value->ID_HBAJU)->get();
            }
            return view('shop')->with($barang);
        }else{
            return redirect("/shop");
        }

    }
    public function shopCategorySort(Request $req, $kategori){
        if($req->btnSort == 'tertinggi'){
            $barang["baju"] = DB::table('h_baju as h')
            ->join('d_baju as d', 'h.ID_HBAJU', '=', 'd.ID_HBAJU')
            ->select('d.ID_DBAJU as ID_DBAJU', 'h.gambar as gambar', 'h.harga as harga', 'd.NAMA_BAJU as nama', 'd.ukuran as ukuran', 'd.warna as warna')
            ->where('d.ID_KATEGORI',$kategori)
            ->orderBy('h.harga', 'desc')
            ->get();
        }else if($req->btnSort == 'terendah'){
            $barang["baju"] = DB::table('h_baju as h')
            ->join('d_baju as d', 'h.ID_HBAJU', '=', 'd.ID_HBAJU')
            ->select('d.ID_DBAJU as ID_DBAJU', 'h.gambar as gambar', 'h.harga as harga', 'd.NAMA_BAJU as nama', 'd.ukuran as ukuran', 'd.warna as warna')
            ->where('d.ID_KATEGORI',$kategori)
            ->orderBy('h.harga', 'asc')
            ->get();
        }else if($req->btnSort == 'terbaru'){
            $barang["baju"] = DB::table('h_baju as h')
            ->join('d_baju as d', 'h.ID_HBAJU', '=', 'd.ID_HBAJU')
            ->select('d.ID_DBAJU as ID_DBAJU', 'h.gambar as gambar', 'h.harga as harga', 'd.NAMA_BAJU as nama', 'd.ukuran as ukuran', 'd.warna as warna')
            ->where('d.ID_KATEGORI',$kategori)
            ->orderBy('h.time_added', 'desc')
            ->get();
        }else if($req->btnSort == 'terlama'){
            $barang["baju"] = DB::table('h_baju as h')
            ->join('d_baju as d', 'h.ID_HBAJU', '=', 'd.ID_HBAJU')
            ->select('d.ID_DBAJU as ID_DBAJU', 'h.gambar as gambar', 'h.harga as harga', 'd.NAMA_BAJU as nama', 'd.ukuran as ukuran', 'd.warna as warna')
            ->where('d.ID_KATEGORI',$kategori)
            ->orderBy('h.time_added', 'asc')
            ->get();
        }
        return view('shop')->with($barang);
    }
    public function cekSession(){
        // Session::forget('cart');
        // Session::forget('barang');
        dd(Session::all());
    }
}
