@extends('layout.mahasiswa')
@section('title','Konfirmasi')
@section('content')

<div class="text-center" style="margin-top:25vh">
<h3>Anda akan masuk ke kelas {{$kelas->nama_kelas}}</h3>
<h3>dengan pengajar {{$namadosen}}</span></h3>
<p>Apakah ini kelas yang tepat?</p>
<div class="row">
    <div class="col m-3 border-0">
    <a href="{{ url('/mahasiswa') }}"><button class="btn btn-secondary mb-3">Kembali ke beranda</button></a>
    <form action="{{ url('/mahasiswa/masukkelasPost/'.$kelas->kode_kelas) }}" method="post">{{csrf_field()}}<button class="btn btn-primary">Masuk ke kelas</button></form>
    </div>
</div>
</div>

@endsection