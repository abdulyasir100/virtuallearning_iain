@extends('layout.mahasiswa')
@section('title', 'Tugas')
@section('content')
<div class="d-flex flex-row mx-5 mt-2">
<h1 class="mb-0 pb-0 align-self-end p-0">Daftar Tugas </h1>
</div>
<hr size="8" width="90%">  

@if (count($tugass) < 1)
            <div class="text-center">
            <h3>Tidak ada agenda apapun</h3>
            </div>
        @else
<div class="d-flex flex-column">
    @foreach ($tugass as $tugas)
    @php
        $skrg = time();
        $dl = strtotime($tugas->deadline);
        if ($skrg > $dl) {
          $sisa = 'Melebihi deadline';
        } else {
        $now = new Datetime(date('Y/m/d h:i:s a', time()));
        $datetime2 = new DateTime($tugas->deadline);
        $interval = $now->diff($datetime2);
        $sisa = $interval->format('%d')." Hari ".$interval->format('%h')." Jam ".$interval->format('%i')." Menit";
        }
    @endphp
    <a href="{{ url('/mahasiswa/tugas/'.$tugas->id) }}" class="text-dark mb-3">
      <div class="card">
      <div class="card-body">
        <h4 class="card-title"><span class="badge badge-danger mr-1">Tugas</span>{{$tugas->judul}}</h4>
        <p class="card-text">Tugas dibagikan oleh {{$tugas->nama_dosen}} pada {{ date('d-m-Y', strtotime($tugas->created_at)) }}</p>
        <p class="card-text">kelas {{$tugas->nama_kelas}}</p>
        <p class="card-text"><i class="fas fa-hourglass-start"></i> {{$sisa}}</p>
      </div>
    </div>
    </a>
    @endforeach
    </div>
    @endif

@endsection