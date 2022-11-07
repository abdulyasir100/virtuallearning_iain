<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Admin;
use App\Dosen;
use App\Mahasiswa;

class AdminController extends Controller
{
        /* Autentikasi */
    //Menuju halaman login
    public function login(){
        return view('admin/loginadmin');
    }

    //Contoller logika untuk login
    public function loginPost(Request $request){
        $username = $request->username;
        $password = $request->password;
        $data = Admin::where('username',$username)->first();
        //  if($data->count() > 0){
        try { //try
        if($data->count() > 0){ //apakah username tersebut ada atau tidak
            if($password==$data->password){
                Session::put('username',$data->username);
                Session::put('isloginadmin',TRUE);
                return redirect('admin');
            }
            else{
                return redirect('loginadmin')->with('alert','Username atau password tidak sesuai');
            }
        }
        else{
            return redirect('loginadmin')->with('alert','Username atau password tidak sesuai');
        }
        } catch (\Throwable $ex) { //catch
    return redirect('loginadmin')->with('alert','Username atau password tidak sesuai'); //catch
        } //catch
    }

    //Contoller logika untuk logout
    public function logout(){
        Session::flush();
        return redirect(url('/'));
    }


    //Menuju beranda admin
    public function index(){
        if(!Session::get('isloginadmin')){
            return redirect('loginadmin')->with('alert','Kamu harus login dulu');
        }
        else{
        $dosens = Dosen::all();
        $siswas = Mahasiswa::all();
        $name = Session::get('username');
        return view('admin/berandaadmin',['name'=>$name,'dosens'=>$dosens,'siswas'=>$siswas ]);
        }
    }

  //Menuju halaman tambah dosen
  public function tambahdosen(){
    if(!Session::get('isloginadmin')){
        return redirect('loginadmin')->with('alert','Kamu harus login dulu');
    }
    else{
    $name = Session::get('username');    
    return view('admin/tambahdosen',['name'=>$name]);
    }
  }
//proses logika untuk menambah akun dosen ke database
  public function tambahdosenPost(Request $request){
    $request->validate([
        'kodedosen' => 'required|unique:dosen,kode_dosen|max:16',
        'namadosen' => 'required|max:255',
        'username' => 'required|unique:dosen,username|max:16',
        'password' => 'required|max:16',
        'fotoprofil' => 'mimes:jpeg,bmp,png,svg,webp,jpg|max:1024',
    ]);

       $imgName =null;
       if($request->fotoprofil){
        $imgName = $request->fotoprofil->getClientOriginalName().'-'.time().'.'.$request->fotoprofil->extension();
        $request->fotoprofil->move(public_path('img/dosen'),$imgName); 
       }
        Dosen::create([
            'kode_dosen' => $request->kodedosen,
            'nama_dosen' => $request->namadosen,
            'username' => $request->username,
            'password' => $request->password,
            'foto_path' => $imgName

        ]);
    return redirect('admin');
  }
  
  //Menuju halaman edit akun dosen
    public function editdosen($kodedosen){
        if(!Session::get('isloginadmin')){
            return redirect('loginadmin')->with('alert','Kamu harus login dulu');
        }
        else{
            $name = Session::get('username');
            $dosen = Dosen::where('kode_dosen',$kodedosen)->first();
            return view('admin/profildosen',['name'=>$name, 'dosen'=>$dosen]);
          }
    }
  //proses logika untuk edit dosen ke database
    public function editdosenPut(Request $request,$kodedosen,$username){
      if ($request->kodedosen!=$kodedosen) {
        $request->validate([
          'kodedosen' => 'required|unique:dosen,kode_dosen|max:16'
      ]);
      }
      if ($request->username!=$username) {
        $request->validate([
          'username' => 'required|unique:dosen,username|max:16'
      ]);
      }
        $request->validate([
            'kodedosen' => 'required|max:16',
            'namadosen' => 'required|max:255',
            'username' => 'required|max:16',
            'password' => 'required|max:16',
            'fotoprofil' => 'mimes:jpeg,bmp,png,svg,webp,jpg|max:1024',
        ]);
        if($request->fotoprofil){
         $imgName = $request->fotoprofil->getClientOriginalName().'-'.time().'.'.$request->fotoprofil->extension();
         $request->fotoprofil->move(public_path('img/dosen'),$imgName); 
         Dosen::find($kodedosen)->update(['foto_path' => $imgName]);
        }
      Dosen::find($kodedosen)->update([
        'kode_dosen' => $request->kodedosen,
        'nama_dosen' => $request->namadosen,
        'username' => $request->username,
        'password' => $request->password,
      ]);
      return redirect('admin/profildosen/'.$request->kodedosen);
    }
//Hapus dosen 
  public function hapusdosen($kodedosen){
    Dosen::find($kodedosen)->delete();
    return redirect('admin');
  }

    //Menuju halaman tambah mahasiswa
  public function tambahmahasiswa(){
    if(!Session::get('isloginadmin')){
        return redirect('loginadmin')->with('alert','Kamu harus login dulu');
    }
    else{
    $name = Session::get('username');    
    return view('admin/tambahmahasiswa',['name'=>$name]);
    }
  }
//proses logika untuk menambah akun mahasiswa ke database
  public function tambahmahasiswaPost(Request $request){
    $request->validate([
        'kodemahasiswa' => 'required|unique:mahasiswa,NIM|max:24',
        'namamahasiswa' => 'required|max:255',
        'password' => 'required|max:16',
        'fotoprofil' => 'mimes:jpeg,bmp,png,svg,webp,jpg|max:1024',
    ]);

       $imgName =null;
       if($request->fotoprofil){
        $imgName = $request->fotoprofil->getClientOriginalName().'-'.time().'.'.$request->fotoprofil->extension();
        $request->fotoprofil->move(public_path('img/mahasiswa'),$imgName); 
       }

        Mahasiswa::create([
            'NIM' => $request->kodemahasiswa,
            'nama_mahasiswa' => $request->namamahasiswa,
            'password' => $request->password,
            'foto_path' => $imgName
        ]);
    return redirect('admin');
  }
  
  //Menuju halaman edit akun mahasiswa
    public function editmahasiswa($kodemahasiswa){
        if(!Session::get('isloginadmin')){
            return redirect('loginadmin')->with('alert','Kamu harus login dulu');
        }
        else{
            $name = Session::get('username');
            $mahasiswa = Mahasiswa::where('NIM',$kodemahasiswa)->first();
            return view('admin/profilmahasiswa',['name'=>$name, 'mahasiswa'=>$mahasiswa]);
          }
    }
  //proses logika untuk edit mahasiswa ke database
    public function editmahasiswaput(Request $request,$kodemahasiswa){
      if ($request->kodemahasiswa!=$kodemahasiswa) {
        $request->validate([
          'kodemahasiswa' => 'required|unique:mahasiswa,NIM|max:24',
      ]);
      }
        $request->validate([
            'kodemahasiswa' => 'required|max:24',
            'nama_mahasiswa' => 'required|max:255',
            'password' => 'required|max:16',
            'fotoprofil' => 'mimes:jpeg,bmp,png,svg,webp,jpg|max:1024',
        ]);
        if($request->fotoprofil){
         $imgName = $request->fotoprofil->getClientOriginalName().'-'.time().'.'.$request->fotoprofil->extension();
         $request->fotoprofil->move(public_path('img/mahasiswa'),$imgName); 
         Mahasiswa::find($kodemahasiswa)->update(['foto_path' => $imgName]);
        }
      Mahasiswa::find($kodemahasiswa)->update([
        'NIM' => $request->kodemahasiswa,
        'nama_mahasiswa' => $request->nama_mahasiswa,
        'password' => $request->password,
      ]);
      return redirect('admin/profilmahasiswa/'.$request->kodemahasiswa);
    }
//Hapus mahasiswa
  public function hapusmahasiswa($kodemahasiswa){
    Mahasiswa::find($kodemahasiswa)->delete();
    return redirect('admin');
  }


}
