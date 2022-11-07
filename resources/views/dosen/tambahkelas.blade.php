@extends('layout.dosen')
@section('title','Beranda Dosen')
@section('content')

<div class="text-center" style="margin-top:25vh">
<h3><span style="background-color: yellow">{{$namakelas}}</span>telah dibuat</h3>
<h3>Kode kelas anda: <span style="background-color: yellow">{{$kodekelas}}</span></h3>
<p>Bagikan kode ini kepada murid anda. Kode ini akan digunakan<br>sebagai invite code agar murid dapat memasuki kelas anda</p>
<div class="row">
    <div class="col m-3 border-0">
    <a href="{{ url('/dosen') }}"><button class="btn btn-primary mr-3">Kembali ke beranda</button></a>
    <a href="{{ url('/dosen/kelas/'.$kodekelas) }}"><button class="btn btn-primary">Masuk ke kelas</button></a>
    </div>
</div>
</div>

@endsection