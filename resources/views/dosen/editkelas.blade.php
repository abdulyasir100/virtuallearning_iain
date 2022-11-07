@extends('layout.dosen')
@section('title','Edit Kelas')
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
<a href="{{ url('/dosen/kelas/'.$kelas->kode_kelas) }}" > <button class="btn btn-primary"><img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</button> </a>

  <div class="container-fluid m-3 p-3 bg-light">
<form action="{{ url('dosen/editkelasPut/'.$kelas->kode_kelas) }}" method="post" enctype="multipart/form-data">
 
        <div class="form-group row">
            <label class="">Kode Kelas:</label>
            <input type="text" class="form-control" value="{{ $kelas->kode_kelas }}" required maxlength="16" disabled>
        </div>
        <div class="form-group row">
            <label class="">Nama Kelas:</label>
            <input type="text" class="form-control" name="namakelas" value="{{ $kelas->nama_kelas }}" required maxlength="99">
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