@extends('layout.admin')
@section('title','Buat Akun Mahasiswa')
@section('content')

<!--untuk menunjukkan kesalahan / error -->
  @if(count($errors)>0)
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  <a href="{{ url('/admin') }}" class="m-3 text-dark"> <img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</a>

<div class="container-liquid m-3 bg-light">
<form action="{{ url('/tambahmahasiswapost') }}" method="post" enctype="multipart/form-data">
  <div class="form-group">
      <label>NIM:</label>
      <input type="number" class="form-control" name="kodemahasiswa" value="{{ old('kodemahasiswa') }}" required maxlength="24">
  </div>
  <div class="form-group">
      <label>Nama Mahasiswa:</label>
      <input type="text" class="form-control" name="namamahasiswa" value="{{ old('namamahasiswa') }}" required maxlength="99">
  </div>
  <div class="form-group">
      <label>Password:</label>
      <input type="textarea" class="form-control" name="password" value="{{ old('password') }}" required maxlength="16">
  </div>
  <div class="form-group">
      <label>Foto profil:</label>
      <input type="file" class="form-file form-control" name="fotoprofil" value="{{ old('fotoprofil') }}">
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-md btn-primary">Submit</button>
      <button type="reset" class="btn btn-md btn-danger">Cancel</button>
  </div>
  {{csrf_field()}}
</form>
</div>
@endsection