@extends('layout.mahasiswa')
@section('title',$kelas->nama_kelas)
@section('content')
<div class="d-flex flex-row mx-5 mt-2">
<h1 class="mb-0 pb-0 align-self-end p-0 mr-1">{{strtoupper($kelas->nama_kelas)}}</h1>
<a href="{{ url('/mahasiswa/member/'.$kelas->kode_kelas) }}" class="badge badge-secondary align-self-end mb-1 mr-auto">Jumlah anggota kelas: {{$jumlah}}</a>
</div>
<hr size="8" width="90%">  


@if (isset($agendas))
        @if (count($agendas) < 1)
            <div class="text-center">
            <h3>Tidak ada agenda apapun</h3>
            </div>
        @else
<div class="d-flex flex-column">
    @foreach ($agendas as $agenda)
    @if (substr($agenda->id,0,3)=='MAT')
    <a href="{{ url('/mahasiswa/materi/'.$agenda->id) }}" class="text-dark mb-3">
      <div class="card">
      <div class="card-body">
        <h4 class="card-title"><span class="badge badge-primary mr-1">Materi</span>{{$agenda->judul}}</h4>
        <p class="card-text">Materi dibagikan oleh {{$agenda->nama_dosen}} pada {{ date('d-m-Y', strtotime($agenda->created_at)) }}</p>
      </div>
    </div>
    </a>
    @elseif (substr($agenda->id,0,3)=='TGS')
    @php
        $skrg = time();
        $dl = strtotime($agenda->deadline);
        if ($skrg > $dl) {
          $sisa = 'Melebihi deadline';
        } else {
        $now = new Datetime(date('Y/m/d h:i:s a', time()));
        $datetime2 = new DateTime($agenda->deadline);
        $interval = $now->diff($datetime2);
        $sisa = $interval->format('%d')." Hari ".$interval->format('%h')." Jam ".$interval->format('%i')." Menit";
        }
    @endphp
    <a href="{{ url('/mahasiswa/tugas/'.$agenda->id) }}" class="text-dark mb-3">
      <div class="card">
      <div class="card-body">
        <h4 class="card-title"><span class="badge badge-danger mr-1">Tugas</span>{{$agenda->judul}}</h4>
        <p class="card-text">Tugas dibagikan oleh {{$agenda->nama_dosen}} pada {{ date('d-m-Y', strtotime($agenda->created_at)) }}</p>
        <p class="card-text"><i class="fas fa-hourglass-start"></i> {{$sisa}}</p>
      </div>
    </div>
    </a>
    @elseif (substr($agenda->id,0,3)=='PEN')
    @php
    $str = $agenda->penjelasan;
    $url_pattern = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';   
    $pengumuman= preg_replace($url_pattern, '<a href="$0">$0</a>', $str);
    @endphp
    <div class="card mb-3">
      <div class="card-body">
        <h4 class="clearfix"><span class="badge badge-primary">Pengumuman</span></h4>
        <h5 class="card-text" style="white-space: pre-wrap;"><?php echo $pengumuman ?></h5>
        <p class="card-text">Dibagikan oleh {{$agenda->nama_dosen}} pada {{ date('d-m-Y', strtotime($agenda->created_at)) }}</p>
      </div>
    </div>
    @endif
    @endforeach
    </div>
    @endif
    @endif

@endsection