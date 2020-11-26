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

    public function AddItem(Request $req){
        $final = 0;
        $cart = Session::get('cart');
        $cart[Auth::user()->nama_user][$req->id]['qty'] += 1;
        Session::put('cart', $cart);
        $final = $cart[Auth::user()->nama_user][$req->id]['qty'];
        return $final;
    }

    public function MinusItem(Request $req){
        $final = 0;
        $cart = Session::get('cart');
        $cart[Auth::user()->nama_user][$req->id]['qty'] -= 1;
        Session::put('cart', $cart);
        $final = $cart[Auth::user()->nama_user][$req->id]['qty'];
        return $final;
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
        $temp = explode("_",DB::table('h_jual')->where("id_hjual","like","%".$tempId."%")->max('id_hjual'));
        $countData = $temp[1]+1;
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


        $body = "
                <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Document</title>
        </head>
        <body>
        <div class='container' style:'background-color:whitesmoke;color: black;border-radius: 5px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        text-align: center;display:block;'>
        <br>
        <img src='cid:logo' style='width:150px;height:150px'>
        <h1 style='font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;' align='center'>RECIPT SUMMARY</h1>
        <div style='background-color:oldlace;color: black;border-radius: 15px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        text-align: center;width: 1000px;height:fit-content;margin-left: 250px;margin-right: 200px;'>
        <br>
        <h3 style='font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;'>".Auth::User()->nama_user."</h3>
        <br>
        Terima kasih telah melakukan pembelian <br>
        di Cassy int.Co...
        <br>
        <h1 style='font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;'>INVOICE :".$tempId."</h1>
        (Tolong simpan nomor recipt ini untuk anda sendiri)
        <br>
        <h4 style='font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;color: lightgray;transform: translateX(-400px);'>Your Order Information</h4>
        <hr>
        <br>
        <h3 style='font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;'>Order Id : ".$tempId."</h3>
        <h3 style='font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;'>Order Date :". Carbon::now()." </h3>
        <h3 style='font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;'>Bill To : " .DB::table('user')->where('nama_user',Auth::User()->nama_user)->value('email')."</h3>
        <h3 style='font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;'><u>Detail Order</u></h3>
        <style>
            table {
              font-family: arial, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }

            td, th {
              border: 1px solid #dddddd;
              text-align: left;
              padding: 8px;
            }

            tr:nth-child(even) {
              background-color: #dddddd;
            }
        </style>
        <table style='font-family: arial, sans-serif;border-collapse: collapse;  width: 100%;border: 1px solid black'>
          <tr style:'background-color: #dddddd;'>
            <th style:'border: 1px solid #dddddd;text-align: left; padding: 8px;'>Nama Baju</th>
            <th style:'border: 1px solid #dddddd;text-align: left; padding: 8px;'>Jumlah</th>
            <th style:'border: 1px solid #dddddd;text-align: left; padding: 8px;'>Harga</th>
            <th style:'border: 1px solid #dddddd;text-align: left; padding: 8px;'>Sub Total</th>
          </tr>
           ";
        $subtotal = 0;
        foreach ($data as $key => $item)
        {
            if($key==Auth::User()->nama_user){
                foreach ($item as $databaju) {
                    $body = $body.
                    "<tr style='border:1px solid black'>"."<td>".DB::table('d_baju')->where('id_dbaju',$databaju['id_dbaju'])->value('NAMA_BAJU')."</td>".
                    "<td>".$databaju['qty']."</td>"."<td>".DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga')."</td>".
                    "<td>".$databaju['qty'] * DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga')."</td> </tr>";
                    $subtotal += ($databaju['qty'] * DB::table('h_baju')->where('ID_HBAJU',$databaju['id_hbaju'])->value('harga'));
                }
            }
        }
        if (Session::get('kirim')=="GRAB")
        {
            $totalsemua = $subtotal+5000;
            $kurir = 5000;
        }
        else if (Session::get('kirim')=="JNE")
        {
            $totalsemua = $subtotal+10000;
            $kurir = 10000;
        }
        else{
            $totalsemua = $subtotal+15000;
            $kurir = 15000;
        }
        $body = $body."
        </table>
        <br>
        <h4>Sub Total :Rp. ".number_format($subtotal,0,',','.')."</h4>
        <h4>biaya kirim :Rp. ".number_format($kurir,0,',','.')."</h4>
        <h2>Grand Total :Rp. ".number_format($totalsemua,0,',','.')."</h2>
        <hr>
        <br>
        <h6>Semua pembelian yang sudah dibayarkan tidak dapat ditukarkan kembali <br>
        maka sebaiknya cek dulu size yang akan dipilih dengan baik.</h6>
        <br>
        <hr>
        <br>
        <h4>Cassy int Co..
            <br> jl.Ketintang no 78,Kecamatan Sidotopo, Surabaya ,
            <br>  Indonesia ,Jawa Timur.
        </h4>
        <br><br>
        </div>
        <br>
        <h4>Need help?
            <br>email : cassy.onlineshopistts@gmail.com <br>
            No. WA : 08982960838
        </h4>
        <br>
        <h5 style='color: lightgray;'>© 2011-2020 Cassy int Co. <br>
        in the Indonesia and elsewhere. Other brands and product names are the trademarks <br>
        of their respective owners.</h5>
        <br>
        <br>
        </div>
        </body>
        </html>";

        $email = DB::table('user')->where('id_user',Auth::User()->id_user)->value('email');
        $this->sendEmail($email,"Konfirmasi Pesanan",$body);

        unset($data[Auth::User()->nama_user]);
        Session::forget('cart');
        Session::put('cart',$data);

        return view('Track');
    }
}
