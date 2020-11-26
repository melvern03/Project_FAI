<?php

namespace App\Http\Controllers;

use App\Http\Resources\Variant;
use Illuminate\Http\Request;
use App\Model\Users;
use App\Model\h_transaksi;
use App\Model\d_jual;
use App\Model\Category;
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
                    return redirect("/");
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
                "namaModel"=>"required",
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
            if($item->qty > DB::table('d_baju')->where('id_dbaju',$item->id_barang)->value("STOK")){
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
                    $newStock = DB::table('d_baju')->where('id_dbaju',$item->id_barang)->value('STOK') - $item->qty;
                    DB::table('d_baju')->where('id_dbaju',$item->id_barang)->update(["STOK"=>$newStock]);
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
                "nama_baju"=> DB::table('d_baju')->where('id_dbaju',$value['id_barang'])->value('NAMA_BAJU'),
                "jumlah"=>$value['qty'],
                "harga"=>$value["harga"],
                "subtotal"=>$value['subtotal']
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

    //Email
    function sendEmail($to, $subject, $body) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through smtp.gmail.com:587 => port
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'cassy.onlineshopistts@gmail.com';                     // SMTP username
            $mail->Password   = 'onlineshop123';                               // SMTP password
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
            $mail->Password   = 'onlineshop123';                               // SMTP password
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
