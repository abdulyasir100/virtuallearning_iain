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

class DosenController extends Controller
{
    
        //Menuju beranda dosen
        public function index(){
            if(!Session::get('islogindosen')){
                return $this->redirectdosen();
            }
            else{
            $name = Session::get('name');
            $kodedosen = Session::get('kodedosen');
            //$kelass = Kelas::where('pengajar',$kodedosen)->get();  
            $kelass = DB::table('kelas')
                        ->where('pengajar',$kodedosen)
                        ->leftJoin('dosen', 'kelas.pengajar', '=', 'dosen.kode_dosen')
                        ->select('kode_kelas','nama_kelas','nama_dosen')
                        ->get();      
            return view('dosen/berandadosen',['name'=>$name ,'kodedosen'=>$kodedosen,'kelass'=>$kelass]);
            }
        }

        public function redirectdosen(){
            if(Session::get('isloginmahasiswa')){
                return redirect('mahasiswa');
            }
            else {
                return redirect('login')->with('alert','Kamu harus login dulu');
            }
        }

            //Menuju halaman profil dosen
        public function profildosen(){
            $name = Session::get('name');
            $kodedosen = Session::get('kodedosen');  
            if(!Session::get('islogindosen')){
                return $this->redirectdosen();
            }
            else{
            $dosen = Dosen::where('kode_dosen',$kodedosen)->first();
    
            return view('dosen/profildosen',['name'=>$name ,'dosen'=>$dosen]);
            }
        }

            //proses logika untuk edit dosen ke database
        public function editdosenPut(Request $request,$username){
            $kodedosen = Session::get('kodedosen'); 

        if ($request->username!=$username) {
            $request->validate([
            'username' => 'required|unique:dosen,username|max:16'
        ]);
        }
            $request->validate([
                'namadosen' => 'required|max:255',
                'username' => 'required|max:16',
                'password' => 'required|max:16',
                'fotoprofil' => 'mimes:jpeg,bmp,png,svg,webp,jpg|max:1024',
            ]);
            try{
                if($request->fotoprofil){
                    $imgName = $request->fotoprofil->getClientOriginalName().'-'.time().'.'.$request->fotoprofil->extension();
                    $request->fotoprofil->move(public_path('img/dosen'),$imgName); 
                    Dosen::find($kodedosen)->update(['foto_path' => $imgName]);
                    }
                    Dosen::find($kodedosen)->update([
                        'nama_dosen' => $request->namadosen,
                        'username' => $request->username,
                        'password' => $request->password,
                    ]);
            }catch(\Throwable $ex){
                $dosen = Dosen::where('kode_dosen',$kodedosen)->first();
                return view('dosen/profildosen',['name'=>$name ,'dosen'=>$dosen,'status'=>'Gagal upload foto']);
            }
           
        return redirect('dosen/profildosen');
        }

        public function buatkelasPost(Request $request,$kodedosen){    
            $kodedosen = Session::get('kodedosen');  
            $request->validate([
                'namakelas' => 'required|max:99'
            ]);
            do {
                $random_string = Str::random(6);
                $lastKelaskode = Kelas::latest()->select('kode_kelas')->first();
            } while ($random_string == $lastKelaskode);

            Kelas::create([
                'kode_kelas' => $random_string,
                'nama_kelas' => $request->namakelas,
                'pengajar' => $kodedosen    
            ]);

            $name = Session::get('name');
   
            return view('dosen/tambahkelas',['name'=>$name ,'kodedosen'=>$kodedosen,'kodekelas'=>$random_string,'namakelas' => $request->namakelas]);
        }

        public function indexkelas($kodekelas){
            if(!Session::get('islogindosen')){
                return $this->redirectdosen();
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
            $kodedosen = Session::get('kodedosen');           
            return view('dosen/kelasdosen',['name'=>$name ,'kodedosen'=>$kodedosen,'kelas'=>$kelas,'jumlah'=>$jumlah, 'agendas'=>$tugass]);
            }
        }
        
        public function indexMember($kodekelas){
            if(!Session::get('islogindosen')){
                return $this->redirectdosen();
            }
            else{
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();
            $members = DB::table('anggotakelas')
                            ->where('kelasKode',$kodekelas)
                            ->leftJoin('mahasiswa', 'anggotakelas.NIMmahasiswa', '=', 'mahasiswa.NIM')
                            ->get();
            $jumlah = AnggotaKelas::where('kelasKode',$kodekelas)->count();    
            $name = Session::get('name');
            $kodedosen = Session::get('kodedosen');
            $dosen = Dosen::where('kode_dosen',$kodedosen)->first();           
            return view('dosen/memberkelas',['name'=>$name ,'kodedosen'=>$kodedosen,'kelas'=>$kelas,'members'=>$members,'dosen'=>$dosen,'jumlah'=>$jumlah]);
            }
        }

            //Menuju halaman edit kelas
        public function editkelas($kodekelas){  
            if(!Session::get('islogindosen')){
                return $this->redirectdosen();
            }
            else{
            $kelas = Kelas::where('kode_kelas',$kodekelas)->first();

            $name = Session::get('name');
            $kodedosen = Session::get('kodedosen'); 
            return view('dosen/editkelas',['name'=>$name ,'kelas'=>$kelas]);
            }
        }

            //proses logika untuk edit kelas ke database
        public function editkelasPut(Request $request, $kodekelas){

            $request->validate([
                'namakelas' => 'required|max:255'
            ]);
            Kelas::find($kodekelas)->update([
                'nama_kelas' => $request->namakelas
            ]);
        return redirect('/dosen/kelas/'.$kodekelas);
        }

        //Pengumuman
        public function pengumumanPost(Request $request,$kodekelas){    
            $request->validate([
                'keterangan' => 'required|max:255'
            ]);
            
            $lastPostID = Pengumuman::latest()->value('id_pengumuman');
                $lastPostID = (int)substr($lastPostID , 4);
                $idPost = 'PEN-'.($lastPostID+1);
            Pengumuman::create([
                'id_pengumuman' => $idPost,
                'keterangan' => $request->keterangan,
                'kelas' => $kodekelas   
            ]);

            $name = Session::get('name');
            $kodedosen = Session::get('kodedosen');   
            return redirect('/dosen/kelas/'.$kodekelas); 
        }

            //proses logika untuk edit pengumuman ke database
            public function pengumumanPut(Request $request){
                $request->validate([
                    'keterangan' => 'required|max:255'
                ]);
                $idpengumuman = $request->pengumumanId;
                Pengumuman::find($idpengumuman)->update([
                    'keterangan' => $request->keterangan
                ]);
                $kodekelas = Pengumuman::find($idpengumuman)->value('kelas');
                return redirect('/dosen/kelas/'.$kodekelas); 
            }

            //Menuju halaman bagi materi
        public function bagimateri($kodekelas){  
            if(!Session::get('islogindosen')){
                return $this->redirectdosen();
            }
            else{
            $name = Session::get('name');
            $kodedosen = Session::get('kodedosen'); 
            return view('dosen/materi/bagimateri',['name'=>$name ,'kodekelas'=>$kodekelas]);
            }
        }
        public function bagimateriPost(Request $request,$kodekelas){
            $request->validate([
                'judul' => 'required|max:99',
                'penjelasan' => 'required|max:255',
                'filemateri' => 'max:8192'
            ]);
            try{
                $fileName =null;
                if($request->filemateri){
                    $fileName = $request->filemateri->getClientOriginalName().'-'.time().'.'.$request->filemateri->extension();
                    $request->file('filemateri')->storeAs('materi', $fileName);
                   }
    
                    $lastMateriID = Materi::latest()->value('id_materi');
                    $lastMateriID = (int)substr($lastMateriID , 4);
                    $idmateri = 'MAT-'.($lastMateriID+1);
                Materi::create([
                    'id_materi' => $idmateri,
                    'judul' => $request->judul,
                    'penjelasan' => $request->penjelasan,
                    'file_path' => $fileName,
                    'kelas' => $kodekelas   
                ]);
            }catch(\Throwable $ex){
                $name = Session::get('name');
            $kodedosen = Session::get('kodedosen');
                return view('dosen/materi/bagimateri',['name'=>$name,
                'kodekelas'=>$kodekelas, 
                'status'=>'File must be larger than 0 bytes and less than 8 megabytes']);
            }
            return redirect('/dosen/editmateri/'.$idmateri);
        }

        public function editmateri($idmateri){  
            if(!Session::get('islogindosen')){
                return $this->redirectdosen();
            }
            else{
            $materi = Materi::find($idmateri);

            $name = Session::get('name');
            $kodedosen = Session::get('kodedosen'); 
            return view('dosen/materi/editmateri',['name'=>$name ,'materi'=>$materi]);
            }
        }
            //proses logika untuk edit materi ke database
            public function editmateriPut(Request $request,$idmateri){

                $request->validate([
                    'judul' => 'required|max:99',
                    'penjelasan' => 'required|max:255',
                    'filemateri' => 'max:8192'
                ]);
                try{
                    if($request->filemateri){
                        $fileName = $request->filemateri->getClientOriginalName().'-'.time().'.'.$request->filemateri->extension();
                        $request->file('filemateri')->storeAs('materi', $fileName);
                        Materi::find($idmateri)->update(['file_path' => $fileName]);
                        }
                        Materi::find($idmateri)->update([
                            'judul' => $request->judul,
                            'penjelasan' => $request->penjelasan
                        ]);
                }catch(\Throwable $ex){
                    $materi = Materi::find($idmateri);
                    $name = Session::get('name');
                    $kodedosen = Session::get('kodedosen'); 
                    return view('dosen/materi/editmateri',[
                        'name'=>$name ,
                        'materi'=>$materi,
                        'status'=>'File must be larger than 0 bytes and less than 8 megabytes']);
                }
                
                return redirect('/dosen/editmateri/'.$idmateri); 
            }

                //Menuju halaman bagi tugas
            public function bagitugas($kodekelas){  
                if(!Session::get('islogindosen')){
                    return $this->redirectdosen();
                }
                else{
                $name = Session::get('name');
                $kodedosen = Session::get('kodedosen'); 
                return view('dosen/tugas/bagitugas',['name'=>$name ,'kodekelas'=>$kodekelas]);
                }
            }

            public function bagitugasPost(Request $request,$kodekelas){
                $deadline = date($request->tanggal." ".$request->jam);
                $request->validate([
                    'judul' => 'required|max:99',
                    'penjelasan' => 'required|max:255',
                    'fototugas' => 'max:8192',
                    'filetugas' => 'max:8192'
                ]);
                try{
                    $fileName =null;
                    if($request->filetugas){
                        $fileName = $request->filetugas->getClientOriginalName().'-'.time().'.'.$request->filetugas->extension();
                        $request->file('filetugas')->storeAs('tugas', $fileName); 
                    }

                    $fotoName =null;
                    if($request->fototugas){
                        $fotoName = $request->fototugas->getClientOriginalName().'-'.time().'.'.$request->fototugas->extension();
                        $request->fototugas->move(public_path('img/tugas'),$fotoName); 
                    }

                        $lastTugasID = Tugas::latest()->value('id_tugas');
                        $lastTugasID = (int)substr($lastTugasID , 4);
                        $idtugas = 'TGS-'.($lastTugasID+1);
                    Tugas::create([
                        'id_tugas' => $idtugas,
                        'judul' => $request->judul,
                        'penjelasan' => $request->penjelasan,
                        'file_path' => $fileName,
                        'foto_path' => $fotoName,
                        'deadline' => $deadline,
                        'kelas' => $kodekelas   
                    ]);
                }catch(\Throwable $ex){
                    $name = Session::get('name');
                    $kodedosen = Session::get('kodedosen'); 
                    return view('dosen/tugas/bagitugas',['name'=>$name ,'kodekelas'=>$kodekelas, 'status'=>'Gagal membuat tugas baru']);
                }
                
              return redirect('/dosen/edittugas/'.$idtugas);   
              //      return redirect('/dosen/kelas/'.$kodekelas);        
            }

            //menuju halaman edit tugas
            public function edittugas($idtugas){  
                if(!Session::get('islogindosen')){
                    return $this->redirectdosen();
                }
                else{
                $tugas = Tugas::find($idtugas);
    
                $name = Session::get('name');
                $kodedosen = Session::get('kodedosen'); 
                return view('dosen/tugas/edittugas',['name'=>$name ,'tugas'=>$tugas]);
                }
            }

            public function edittugasPut(Request $request,$idtugas){

                $deadline = date($request->tanggal." ".$request->jam);
                $request->validate([
                    'judul' => 'required|max:99',
                    'penjelasan' => 'required|max:255',
                    'foto' => 'max:8192',
                    'file' => 'max:8192'
                ]);
                try{
                    if($request->file){
                        $fileName = $request->file->getClientOriginalName().'-'.time().'.'.$request->file->extension();
                        $request->file('file')->storeAs('tugas', $fileName); 
                        Tugas::find($idtugas)->update(['file_path' => $fileName]);
                        }
                        if($request->foto){
                            $fotoName = $request->foto->getClientOriginalName().'-'.time().'.'.$request->foto->extension();
                            $request->foto->move(public_path('img/tugas'),$fotoName); 
                            Tugas::find($idtugas)->update(['foto_path' => $fotoName]);
                            }
                        Tugas::find($idtugas)->update([
                            'judul' => $request->judul,
                            'deadline' => $deadline,
                            'penjelasan' => $request->penjelasan
                        ]);
                }catch(\Throwable $e){
                    $tugas = Tugas::find($idtugas);
                    $name = Session::get('name');
                    $kodedosen = Session::get('kodedosen');
                    return view('dosen/tugas/edittugas',[
                        'name'=>$name ,
                        'tugas'=>$tugas,
                        'status'=>'Gagal mengedit tugas'
                    ]);
                }
                
                return redirect('/dosen/edittugas/'.$idtugas); 
            }

            //menuju halaman daftar tugas
            public function listtugas(){
                if(!Session::get('islogindosen')){
                    return $this->redirectdosen();
                }
                else{
                $kodedosen = Session::get('kodedosen'); 
                $tugass = DB::table('kelas')
                                    ->where('pengajar',$kodedosen)
                                    ->rightJoin('tugas', 'kelas.kode_kelas', '=', 'tugas.kelas')
                                    ->leftJoin('dosen', 'dosen.kode_dosen', '=', 'kelas.pengajar')
                                    ->select('judul','penjelasan','id_tugas as id','nama_kelas','nama_dosen','tugas.created_at', 'deadline')
                                    ->oldest('deadline')
                                    ->get(); 
                                              
               // dd($tugass);
                $name = Session::get('name');          
                return view('dosen/penilaian/listtugas',['name'=>$name ,'kodedosen'=>$kodedosen,'tugass'=>$tugass]);
                }
            }

            //menuju halaman daftar nilai
            public function listnilai($idtugas){
                if(!Session::get('islogindosen')){
                    return $this->redirectdosen();
                }
                else{
                $kodedosen = Session::get('kodedosen'); 
                $tugas = Tugas::find($idtugas);

                $jawaban = DB::table('jawabantugas')
                                ->where('idtugas',$idtugas);

                $members = DB::table('anggotakelas')
                                ->where('kelasKode',$tugas->kelas)
                                ->leftJoin('mahasiswa', 'anggotakelas.NIMmahasiswa', '=', 'mahasiswa.NIM')
                                ->leftJoinSub($jawaban, 'jawaban', function ($join) {
                                    $join->on('anggotakelas.NIMmahasiswa', '=', 'jawaban.NIMmahasiswa');})
                                ->select('NIM','nama_mahasiswa','jawaban.created_at as submit','id_jawaban','nilai')
                                ->get();

                                              
                //dd($members);
                $name = Session::get('name');          
                return view('dosen/penilaian/listnilai',['name'=>$name ,'kodedosen'=>$kodedosen,'members'=>$members,'tugas'=>$tugas]);
                }
            }

            //menuju halaman penilaian
            public function nilai($idjawaban){
                if(!Session::get('islogindosen')){
                    return $this->redirectdosen();
                }
                else{
                $jawaban = JawabanTugas::find($idjawaban);
                $tugas = Tugas::find($jawaban->idtugas);
                                    
                $name = Session::get('name');
                $kodedosen = Session::get('kodedosen');          
                return view('dosen/penilaian/nilaitugas',['name'=>$name ,'kodedosen'=>$kodedosen,'jawaban'=>$jawaban,'tugas'=>$tugas]);
                }                
            } 

        //proses logika untuk memberi nilai ke database
        public function nilaiPut(Request $request,$idjawaban){

            $request->validate([
                'nilai' => 'required|max:3'
            ]);
            JawabanTugas::find($idjawaban)->update([
                'nilai' => $request->nilai
            ]);
            $idtugas= JawabanTugas::where('id_jawaban',$idjawaban)->value('idtugas');
            return redirect('/dosen/daftarnilai/'.$idtugas); 
        }
            
}
