<?php

namespace App\Http\Controllers;

use App\Http\Resources\Variant;
use Illuminate\Http\Request;
use App\Model\Users;
use App\Model\h_transaksi;
use App\Model\d_jual;
use App\Model\Category;
use App\Model\Promo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class AdminController extends Controller
{
    function logAdmin(){
        Auth::logout();
        return redirect("/");
    }

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
                if(Auth::user()->jabatan == "Owner" || Auth::user()->jabatan == "Admin"){
                    Users::where('username',Auth::user()->username)->update(['Last_Login'=>Carbon::now()]);
                    return \redirect("/admin/home")->with("success", "Selamat Datang!");
                }else{
                    Auth::logout();
                    return redirect("/admin")->with("NotAdmin","kamu bukan admin");
                }
            }else if(Auth::user()->status=="Disabled"){
                Auth::logout();
                return redirect("/admin")->with("gagal","failed");
            }
        }
        return redirect("/admin")->with("errors","ok");
    }

    function adminReg(Request $req){
        $pas = $req->Password;
        $validateData = $req->validate(
            [
                "Username"=>["required","unique:App\Model\Users,username"],
                "Email"=>["required","email","unique:App\Model\Users,email"],
                "Password"=>["required"],
                "ConPass"=>["in:".$pas],
                "NoHp"=>["required","numeric","unique:App\Model\Users,no_telp"],
                "Alamat"=>["required"],
                "Nama"=>["required","min:2"],
                "gender"=>["required"]
            ],
            [
                "required" => ":Attribute tidak boleh kosong",
                "ConPass.in"=>"Password Tidak Sama",
                "unique"=>":Attribute sudah terdaftar",
                "NoHp.unique"=>"Nomor Telefon Sudah terdaftar",
                "NoHp.required"=>"Nomor Telefon Tidak Boleh Kosong",
                "gender.required"=>"Harus memilih salah satu gender"
            ]
        );
        $tempUser = "";
        if(Count(explode(" ",$validateData['Nama']))>1){
           $tempData = explode(" ",$validateData["Nama"]);
           $tempUser = strtoupper(substr($tempData[0],0,1).substr($tempData[1],0,1));
        }else{
            $tempUser = strtoupper(substr($validateData["Nama"],0,2));
        }
        $countData = Users::where("id_user","like","%".$tempUser."%")->count()+1;
        if($countData < 10){
            $tempUser = $tempUser."_00".$countData;
        }else if($countData < 100){
            $tempUser = $tempUser."_0".$countData;
        }else{
            $tempUser = $tempUser."_".$countData;
        }
        $pass = password_hash($validateData["Password"], \PASSWORD_DEFAULT);
        $newUsers = new Users();
        $newUsers->id_user = $tempUser;
        $newUsers->nama_user = $validateData["Nama"];
        $newUsers->username = $validateData["Username"];
        $newUsers->email = $validateData["Email"];
        $newUsers->password = $pass;
        $newUsers->alamat = $validateData["Alamat"];
        $newUsers->jk = $validateData["gender"];
        $newUsers->no_telp = $validateData["NoHp"];
        $newUsers->status="Aktif";
        $newUsers->jabatan="Admin";
        $newUsers->save();
        return redirect("/admin/list")->with('SuccessAdd',"Berhasil");
    }

    // Baju Function
    function addBaju(Request $req){
        $validate = $req->validate(
            [
                "gambarModel"=>"mimetypes:image/jpeg,image/png",
                "NamaModel"=>"required",
                "Harga"=>"required"
            ],
            [
                "gambarModel.mimetypes"=>"File yang diupload harus dalam bentuk gambar"
            ]
        );
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
    }
    function searchVariant(Request $req){
        $arrData = [];
        foreach(DB::table("d_baju")->where("ID_HBAJU",$req->nama)->get() as $item){
            $dataBaru = array(
                "ID_HBAJU"          => $item->ID_HBAJU,
                "id_dbaju"          => $item->id_dbaju,
                "NAMA_BAJU"         => $item->NAMA_BAJU,
                "WARNA"             => $item->WARNA,
                "UKURAN"            => $item->UKURAN,
                "STOK"              => $item->STOK,
                "NAMA_KATEGORI"          => DB::table('kategori')->where('ID_KATEGORI',$item->ID_KATEGORI)->value('NAMA_KATEGORI')
            );
            $arrData[] = $dataBaru;
        }
        return json_encode($arrData);
    }
    function searchData(Request $req){
        $arrData = DB::table("d_baju")->where("id_dbaju",$req->nama)->get();
        return Variant::collection($arrData);
    }

    function editData(Request $req){
        $nama = $req->nama;
        $warna = $req->warna;
        $ukuran = $req->ukuran;
        $stok = $req->stok;
        $kategori = $req->kategori;
        try {
            DB::table('d_baju')->where("id_dbaju",$req->id)->update(["NAMA_BAJU"=>$nama, "WARNA"=>$warna, "UKURAN"=>$ukuran, "ID_KATEGORI"=>$kategori, "STOK"=>$stok]);
            return "succes";
        } catch (\Throwable $th) {
            return "gagal";
        }

    }
    function deleteVariant(Request $req){
        try {
            DB::table('d_baju')->where('id_dbaju',$req->nama)->delete();
            return "succes";
        } catch (\Throwable $th) {
            return "gagal";
        }
    }

    function addVariant(Request $req){
        $data["id"]= $req->idBtn;
        return view('admin.AddVariant')->with($data);
    }
    function addMoreVariant(Request $req){
        if($req->ukuran != null && $req->category != null){
            if(count($req->namaVariasi) == count($req->ukuran) && count($req->namaVariasi) == count($req->category)){
                $id = $req->btnAddNewVariant;
                for ($i=0; $i < count($req->namaVariasi); $i++) {
                    DB::table('d_baju')->insert([
                        "ID_HBAJU"=>$id,
                        "NAMA_BAJU"=>$req->namaVariasi[$i],
                        "WARNA"=>$req->color[$i],
                        "UKURAN"=>$req->ukuran[$i],
                        "STOK"=>$req->stock[$i],
                        "ID_KATEGORI"=>$req->category[$i]
                    ]);
                }
                return redirect("/admin/home")->with("variantDone","ok");
            }
        }else{
            return redirect("/admin/home")->with("errors","kosong");
        }
    }
    //End Baju Function

    // Transaksi Function
    function ProcessOrder(Request $req){
        $cek = true;
        foreach (d_jual::where('id_hjual',$req->id)->get() as $item) {
            if($item->qty > DB::table('d_baju')->where('NAMA_BAJU',$item->nama_barang)->value("STOK")){
                $cek = false;
            }
        }
        if($cek){
            $body = "<h1 align='center'>Order In Process</h1>
            <h2 align='center'> Order ID  : ".$req->id."</h2>
            <p align='center' style='font-size:16pt'>Order anda sedang di process dan akan dikirim apabila sudah siap</p>";
            $to = Users::where('id_user',h_transaksi::where('id_hjual',$req->id)->value('id_user'))->value('email');
            if($this->sendEmail($to,"Order In Process",$body) == "sent"){
                h_transaksi::where("id_hjual",$req->id)->update(["status"=>"1"]);
                foreach (d_jual::where('id_hjual',$req->id)->get() as $item) {
                    $newStock = DB::table('d_baju')->where('NAMA_BAJU',$item->nama_barang)->value('STOK') - $item->qty;
                    DB::table('d_baju')->where('NAMA_BAJU',$item->nama_barang)->update(["STOK"=>$newStock]);
                }
                return "Success";
            }else{
                return "email";
            }

        }
        return "Stock";
    }

    function getDataJual(Request $req){
        $data = [];
        foreach (d_jual::where('id_hjual',$req->id)->get() as $key => $value) {
            $Newdata = [
                "nama_baju"=> $value->nama_barang,
                "jumlah"=>$value['qty'],
                "harga"=>$value["harga"],
                "subtotal"=>$value['subtotal'],
                "diskon"=>DB::table('h_jual')->where('id_hjual',$value['id_hjual'])->value("diskon")
            ];
            $data[] = $Newdata;
        }
        return json_encode($data);
    }

    function InvalidPayment(Request $req){
        $body = "<h1 align='center'>Payment invalid</h1>
        <h2 align='center'> Order ID  : ".$req->id."</h2>
        <p align='center' style='font-size:14pt'>Pembayaran anda tidak valid, berikut merupakan bukti pembayaran yang anda kirim<br>Silahkan mengupload kembali bukti transfer yang baru di halaman history transaksi anda <br>Terima Kasih</p>";
        $to = Users::where('id_user',h_transaksi::where('id_hjual',$req->id)->value('id_user'))->value('email');
        $foto = h_transaksi::where('id_hjual',$req->id)->value('gambar');
        if($this->invalidEmail($to,"Invalid Payment",$body,$foto) == "sent"){
            h_transaksi::where("id_hjual",$req->id)->update(["status"=>"3"]);
            return "Success";
        }

        return "gagal";
    }

    function FinishOrder(Request $req){
        $body = "<h1 align='center'>Order Sedang Dikirim</h1>
        <h2 align='center'> Order ID  : ".$req->id."</h2>
        <p align='center' style='font-size:14pt'>Order anda sedang kami kirim<br>apabila barang sudah tiba mohon untuk konfirmasi melalui halaman history transaksi<br>Terima kasih</p>";
        $to = Users::where('id_user',h_transaksi::where('id_hjual',$req->id)->value('id_user'))->value('email');
        if($this->sendEmail($to,"Order Sent",$body)){
            h_transaksi::where("id_hjual",$req->id)->update(["status"=>"4"]);
            return "Success";
        }
        return "gagal";
    }
    //End Transaksi Function

    //Function Admin List
    function DeleteAdmin(Request $req){
        Users::where("id_user",$req->id)->delete();
        return "Success";
    }

    function AdminStatus(Request $req){
        if($req->type == "enable"){
            Users::where("id_user",$req->id)->update(["status"=>"Aktif"]);
        }else if($req->type =="Disable"){
            Users::where("id_user",$req->id)->update(["status"=>"Disabled"]);
        }
        return "Success";
    }
    //End Function Admin List

    //Function User
    function UserStatus(Request $req){
        if($req->type == "unblacklist"){
            Users::where("id_user",$req->id)->update(["status"=>"Aktif"]);
        }else if($req->type =="blacklist"){
            Users::where("id_user",$req->id)->update(["status"=>"Blacklist"]);
        }
        return "Success";
    }

    function DeleteUsers(Request $req){
        Users::where('id_user',$req->id)->delete();
        return "Success";
    }
    //End Function User

    //Function Kategori
    function AddNewKategori(Request $req){
        $valid = $req->validate(
            [
                "NamaKategori"=>"regex:/^([^0-9]*)$/"
            ],
            [
                "NamaKategori.regex"=>"Nama Kategori Tidak Boleh Mengandung Angka"
            ]
        );
        $count = 0;
        foreach (Category::all() as $key) {
            if(strtolower(trim($key->NAMA_KATEGORI)) == strtolower(trim($req->NamaKategori))){
                $count = $count + 1;
            }
        }
        if($count==0){
            $newCategory = new Category();
            $newCategory->NAMA_KATEGORI = $req->NamaKategori;
            $newCategory->save();
            return redirect("/admin/Kategori/Add")->with("Success","ada");
        }else{
            return redirect("/admin/Kategori/Add")->with("errorDup","ada");
        }
    }
    //end Function Kategori

    //Function Promo
    function AddNewPromo(Request $req){
        $valid = $req->validate(
            [
                "NamaPromo"=>"required",
                "DiskonPromo"=>"required",
                "tgl_end"=>"after:tgl_start",
                "MaxDiskon"=>"required",
                "gambarPromo"=>"required|mimetypes:image/png,image/jpg,image/jpeg"
            ],
            [
                "NamaPromo.required"=>"Nama Tidak Boleh Kosong",
                "DiskonPromo.required"=>"Diskon Promo Tidak Boleh Kosong",
                "tgl_end.after"=>"Tanggal Promo Selesai harus lebih besar daripada Tangal Promo Mulai",
                "MaxDiskon.required"=>"Max Diskon Tidak Boleh Kosong",
                "gambarPromo.required"=>"Harus Upload Sebuah Gambar",
                "gambarPromo.mimetype"=>"Gambar yang diupload harus berupa gambar"
            ]
        );
        $extension = $req->file("gambarPromo")->extension();
        $req->file("gambarPromo")->move(public_path("/Promo/Asset"),$req->NamaPromo."-".$req->tgl_start.".".$extension);
        $newPromo = new Promo();
        $newPromo->nama_promo = $req->NamaPromo;
        $newPromo->maximal_diskon = $req->MaxDiskon;
        $newPromo->diskon_promo = $req->DiskonPromo;
        $newPromo->tgl_start = $req->tgl_start;
        $newPromo->tgl_end = $req->tgl_end;
        $newPromo->gambar = "/Promo/Asset/".$req->NamaPromo."-".$req->tgl_start."-".$req->tgl_end.".".$extension;
        $newPromo->save();
        return redirect("/admin/Promo")->with("SuccessAddPromo","sip berhasil");
    }

    function GetDataPromo(Request $req){
        $arrData = [];
        foreach(DB::table("promo")->where("id_promo",$req->id)->get() as $item){
            $dataBaru = array(
                "id"=>$item->id_promo,
                "nama"=>$item->nama_promo,
                "max"=>$item->maximal_diskon,
                "diskon"=>$item->diskon_promo,
                "tgl_start"=>$item->tgl_start,
                "tgl_end"=>$item->tgl_end
            );
            $arrData[] = $dataBaru;
        }
        return json_encode($arrData);
    }

    function EditPromo(Request $req){
        $nama = $req->nama;
        $tglStart = $req->tglStart;
        $tglEnd = $req->tglEnd;
        $diskon = $req->diskon;
        $max = $req->max;
        try {
            Promo::where('id_promo',$req->id)->update(["nama_promo"=>$nama,"maximal_diskon"=>$max,"diskon_promo"=>$diskon,"tgl_start"=>$tglStart,"tgl_end"=>$tglEnd]);
            return "success";
        } catch (\Throwable $th) {
            return "gagal";
        }
    }

    function DeletePromo(Request $req){
        Promo::where('id_promo',$req->id)->delete();
        return "success";
    }
    //End Function Promo

    //Function Report

    function getDataReport(){
        $dataPoints = [];
        $number = cal_days_in_month(CAL_GREGORIAN,Carbon::now()->month,Carbon::now()->year);
        for ($i=1; $i <= $number; $i++) {
            $data = array(
                "y"=>0,
                "label"=>$i."/".Carbon::now()->month."/".Carbon::now()->year
            );
            $dataPoints[] = $data;
        }
        foreach (h_transaksi::all() as $key => $value) {
            if(Carbon::parse($value->tgl_jual)->format("m") == Carbon::now()->month){
                $dataPoints[Carbon::parse($value->tgl_jual)->format('d') - 1]["y"] = $dataPoints[Carbon::parse($value->tgl_jual)->format('d') - 1]["y"] + $value->grand_total;
            }
        }
        return json_encode($dataPoints);
    }

    function getDataReportBaju(){
        $dataPoints = [];
        $cek = false;
        foreach (d_jual::all() as $key => $value) {
            $tgl = h_transaksi::where('id_hjual',$value->id_hjual)->value('tgl_jual');
            if(Carbon::parse($tgl)->format("m") == Carbon::now()->month){
                $cek = true;
                for ($i=0; $i < count($dataPoints); $i++) {
                    if($dataPoints[$i]["label"]==$value->nama_barang){
                        $cek = false;
                    }
                }
                if($cek){
                    $data = array(
                        "y"=>$value->qty,
                        "label"=>$value->nama_barang
                    );
                    $dataPoints[] = $data;
                }else{
                    for ($i=0; $i < count($dataPoints); $i++) {
                        if($dataPoints[$i]["label"]==$value->nama_barang){
                            $dataPoints[$i]["y"]=$dataPoints[$i]["y"] + $value->qty;
                        }
                    }
                }
            }
        }
        return json_encode($dataPoints);
    }

    //End function Report

    //Email
    function sendEmail($to, $subject, $body) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through smtp.gmail.com:587 => port
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'cassy.onlineshopistts@gmail.com';                     // SMTP username
            $mail->Password   = 'onlineshop2020';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            // Recipients
            $mail->setFrom('cassy.onlineshopistts@gmail.com', 'Cassy');
            $mail->addAddress($to, 'User');     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            //$mail->AddEmbeddedImage($url,'logo');
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return "sent";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function invalidEmail($to, $subject, $body,$img){
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through smtp.gmail.com:587 => port
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'cassy.onlineshopistts@gmail.com';                     // SMTP username
            $mail->Password   = 'onlineshop2020';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            // Recipients
            $mail->setFrom('cassy.onlineshopistts@gmail.com', 'Cassy');
            $mail->addAddress($to, 'User');     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->AddEmbeddedImage($img,'Bukti Transfer Salah');
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return "sent";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
