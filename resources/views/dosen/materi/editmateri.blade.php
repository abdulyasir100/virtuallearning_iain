@extends('layout.dosen')
@section('title','Materi')
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
<a href="{{ url('dosen/kelas/'.$materi->kelas) }}" > <button class="btn btn-primary"><img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</button> </a>
  <div class="container-fluid m-3 p-3 bg-light">
    @if (isset($status))
    <div class="alert alert-danger">
        {{ $status }}
    </div>
@endif
<form action="{{ url('dosen/editmateriPut/'.$materi->id_materi) }}" method="post" enctype="multipart/form-data">
<div class="row">
    <div class="col-4 mr-3">
    <div class="form-group">
        @if (is_null($materi->file_path))
            <p>Belum ada file materi</p>
        @else
            <p>Download : {{$materi->file_path}}</p>
            <a href="{{ url('download/materi/'.$materi->file_path) }}" class="btn btn-primary">Download</a>
        @endif
        <br> 
        <label>Update File Materi:</label>
        <input type="file" class="form-file form-control" name="filemateri" value="">
  </div>
    </div>
    <div class="col-7">
        <div class="form-group row">
            <label class="">Judul:</label>
            <input type="text" class="form-control" name="judul" value="{{ $materi->judul }}" required maxlength="99" >
        </div>
        <div class="form-group row">
            <label class="">Penjelasan:</label>
            <textarea rows="3" type="textarea" class="form-control" name="penjelasan" maxlength="255">{{ $materi->penjelasan }}</textarea>
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