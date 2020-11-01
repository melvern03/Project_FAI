<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class AdminController extends Controller
{
    function adminLog(Request $req){
        $validateData = $req->validate(
            [
                "password"=>"required",
                "username"=>"required"
            ],
            [
                "required"=>":Attribute tidak boleh kosong"
            ]
        );
        if (Auth::attempt($req->only(["username", "password"]))) {
            if(Auth::user()->status == "Aktif"){
                if(Auth::user()->jabatan == "Owner" || Auth::user()->jabatan == "admin"){
                    Users::where('username',Auth::user()->username)->update(['Last_Login'=>Carbon::now()]);
                    return \redirect("/admin/home")->with("success", "Selamat Datang!");

                }
            }
        }
    }

    function adminReg(){

    }

    function addBaju(Request $req){
        if($req->ukuran != null && $req->category!=null){
            if(count($req->namaVariasi) == count($req->ukuran) && count($req->namaVariasi) == count($req->category)){
                $tempId = "";
                if(Count(explode(" ",$req->NamaModel))>1){
                $tempData = explode(" ",$req->NamaModel);
                $tempId = strtoupper(substr($tempData[0],0,1).substr($tempData[1],0,1));
                }else{
                    $tempId = strtoupper(substr($req->NamaModel,0,2));
                }
                $countData = DB::table('h_baju')->where("ID_HBAJU","like","%".$tempId."%")->count()+1;
                if($countData < 10){
                    $tempId = $tempId."_00".$countData;
                }else if($countData < 100){
                    $tempId = $tempId."_0".$countData;
                }else{
                    $tempId = $tempId."_".$countData;
                }
                $req->file("gambarModel")->move(public_path("/baju"),$tempId."-".$req->file("gambarModel")->getClientOriginalName());
                DB::table('h_baju')->insert([
                    "ID_HBAJU"=>$tempId,
                    "NAMA_BAJU"=>$req->NamaModel,
                    "harga"=>$req->Harga,
                    "gambar"=>$tempId."-".$req->file("gambarModel")->getClientOriginalName(),
                    "time_added"=>Carbon::now()
                ]);
                for ($i=0; $i < count($req->namaVariasi); $i++) {
                    DB::table('d_baju')->insert([
                        "ID_HBAJU"=>$tempId,
                        "NAMA_BAJU"=>$req->namaVariasi[$i],
                        "WARNA"=>$req->color[$i],
                        "UKURAN"=>$req->ukuran[$i],
                        "STOK"=>$req->stock[$i],
                        "ID_KATEGORI"=>$req->category[$i]
                    ]);
                }
                return redirect("/admin/home")->with("Sucess","Berhasil Menambahkan Baju");
            }else{
                return redirect("/admin/home")->with("Errors","Gagal Menambahkan Baju");

            }
        }else{
            return redirect("/admin/home")->with("Errors","Berhasil Menambahkan Baju");
        }
        //dd($req->color);

        // $validateData = $req->validate(
        //     [
        //         "category"=>"required"
        //     ]
        // );
    }
}
