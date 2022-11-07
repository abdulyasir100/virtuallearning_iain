@extends('layout.dosen')
@section('title','Penilaian')
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
<a href="{{ url('dosen/daftarnilai/'.$tugas->id_tugas) }}" > <button class="btn btn-primary"><img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</button> </a>
  

<h2>Penilaian Tugas</h2>
<div class="container-fluid m-3 p-3 bg-light">
  <form action="{{ url('dosen/nilaiPut/'.$jawaban->id_jawaban) }}" method="post" enctype="multipart/form-data">
<div class="row">
  <div class="col-4 mr-3">
  <div class="form-group">
      @if (is_null($jawaban->file_path))
          <p>tidak ada file tugas</p>
      @else
          <p>Download : {{$jawaban->file_path}}</p>
          <a href="{{ url('download/jawaban/'.$jawaban->file_path) }}" class="btn btn-primary">Download</a>
      @endif
</div>
  </div>
  <div class="col-7">
      <div class="form-group">
          <label class="">Keterangan:</label>
          <textarea rows="3" type="textarea" class="form-control" name="keterangan" maxlength="255" disabled>{{ $jawaban->keterangan }}</textarea>
      </div>
      <div class="form-group">
        <label class="">Beri Nilai:</label>
        <input type="number" class="form-control" name="nilai" maxlength="3" value="{{ $jawaban->nilai }}">
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