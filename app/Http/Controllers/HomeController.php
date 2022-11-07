<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Dosen;
use App\Mahasiswa;
use App\Materi;
use App\Tugas;


class HomeController extends Controller
{

    public function index() {
        if(Session::get('islogindosen')){
            return redirect('dosen');
        }elseif(Session::get('isloginmahasiswa')){
            return redirect('mahasiswa');
        }
        else {
            return view('login');
        }
    }

    public function loginPost(Request $request){
        $role = $request->role;
        $username = $request->username;
        $password = $request->password;
        if ($role=='Dosen'){
            return $this->logindosenPost($password,$username);
        } elseif($role=='Mahasiswa'){
            return $this->loginmahasiswaPost($password,$username);
        } else {
            return redirect('login')->with('status','Username atau password tidak sesuai');
        }
        
    }

    public function logindosenPost($password,$username){
        $data = Dosen::where('username',$username)->first();
        try { //try
        if($data->count() > 0){ //apakah username tersebut ada atau tidak
            if($password==$data->password){
                Session::put('name',$data->nama_dosen);
                Session::put('kodedosen',$data->kode_dosen);
                Session::put('islogindosen',TRUE);
                return redirect('dosen');
            }
            else{
                return redirect('login')->with('status','Username atau password tidak sesuai');
            }
        }
        else{
            return redirect('login')->with('status','Username atau password tidak sesuai');
        }
        } catch (\Throwable $ex) { //catch
    return redirect('login')->with('status','Username atau password tidak sesuai'); //catch
        } //catch
    }

    public function loginmahasiswaPost($password,$username){
        $data = Mahasiswa::where('NIM',$username)->first();
        try { //try
        if($data->count() > 0){ //apakah username tersebut ada atau tidak
            if($password==$data->password){
                Session::put('name',$data->nama_mahasiswa);
                Session::put('NIM',$username);
                Session::put('isloginmahasiswa',TRUE);
                return redirect('mahasiswa');
            }
            else{
                return redirect('login')->with('status','Username atau password tidak sesuai');
            }
        }
        else{
            return redirect('login')->with('status','Username atau password tidak sesuai');
        }
        } catch (\Throwable $ex) { //catch
    return redirect('login')->with('status','Username atau password tidak sesuai'); //catch
        } //catch
    }
    
        //Contoller logika untuk logout
        public function logout(){
            Session::flush();
            return redirect(url('/'));
        }

        //untuk zoom foto
        public function zoomfoto($loc, $foto){
            return view('foto',['loc'=>$loc ,'foto'=>$foto]);
        }

        //untuk download file
        public function download($loc, $path){
            return Storage::disk('local')->download($loc.'/'.$path);
        }
}
