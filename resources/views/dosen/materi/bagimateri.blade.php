@extends('layout.dosen')
@section('title','Bagikan Materi')
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
<a href="{{ url('/dosen/kelas/'.$kodekelas) }}" > <button class="btn btn-primary"><img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</button> </a>

<div class="container-liquid m-3 bg-light">
  @if (isset($status))
    <div class="alert alert-danger">
        {{ $status }}
    </div>
@endif
<form action="{{ url('/dosen/bagimateripost/'.$kodekelas) }}" method="post" enctype="multipart/form-data">
  <div class="form-group">
      <label>Judul:</label>
      <input type="text" class="form-control" name="judul" value="{{ old('judul') }}" required maxlength="99">
  </div>
  <div class="form-group">
      <label>Penjelasan:</label>
      <textarea rows="3" type="textarea" class="form-control" name="penjelasan" maxlength="255">{{ old('penjelasan') }}</textarea>
  </div>
  <div class="form-group">
      <label>Upload Materi:</label>
      <input type="file" class="form-file form-control" name="filemateri" value="{{ old('filemateri') }}">
  </div>
  <div class="form-group">
      <button type="submit" class="btn btn-md btn-primary">Submit</button>
      <button type="reset" class="btn btn-md btn-danger">Cancel</button>
  </div>
  {{csrf_field()}}
</form>
</div>
@endsection