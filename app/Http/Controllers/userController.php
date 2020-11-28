<?php

namespace App\Http\Controllers;

use App\Http\Resources\resDbaju;
use App\Http\Resources\resourcesSort;
use App\Model\d_jual;
use App\Model\Feedback;
use App\Model\h_transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Model\Review;
use Carbon\Carbon;

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
            return 'sukses';
        }else{
            return 'error';
        }

    }

    public function showProfile(){
        if (Auth::check()){
            $profile['user'] = DB::table('user')->where('id_user',Auth::user()->id_user)->get();
            return view('profile')->with($profile);
        }else{
            return redirect('/');
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
    public function shopCategory(Request $req, $kategori){
        if($req->btnKategori){
            $idHbaju = array();
            $barang['baju'] = DB::table('d_baju')->where('ID_KATEGORI',$req->btnKategori)->get();
            $barang['kategori'] = $kategori;
            foreach ($barang['baju'] as $key => $value) {
                array_push($idHbaju, $value->ID_HBAJU);
            }
            $barang["Hbaju"] = DB::table('h_baju')->whereIn('ID_HBAJU',$idHbaju)->get();
            return view('shop')->with($barang);
        }else{
            return redirect("/shop");
        }
    }

    public function detail(Request $req, $namaHbaju){
        $check = DB::table('h_baju')->where('NAMA_BAJU',$namaHbaju)->count();
        $idHbaju = "";
        if(isset($req->btnDetail) || $check == 1){
            $idHbaju = $req->btnDetail;
            if(isset($req->btnDetail)){
                $idHbaju = $req->btnDetail;
            }else{
                $idHbaju = DB::table('h_baju')->where('NAMA_BAJU',$namaHbaju)->pluck('ID_HBAJU');
            }
            $Dbaju = DB::table('d_baju')->where('ID_HBAJU',$idHbaju)->first();
            return redirect('/detail/'.$namaHbaju.'/'.$Dbaju->id_dbaju);
        }else{
            return redirect('shop');
        }
    }
    public function detailItem(Request $req, $namaHbaju, $idDbaju){
        $check = DB::table('h_baju')->where('NAMA_BAJU',$namaHbaju)->count();
        $checkDbaju = DB::table('d_baju')->where('id_dbaju',$idDbaju)->count();
        if($checkDbaju == 0){
            $idDbaju = $req->selectVarition;
            return redirect('/detail/'.$namaHbaju.'/'.$idDbaju);
        }
        if($check == 1 && $checkDbaju == 1){
            $idHbaju = DB::table('h_baju')->where('NAMA_BAJU',$namaHbaju)->pluck('ID_HBAJU');
            $barang['Dbaju'] = DB::table('d_baju')->where('id_dbaju',$idDbaju)->get();
            $barang['allDbaju'] = DB::table('d_baju')->where('ID_HBAJU',$idHbaju)->get();
            $barang['Hbaju'] = DB::table('h_baju')->where('ID_HBAJU', $idHbaju)->get();
            $barang['kategori'] = DB::table('kategori')->where('ID_KATEGORI',$barang['Dbaju'][0]->ID_KATEGORI)->get();
            return view('detail')->with($barang);
        }else{
            return redirect('shop');
        }
    }

    public function profileChange(Request $req, $data){
        if($data == 'nama_user'){
            DB::table('user')
            ->where('id_user',Auth::user()->id_user)
            ->update(['nama_user'=>$req->namaUser]);
            return redirect('/profile')->with('success','Nama berhasil di ubah');
        }else if($data == 'alamat'){
            DB::table('user')
            ->where('id_user',Auth::user()->id_user)
            ->update(['alamat'=>$req->alamatUser]);
            return redirect('/profile')->with('success','Alamat berhasil di ubah');
        }else if($data == 'no_telp'){
            DB::table('user')
            ->where('id_user',Auth::user()->id_user)
            ->update(['no_telp'=>$req->telpUser]);
            return redirect('/profile')->with('success','Nomor telefon berhasil di ubah');
        }else if($data == 'password'){
            $password = DB::table('user')->where('id_user',Auth::user()->id_user)->get();
            if(password_verify($req->oldPass, $password[0]->password)){
                if($req->newPass == $req->cPass){
                    $pass = password_hash($req->newPass, \PASSWORD_DEFAULT);
                    DB::table('user')
                    ->where('id_user',Auth::user()->id_user)
                    ->update(['password'=>$pass]);
                    Auth::logout();
                    return redirect("/login")->with('success','Password berhasil di ubah');
                }else{
                    return redirect('/profile')->with('err','Konfirmasi password berbeda');
                }
            }else{
                return redirect('/profile')->with('err','Password lama berbeda dengan data kami');
            }
        }else{
            return redirect('/profile')->with('err','Terjadi kesalahan dalam perubahan data');
        }
    }

    public function shopCategorySort(Request $req, $kategori){
        $idKategori = DB::table('kategori')->where('NAMA_KATEGORI',$kategori)->pluck('ID_KATEGORI');
        $idHbaju = array();
        $barang['baju'] = DB::table('d_baju')->where('ID_KATEGORI',$idKategori[0])->get();
        $barang['kategori'] = $kategori;

        if($req->btnSort == 'tertinggi'){
            foreach ($barang['baju'] as $key => $value) {
                array_push($idHbaju, $value->ID_HBAJU);
            }
            $barang["Hbaju"] = DB::table('h_baju')
                                ->whereIn('ID_HBAJU',$idHbaju)
                                ->orderBy('harga', 'desc')
                                ->get();
                                return view('shop')->with($barang);
        }else if($req->btnSort == 'terendah'){
            foreach ($barang['baju'] as $key => $value) {
                array_push($idHbaju, $value->ID_HBAJU);
            }
            $barang["Hbaju"] = DB::table('h_baju')
                                ->whereIn('ID_HBAJU',$idHbaju)
                                ->orderBy('harga', 'asc')
                                ->get();
                                return view('shop')->with($barang);
        }else if($req->btnSort == 'terbaru'){
            foreach ($barang['baju'] as $key => $value) {
                array_push($idHbaju, $value->ID_HBAJU);
            }
            $barang["Hbaju"] = DB::table('h_baju')
                                ->whereIn('ID_HBAJU',$idHbaju)
                                ->orderBy('time_added', 'desc')
                                ->get();
                                return view('shop')->with($barang);
        }else if($req->btnSort == 'terlama'){
            foreach ($barang['baju'] as $key => $value) {
                array_push($idHbaju, $value->ID_HBAJU);
            }
            $barang["Hbaju"] = DB::table('h_baju')
                                ->whereIn('ID_HBAJU',$idHbaju)
                                ->orderBy('time_added', 'asc')
                                ->get();
                                return view('shop')->with($barang);
        }else{
            return redirect("/shop");
        }
    }

    public function finishOrder(Request $req){

        h_transaksi::where("id_hjual",$req->id)->update(["status"=>"2"]);
        foreach (d_jual::where('id_hjual',$req->id)->get() as $item) {
            $newReview = new Review();
            $newReview->id_user = Auth::user()->id_user;
            $newReview->id_order = $req->id;
            $newReview->id_baju = $item->id_barang;
            $newReview->status_pesan = "0";
            $newReview->id_hbaju = DB::table('d_baju')->where('id_dbaju',$item->id_barang)->value('ID_HBAJU');
            $newReview->save();
        }

        return "success";
    }

    public function getDataReview(Request $req){
        $data = Review::where('id_order',$req->idReview)->where('status_pesan','0')->get();
        return redirect("/Review")->with("data",$data);
    }

    public function addReview(Request $req){
        for ($i=0; $i < count($req->reviewOrang); $i++) {
            Review::where('id_order',$req->idOrder[$i])->where("id_baju",$req->idBaju[$i])->where('id_user',Auth::user()->id_user)->update(["pesan"=>$req->reviewOrang[$i], "rating"=>$req->ratingStar[$i], "status_pesan"=>"1", "tanggal_pengaduan"=>Carbon::now()]);
        }
        return redirect("/History")->with('reviewDone',"terimakasih");
    }

    public function getDataDetail(Request $req){
        $data = d_jual::where('id_hjual',$req->detailTrans)->get();
        return redirect("/DetailTransaksi")->with("dataDetail",$data);
    }

    public function AddFeedback(Request $req){
        $newFeedback = new Feedback();
        $newFeedback->message = $req->msg;
        $newFeedback->id_user = Auth::user()->id_user;
        $newFeedback->tgl_feedback = Carbon::now();
        $newFeedback->save();
        return redirect("/Feedback")->with("Success","Thank you");
    }

    public function AddFeedbackFooter(Request $req){
        $newFeedback = new Feedback();
        $newFeedback->message = $req->msg;
        if(Auth::check()){
            $newFeedback->id_user = Auth::user()->id_user;
        }else{
            $newFeedback->id_user = "Guest";
        }
        $newFeedback->tgl_feedback = Carbon::now();
        $newFeedback->save();
        return "Feedback";
    }

    public function cekSession(){
        dd(Session::all());
    }
}
