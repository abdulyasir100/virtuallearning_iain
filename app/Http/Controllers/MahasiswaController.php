<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Dosen;
use App\Mahasiswa;
use App\Kelas;
use App\AnggotaKelas;
use App\Materi;
use App\Tugas; 
use App\JawabanTugas;
use App\Pengumuman;

class MahasiswaController extends Controller
{
        //Menuju beranda mahasiswa
        public function index(){
            if(!Session::get('isloginmahasiswa')){
                return $this->redirectsiswa();
            }
            else{
            $name = Session::get('name');
            $NIM = Session::get('NIM');
            $kelass = DB::table('anggotakelas')
                            ->where('NIMmahasiswa',$NIM)
                            ->leftJoin('kelas', 'anggotakelas.kelaskode', '=', 'kelas.kode_kelas')
                            ->leftJoin('dosen', 'kelas.pengajar', '=', 'dosen.kode_dosen')
                            ->select('kode_kelas','nama_kelas','nama_dosen')
                            ->get();
            return view('mahasiswa/berandamahasiswa',['name'=>$name ,'NIM'=>$NIM,'kelass'=>$kelass]);
            }
        }

        public function redirectsiswa(){
            if(Session::get('islogindosen')){
                return redirect('dosen');
            }
            else {
                return redirect('login')->with('alert','Kamu harus login dulu');
            }
        }

        //Menuju halaman profil mahasiswa
        public function profilmahasiswa(){
            $name = Session::get('name');
            $NIM = Session::get('NIM');  
            if(!Session::get('isloginmahasiswa')){
                return $this->redirectsiswa();
            }
            else{
            $mahasiswa = Mahasiswa::where('NIM',$NIM)->first();
    
            return view('mahasiswa/profilmahasiswa',['name'=>$name ,'mahasiswa'=>$mahasiswa]);
            }
        }

            //proses logika untuk edit mahasiswa ke database
        public function editmahasiswaput(Request $request){
            $NIM = Session::get('NIM'); 

            $request->validate([
                'password' => 'required|max:16',
                'fotoprofil' => 'mimes:jpeg,bmp,png,svg,webp,jpg|max:1024',
            ]);
            if($request->fotoprofil){
            $imgName = $request->fotoprofil->getClientOriginalName().'-'.time().'.'.$request->fotoprofil->extension();
            $request->fotoprofil->move(public_path('img/mahasiswa'),$imgName); 
            Mahasiswa::find($NIM)->update(['foto_path' => $imgName]);
            }
            Mahasiswa::find($NIM)->update([
                'password' => $request->password,
            ]);
        return redirect('mahasiswa/profilmahasiswa');
        }

        public function confirmkelas(Request $request,$NIM){
            $request->validate([
                'kelaskode' => 'required|exists:kelas,kode_kelas|max:6'
            ]);
            $joined = AnggotaKelas::where('NIMmahasiswa',$NIM)->where('kelasKode',$request->kelaskode)->count();
            if ($joined>0) {
                return $this->indexkelas($request->kelaskode);
            }else {
             
            $name = Session::get('name');
            $NIM = Session::get('NIM');
            $kelas = Kelas::where('kode_kelas',$request->kelaskode)->first();
            $dosen = Dosen::where('kode_dosen',$kelas->pengajar)->value('nama_dosen');
            return view('mahasiswa/confirmkelas',['name'=>$name ,'NIM'=>$NIM,'kelas'=>$kelas,'namadosen'=>$dosen]);
            }  
        }

        public function masukkelasPost($kodekelas){
            $NIM = Session::get('NIM');
            AnggotaKelas::create([
                'kelaskode' => $kodekelas,
                'NIMmahasiswa' => $NIM
            ]);
            
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();
            $jumlah = AnggotaKelas::where('kelasKode',$kodekelas)->count()+1;

            $name = Session::get('name');
            $NIM = Session::get('NIM');            
            return view('mahasiswa/kelasmahasiswa',['name'=>$name ,'NIM'=>$NIM,'kelas'=>$kelas,'jumlah'=>$jumlah]);
        }

        public function indexkelas($kodekelas){
            if(!Session::get('isloginmahasiswa')){
                return $this->redirectsiswa();
            }
            else{
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();
            $jumlah = AnggotaKelas::where('kelasKode',$kodekelas)->count()+1;
            $posts = Pengumuman::where('kelas',$kodekelas)
                                ->latest('pengumuman.created_at')
                                ->leftJoin('kelas', 'kelas.kode_kelas', '=', 'pengumuman.kelas')
                                ->leftJoin('dosen', 'dosen.kode_dosen', '=', 'kelas.pengajar')
                                ->select(DB::raw('null as judul'),'keterangan','id_pengumuman','nama_kelas','nama_dosen','pengumuman.created_at', DB::raw('null as deadine'));    

            $materis = Materi::where('kelas',$kodekelas)
                                ->latest('materi.created_at')
                                ->leftJoin('kelas', 'kelas.kode_kelas', '=', 'materi.kelas')
                                ->leftJoin('dosen', 'dosen.kode_dosen', '=', 'kelas.pengajar')
                                ->select('judul','penjelasan','id_materi','nama_kelas','nama_dosen','materi.created_at', DB::raw('null as deadine'))
                                ->union($posts);

            $tugass = Tugas::where('kelas',$kodekelas)
                                ->leftJoin('kelas', 'kelas.kode_kelas', '=', 'tugas.kelas')
                                ->leftJoin('dosen', 'dosen.kode_dosen', '=', 'kelas.pengajar')
                                ->select('judul','penjelasan','id_tugas as id','nama_kelas','nama_dosen','tugas.created_at', 'deadline')
                                ->union($materis)
                                ->latest('created_at')
                                ->get(); 
                                          

            $name = Session::get('name');
            $NIM = Session::get('NIM');            
            return view('mahasiswa/kelasmahasiswa',['name'=>$name ,'NIM'=>$NIM,'kelas'=>$kelas,'jumlah'=>$jumlah, 'agendas'=>$tugass]);
            }
        }

        public function indexMember($kodekelas){
            if(!Session::get('isloginmahasiswa')){
                return $this->redirectsiswa();
            }
            else{
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();
            $members = DB::table('anggotakelas')
                            ->where('kelasKode',$kodekelas)
                            ->leftJoin('mahasiswa', 'anggotakelas.NIMmahasiswa', '=', 'mahasiswa.NIM')
                            ->get();
            $jumlah = AnggotaKelas::where('kelasKode',$kodekelas)->count();    
            $name = Session::get('name');
            $NIM = Session::get('NIM');
            $dosen = Dosen::where('kode_dosen',$kelas->pengajar)->first();           
            return view('mahasiswa/memberkelas',['name'=>$name ,'NIM'=>$NIM,'kelas'=>$kelas,'members'=>$members,'dosen'=>$dosen,'jumlah'=>$jumlah]);
            }
        }

        //menuju halaman detail materi
        public function detailmateri($idmateri){  
            if(!Session::get('isloginmahasiswa')){
                return $this->redirectsiswa();
            }
            else{
            $materi = Materi::find($idmateri);

            $name = Session::get('name');
            $NIM = Session::get('NIM'); 
            return view('mahasiswa/detailmateri',['name'=>$name ,'materi'=>$materi]);
            }
        }

            //menuju halaman detail tugas
        public function detailtugas($idtugas){  
            $NIM = Session::get('NIM'); 
            if(!Session::get('isloginmahasiswa')){
                return $this->redirectsiswa();
            }
            else{
            $tugas = Tugas::find($idtugas);
            $jawaban = JawabanTugas::where('idtugas', $idtugas)
                                    ->where('NIMmahasiswa', $NIM)
                                    ->first();
            $name = Session::get('name'); 
                if (empty($jawaban)) {
                    return view('mahasiswa/submittugas',['name'=>$name ,'tugas'=>$tugas]);
                }else {
                    return view('mahasiswa/edittugas',['name'=>$name ,'tugas'=>$tugas,'jawaban'=>$jawaban]);
                }
            }
        }

        //logka submit jawaban
        public function submitjawabanPost(Request $request,$idtugas){
            $NIM = Session::get('NIM');
            $request->validate([
                'keterangan' => 'required|max:255',
                'filetugas' => 'max:8192'
            ]);
            do {
                $random_string = Str::random(6);
                $lastid = JawabanTugas::latest()->select('id_jawaban')->first();
            } while ($random_string == $lastid);
            try{
                $fileName =null;
                if($request->filetugas){
                 $fileName = $request->filetugas->getClientOriginalName().'-'.time().'.'.$request->filetugas->extension();
                 $request->file('filetugas')->storeAs('jawaban', $fileName);
                }

             JawabanTugas::create([
                 'id_jawaban' => $random_string,
                 'keterangan' => $request->keterangan,
                 'file_path' => $fileName,
                 'idtugas' => $idtugas,
                 'NIMmahasiswa' => $NIM
             ]);
            }catch(\Throwable $e){
                $tugas = Tugas::find($idtugas);
                $jawaban = JawabanTugas::where('idtugas', $idtugas)
                                    ->where('NIMmahasiswa', $NIM)
                                    ->first();
                $name = Session::get('name');
                return view('mahasiswa/submittugas',[
                    'name'=>$name ,
                    'tugas'=>$tugas,
                    'status'=>'Gagal upload tugas'
                ]);
            }

            $name = Session::get('name');
            return redirect('/mahasiswa/tugas/'.$idtugas);
        }

        //proses logika untuk edit jawaban ke database
        public function editjawabanPut(Request $request,$idjawaban){

            $request->validate([
                'keterangan' => 'required|max:255',
                'file' => 'max:8192'
            ]);
            $idtugas= JawabanTugas::where('id_jawaban', $idjawaban)->value('idtugas');
            try{
                if($request->file){
                    $fileName = $request->file->getClientOriginalName().'-'.time().'.'.$request->file->extension();
                    $request->file('file')->storeAs('jawaban', $fileName);
                    JawabanTugas::find($idjawaban)->update(['file_path' => $fileName]);
                    }
                    JawabanTugas::find($idjawaban)->update([
                        'keterangan' => $request->keterangan
                    ]);
            }catch(\Throwable $ex){
                $NIM = Session::get('NIM');
                $tugas = Tugas::find($idtugas);
                $jawaban = JawabanTugas::where('idtugas', $idtugas)
                                        ->where('NIMmahasiswa', $NIM)
                                        ->first();
                $name = Session::get('name');
                return view('mahasiswa/edittugas',[
                    'name'=>$name,
                    'tugas'=>$tugas,
                    'jawaban'=>$jawaban,
                    'status'=>'Gagal upload tugas'
                ]);

                }
                return redirect('/mahasiswa/tugas/'.$idtugas);
        }
            //menuju halaman daftar tugas
            public function listtugas(){
                if(!Session::get('isloginmahasiswa')){
                    return $this->redirectsiswa();
                }
                else{
                $NIM = Session::get('NIM'); 
                $tugass = DB::table('anggotaKelas')
                                    ->where('NIMmahasiswa',$NIM)
                                    ->rightJoin('tugas', 'anggotaKelas.kelaskode', '=', 'tugas.kelas')
                                    ->leftJoin('kelas', 'anggotaKelas.kelaskode', '=', 'kelas.kode_kelas')
                                    ->leftJoin('dosen', 'dosen.kode_dosen', '=', 'kelas.pengajar')
                                    ->select('judul','penjelasan','id_tugas as id','nama_kelas','nama_dosen','tugas.created_at', 'deadline')
                                    ->oldest('deadline')
                                    ->get(); 
                       //dd($tugass);                       
                $name = Session::get('name');          
                return view('mahasiswa/listtugas',['name'=>$name ,'NIM'=>$NIM,'tugass'=>$tugass]);
                }
            }

}
