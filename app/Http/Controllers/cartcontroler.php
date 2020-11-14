<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class cartcontroler extends Controller
{
    public function hapuscart($id)
    {
        $data = Session::get('cart');
        unset($data[Auth::User()->nama_user][$id]);
        Session::forget('cart');
        Session::put('cart',$data);
        return redirect('cart');
    }
    public function kirim($id,$harga)
    {
        Session::put('kirim',$id);
        Session::put('harga',$harga);
        return view("Waiting");
    }

    function sendEmail($to, $subject, $body) {
        $mail = new PHPMailer(true);
        $url = 'Logo/Logo(no title).png';
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
            $mail->AddEmbeddedImage($url,'logo');
            $mail->Subject = $subject;
            $mail->Body    = $body;
            //$mail->AltBody = "<img src='cid:logo' style='width:150px;height:150px'><br>Hi Sahabat Cassy. Silahkan Melakukan Konfrimasi untuk mengaktifkan kaun member yang sudah anda registrasi dengan cara memasukan <br>Kode : <b>$body</b><br>Atau klik link dibawah ini<br><a href='http://localhost/proyek_aplin/konfirmasi.php?kode=$body'>Konfirmasi disini!</a>";

            $mail->send();
            return "sent";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function checkout(Request $req)
    {
        $validasi = $req->validate(
            [
                'fotocek' => 'required|mimetypes:image/png,image/jpg,image/jpeg'

            ],
            [
                'fotocek.required' => 'harus upload file terlebih dahulu',
                'fotocek.mimetypes' => 'harus berupa png atau jpg'

            ]
        );

        $cekextensi = $req->file('fotocek')->extension();
        $tempId = "CK";
        $countData = DB::table('h_jual')->where("id_hjual","like","%".$tempId."%")->count()+1;
        if($countData < 10){
            $tempId = $tempId."_00".$countData;
        }else if($countData < 100){
            $tempId = $tempId."_0".$countData;
        }else{
            $tempId = $tempId."_".$countData;
        }
        $total = Session::get('harga');
        $namafile = "Bukti/".$tempId.".".$cekextensi;
        $file = $req->file('fotocek');
        $file->move("Bukti",$namafile);

        $data = Session::get('cart');

        foreach($data as $key => $item){
            if($key == Auth::User()->nama_user){
                foreach($item as $databaju){
                    $subtotal = 0;
                    $subtotal = $databaju['qty'] * DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga');
                    DB::table('d_jual')->insert(
                        [
                            'id_hjual' => $tempId,
                            'id_barang' => $databaju['id_dbaju'],
                            'qty' => $databaju['qty'],
                            'harga' => DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga'),
                            'subtotal' => $subtotal
                        ]
                    );
                    $total += $subtotal;
                }
            }
        }

        DB::table('h_jual')->insert(
            [
                'id_hjual' => $tempId,
                'tgl_jual' => Carbon::now(),
                'grand_total'=>$total,
                'id_user' => DB::table('user')->where('id_user',Auth::User()->id_user)->value('id_user'),
                'status' => 0,
                'gambar' => $namafile
            ]
        );

        $body = " <table class='table'>
        <thead class='thead-dark'>
          <tr>
            <th scope='col'>Nama Baju</th>
            <th scope='col'>qty</th>
            <th scope='col'>Harga</th>
            <th scope='col'>Total</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>";

        $email = DB::table('user')->where('id_user',Auth::User()->id_user)->value('email');
        $this->sendEmail($email,"Konfirmasi Pesanan",$body);

        unset($data[Auth::User()->nama_user]);
        Session::forget('cart');
        Session::put('cart',$data);

        return view('Track');
    }
}
