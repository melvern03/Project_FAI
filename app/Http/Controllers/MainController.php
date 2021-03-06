<?php

namespace App\Http\Controllers;

use App\Model\h_transaksi;
use Illuminate\Http\Request;
use App\Model\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MainController extends Controller
{
    function logout(){
        Auth::logout();
        return redirect("/login");
    }

    function verifikasi(Request $req){
        $validate = $req->validate(
        [
            "code"=>"required"
        ],
        [
            "code.required"=>"Harap mengisi Code Verifikasi"
        ]);
        if(DB::table("konfrimasi_email")->where('id_user',Auth::User()->id_user)->where('code_verify',$req->code)->count() > 0){
            Users::where('id_user',Auth::User()->id_user)->update(['status'=>"Aktif"]);
            DB::table('konfrimasi_email')->where('id_user',Auth::user()->id_user)->update(["status"=>"1"]);
            return \redirect("/")->with("success", Auth::user()->nama_user);
        }else{
            return redirect("/verifikasi")->with('errors',"Code Tidak Valid");
        }
    }

    function VerifikasiByEmail($id, $kode){
        if(DB::table("konfrimasi_email")->where('id_user',$id)->where('code_verify',$kode)->count() > 0){
            Users::where('id_user',$id)->update(['status'=>"Aktif"]);
            DB::table('konfrimasi_email')->where('id_user',$id)->update(["status"=>"1"]);
            return \redirect("/login")->with("verifySucces", "sip");
        }
        return redirect("/login")->with("verifyGagal","sorry");
    }

    function logCheck(Request $req){
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
                if(Auth::user()->jabatan == "Member"){
                    Users::where('username',Auth::user()->username)->update(['Last_Login'=>Carbon::now()]);
                    return \redirect("/")->with("success", Auth::user()->nama_user);
                }else{
                    return redirect("/");
                }
            }else if(Auth::user()->status == "Verifikasi"){
                return redirect("/verifikasi");
            }else if(Auth::user()->status == "Blacklist"){
                Auth::logout();
                return redirect("/login")->with("blacklisted","sorry");
            }
        } else {
            return \redirect()->back()->with("error", "User tidak ditemukan!");
        }
    }

    function generateCode($panjang) {
        $result     = "";
        $dictionary = array_merge(range(1,9), range("a", "z"));

        for ($i = 0; $i < $panjang; $i++) {
            $result .= $dictionary[mt_rand(0, count($dictionary) - 1)];
        }

        return $result;
    }

    function sendEmail($to, $subject, $body) {
        $mail = new PHPMailer(true);
        $tempid = DB::table('konfrimasi_email')->where('code_verify',$body)->value('id_user');
        $linkVerif = "http://localhost:8000/VerifByEmail/".$tempid."/".$body;
        $url = 'Logo/Logo(no title).png';
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
            $mail->IsHTML(true);                                  // Set email format to HTML
            $mail->AddEmbeddedImage($url,'logo');
            $mail->Subject = $subject;
            $mail->Body    = "<img src='cid:logo' style='width:150px;height:150px'><br>Hi Sahabat Cassy. Silahkan Melakukan Konfrimasi untuk mengaktifkan akun member yang sudah anda registrasi dengan cara memasukan <br>Kode : <b>$body</b><br>Atau klik link dibawah ini<br><a href='$linkVerif'>Konfirmasi disini!</a>";

            $mail->send();
            return "sent";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


    function regCheck(Request $req){
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
                "Terms"=>["required"],
                "gender"=>["required"]
            ],
            [
                "required" => ":Attribute tidak boleh kosong",
                "ConPass.in"=>"Password Tidak Sama",
                "unique"=>":Attribute sudah terdaftar",
                "NoHp.unique"=>"Nomor Telefon Sudah terdaftar",
                "NoHp.required"=>"Nomor Telefon Tidak Boleh Kosong",
                "gender.required"=>"Harus memilih salah satu gender",
                "Terms.required"=>"Harus menyetujui Syarat dan ketentuan"
            ]
        );
        $tempUser = "";
        if(Count(explode(" ",$validateData['Nama']))>1){
           $tempData = explode(" ",$validateData["Nama"]);
           $tempUser = strtoupper(substr($tempData[0],0,1).substr($tempData[1],0,1));
        }else{
            $tempUser = strtoupper(substr($validateData["Nama"],0,2));
        }
        $countData = explode('_',Users::where("id_user","like","%".$tempUser."%")->max('id_user'));
        if($countData[0] == ""){
            $countData[] = 0;
        }
        if($countData[1]+1 < 10){
            $tempUser = $tempUser."_00".($countData[1]+1);
        }else if($countData[1]+1 < 100){
            $tempUser = $tempUser."_0".($countData[1]+1);
        }else{
            $tempUser = $tempUser."_".($countData[1]+1);
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
        $newUsers->status="Verifikasi";
        $newUsers->jabatan="Member";
        $newUsers->save();
        $codeVerifikasi = $this->generateCode(20);
        DB::table('konfrimasi_email')->insert(
            [
                "id_user"=>$tempUser,
                "code_verify"=>$codeVerifikasi,
                "status"=>0
            ]);
        $this->sendEmail($req->Email,"Verifikasi",$codeVerifikasi);
        return redirect("/register")->with("Success","oksip");
    }

    function addNewFile(Request $req){
        if(glob("Bukti/".$req->idTrans.".*")){
            $file = h_transaksi::where('id_hjual',$req->idTrans)->value('gambar');
            File::delete($file);
            $extension = $req->file("newTransfer")->extension();
            $req->file("newTransfer")->move(public_path("/Bukti"),$req->idTrans.".".$extension);
            h_transaksi::where('id_hjual',$req->idTrans)->update(["status"=>"0","gambar"=>"Bukti/".$req->idTrans.".".$extension]);
        }
        return redirect("/History")->with("succes","upload");
    }
}
