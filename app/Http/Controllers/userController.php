<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{
    public function shop(){
        $barang["baju"] = DB::table('h_baju as h')
        ->join('d_baju as d', 'h.ID_HBAJU', '=', 'd.ID_HBAJU')
        ->select('d.ID_DBAJU as ID_DBAJU', 'h.gambar as gambar', 'h.harga as harga', 'd.NAMA_BAJU as nama', 'd.ukuran as ukuran', 'd.warna as warna')
        ->get();
        return view("shop")->with($barang);
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
            $barang["baju"] = DB::table('h_baju as h')
            ->join('d_baju as d', 'h.ID_HBAJU', '=', 'd.ID_HBAJU')
            ->select('d.ID_DBAJU as ID_DBAJU', 'h.gambar as gambar', 'h.harga as harga', 'd.NAMA_BAJU as nama', 'd.ukuran as ukuran', 'd.warna as warna')
            ->orderBy('h.harga', 'desc')
            ->get();
        }else if($req->btnSort == 'terendah'){
            $barang["baju"] = DB::table('h_baju as h')
            ->join('d_baju as d', 'h.ID_HBAJU', '=', 'd.ID_HBAJU')
            ->select('d.ID_DBAJU as ID_DBAJU', 'h.gambar as gambar', 'h.harga as harga', 'd.NAMA_BAJU as nama', 'd.ukuran as ukuran', 'd.warna as warna')
            ->orderBy('h.harga', 'asc')
            ->get();
        }else if($req->btnSort == 'terbaru'){
            $barang["baju"] = DB::table('h_baju as h')
            ->join('d_baju as d', 'h.ID_HBAJU', '=', 'd.ID_HBAJU')
            ->select('d.ID_DBAJU as ID_DBAJU', 'h.gambar as gambar', 'h.harga as harga', 'd.NAMA_BAJU as nama', 'd.ukuran as ukuran', 'd.warna as warna')
            ->orderBy('h.time_added', 'desc')
            ->get();
        }else if($req->btnSort == 'terlama'){
            $barang["baju"] = DB::table('h_baju as h')
            ->join('d_baju as d', 'h.ID_HBAJU', '=', 'd.ID_HBAJU')
            ->select('d.ID_DBAJU as ID_DBAJU', 'h.gambar as gambar', 'h.harga as harga', 'd.NAMA_BAJU as nama', 'd.ukuran as ukuran', 'd.warna as warna')
            ->orderBy('h.time_added', 'asc')
            ->get();
        }
        return view('shop')->with($barang);
    }
    public function shopCategory(Request $req){
        $barang["baju"] = DB::table('h_baju as h')
            ->join('d_baju as d', 'h.ID_HBAJU', '=', 'd.ID_HBAJU')
            ->select('d.ID_DBAJU as ID_DBAJU', 'h.gambar as gambar', 'h.harga as harga', 'd.NAMA_BAJU as nama', 'd.ukuran as ukuran', 'd.warna as warna')
            ->where('d.ID_KATEGORI',$req->btnKategori)
            ->get();
        $barang['kategori'] = $req->btnKategori;
        return view('shop')->with($barang);
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
}
