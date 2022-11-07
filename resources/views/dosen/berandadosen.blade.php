@extends('layout.dosen')
@section('title','Beranda Dosen')
@section('content')
<!--untuk menunjukkan kesalahan / error -->
@if(count($errors)>0)
<ul class="jumbotron">
  @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
  @endforeach
</ul>
@endif

<button type="button" class="btn btn-primary ml-5 mt-3" data-toggle="modal" data-target="#modalBuatKelas">
  Buat Kelas Baru
</button>
<hr size="8" width="90%">  
@if (count($kelass) < 1)
            <div class="text-center">
            <h3>Anda masih belum membuat kelas</h3>
            <button type="button" class="btn btn-primary ml-5 mt-3" data-toggle="modal" data-target="#modalBuatKelas">
            Buat Kelas Baru
            </button>
            </div>
        @else
        <div class="d-flex flex-column">
  @foreach ($kelass as $kelas)
  <a href="{{ url('/dosen/kelas/'.$kelas->kode_kelas) }}" class="text-dark mb-3">
  <div class="card">
  <div class="card-body">
    <h5 class="card-title">{{$kelas->nama_kelas}}</h5>
    <p class="card-text">Pengajar {{$kelas->nama_dosen}}</p>
  </div>
</div>
</a>
  @endforeach
  </div>
  @endif

  <!-- Modal buat kelas-->
<div class="modal fade" id="modalBuatKelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buat Kelas Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{ url($kodedosen.'/tambahkelasPost') }}" method="post">
  <div class="form-group">
      <label>Nama Kelas:</label>
      <input type="text" class="form-control" name="namakelas" value="{{ old('namakelas') }}" required maxlength="99">
  </div>
  {{csrf_field()}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Buat Kelas</button>
      </div></form>
    </div>
  </div>
</div>
@endsection