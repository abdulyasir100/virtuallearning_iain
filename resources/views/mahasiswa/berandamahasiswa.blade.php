@extends('layout.mahasiswa')
@section('title','Beranda mahasiswa')
@section('content')
@if(count($errors)>0)
    <ul class="jumbotron">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif
<button type="button" class="btn btn-primary ml-5 mt-3" data-toggle="modal" data-target="#modalMasukKelas">
  Masuk Kelas Baru
</button>
<hr size="8" width="90%">  
@if (count($kelass) < 1)
            <div class="text-center">
            <h3>Anda masih belum masuk ke kelas manapun</h3>
            <button type="button" class="btn btn-primary ml-5 mt-3" data-toggle="modal" data-target="#modalMasukKelas">
            Masuk Kelas Baru
            </button>
            </div>
        @else

        <div class="d-flex flex-column">
  @foreach ($kelass as $kelas)
  <a href="{{ url('/mahasiswa/kelas/'.$kelas->kode_kelas) }}" class="text-dark mb-3">
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

  <!-- Modal masuk kelas-->
<div class="modal fade" id="modalMasukKelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Masuk Kelas Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{ url($NIM.'/confirmmasukkelas') }}" method="post">
  <div class="form-group">
      <label>Masukkan invite code (kode kelas):</label>
      <input type="text" class="form-control" name="kelaskode" value="{{ old('kelaskode') }}" required maxlength="6">
  </div>
  {{csrf_field()}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cari Kelas</button>
      </div></form>
    </div>
  </div>
</div>
@endsection