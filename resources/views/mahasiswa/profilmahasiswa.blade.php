@extends('layout.mahasiswa')
@section('title','Profil mahasiswa')
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
<a href="{{ url('/mahasiswa') }}" > <button class="btn btn-primary"><img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</button> </a>
  <div class="container-fluid m-3 p-3 bg-light">
<form action="{{ url('mahasiswa/editmahasiswaput/') }}" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-4 mr-3">
    <div class="form-group">
        @if (is_null($mahasiswa->foto_path))
            <img src="{{asset('img/assets/blank-profile.webp')}}" alt="foto profil mahasiswa" height="360" style="border-style: solid">
        @else
            <img src="{{asset('img/mahasiswa/'.$mahasiswa->foto_path)}}" alt="foto profil mahasiswa" height="360" style="border-style: solid">
        @endif
        <br> 
        <label>Upload foto profil:</label>
        <input type="file" class="form-file form-control" name="fotoprofil" value="">
  </div>
    </div>
    <div class="col-7">
        <div class="form-group row">
            <label class="">NIM:</label>
            <input type="text" class="form-control" value="{{ $mahasiswa->NIM }}" maxlength="16" disabled>
        </div>
        <div class="form-group row">
            <label class="">Nama Mahasiswa:</label>
            <input type="text" class="form-control" name="nama_mahasiswa " value="{{ $mahasiswa->nama_mahasiswa }}" maxlength="99" disabled>
        </div>
        <div class="form-group row">
            <label class="">Password:</label>
            <input type="password" class="form-control" name="password" value="{{ $mahasiswa->password }}" maxlength="16">
        </div>
    </div>
    
  
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-md btn-primary">Save</button>
      <button type="reset" class="btn btn-md btn-danger">Cancel</button>
  </div>
  {{csrf_field()}}
  <input type="hidden" name="_method" value="PUT">
</div>  
</form>
</div>
@endsection