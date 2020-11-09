<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class cartcontroler extends Controller
{
    public function kirim($id,$harga)
    {
        Session::put('kirim',$id);
        Session::put('harga',$harga);
        return view("Waiting");
    }

    public function checkout(Request $req)
    {
        $validasi = $req->validate(
            [
                'file' => 'required'
            ],
            [
                'file.required' => 'harus upload file terlebih dahulu',

            ]
        );
        $tempId = "CK";
        $countData = DB::table('h_jual')->where("id_hjual","like","%".$tempId."%")->count()+1;
        if($countData < 10){
            $tempId = $tempId."_00".$countData;
        }else if($countData < 100){
            $tempId = $tempId."_0".$countData;
        }else{
            $tempId = $tempId."_".$countData;
        }
        // $req->file("file")->move(public_path("/Transfer"),$tempId."-".$req->file("file")->getClientOriginalName());
        DB::table('h_jual')->insert(
            [
                'id_hjual' => $tempId,
                'tgl_jual' => Carbon::now(),
                'id_user' => DB::table('user')->where('nama_user',Auth::User()->nama_user)->value('id_user'),
                'status' => 0
            ]
        );

        return view('Track');
    }
}
