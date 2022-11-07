@extends('layout.dosen')
@section('title','Tugas')
@section('content')

<!--untuk menunjukkan kesalahan / error -->
@if(count($errors)>0)
    <ul class="jumbotron">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif
  <div class="mb-2"></div>
<a href="{{ url('dosen/kelas/'.$tugas->kelas) }}" > <button class="btn btn-primary"><img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</button> </a>
  <div class="container-fluid m-3 p-3 bg-light">
    @if (isset($status))
    <div class="alert alert-danger">
        {{ $status }}
    </div>
@endif
<form action="{{ url('dosen/edittugasPut/'.$tugas->id_tugas) }}" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-4 mr-3">
          <div class="form-group">
        @if (is_null($tugas->foto_path))
            <p>Tidak ada foto penujang tugas</p>
        @else
        <a href="{{ url('foto/tugas/'.$tugas->foto_path) }}" target="_blank" rel="noopener noreferrer">
          <img src="{{asset('img/tugas/'.$tugas->foto_path)}}" alt="foto tugas" height="200" style="border-style: solid">
        </a>
        @endif
        <br> 
        <label>Update foto:</label>
        <input type="file" class="form-file form-control" name="foto" value="">
    </div>
    <div class="form-group">
        @if (is_null($tugas->file_path))
            <p>tidak ada file penunjang tugas</p>
        @else
            <p>Download : {{$tugas->file_path}}</p>
            <a href="{{ url('download/tugas/'.$tugas->file_path) }}" class="btn btn-primary">Download</a>
        @endif
        <br> 
        <label>Update File Materi:</label>
        <input type="file" class="form-file form-control" name="file" value="">
  </div>
    </div>
    <div class="col-7">
        <div class="form-group">
            <label class="">Judul:</label>
            <input type="text" class="form-control" name="judul" value="{{ $tugas->judul }}" required maxlength="99" >
        </div>
        <div class="form-group">
            <label class="">Penjelasan:</label>
            <textarea rows="3" type="textarea" class="form-control" name="penjelasan" maxlength="255">{{ $tugas->penjelasan }}</textarea>
        </div>
        
      <div class="form-group">
        <label>Tanggal deadline:</label>
        <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d', strtotime($tugas->deadline)) }}">
        <label>Jam deadline:</label>
        <input type="time" class="form-control" name="jam" value="{{ date('H:i', strtotime($tugas->deadline)) }}">
    </div>
    <div class="float-right form-group">
      <button type="submit" class="ml-auto btn btn-md btn-primary">Save</button>
      <button type="reset" class="btn btn-md btn-danger">Cancel</button>
  </div>

    </div>
    
  
  </div>

  {{csrf_field()}}
  <input type="hidden" name="_method" value="PUT">
</div>  
</form>
</div>
@endsection