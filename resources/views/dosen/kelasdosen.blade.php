@extends('layout.dosen')
@section('title',$kelas->nama_kelas)
@section('content')
<div class="d-flex flex-row mx-5 mt-2">
<h1 class="mb-0 pb-0 align-self-end p-0 mr-1">{{strtoupper($kelas->nama_kelas)}} </h1>
<a href="{{ url('/dosen/member/'.$kelas->kode_kelas) }}" class="badge badge-secondary align-self-end mb-1 mr-auto">Jumlah anggota kelas: {{$jumlah}}</a>
<a href="{{ url('/dosen/editkelas/'.$kelas->kode_kelas) }}" class="align-self-end"><button class="btn btn-primary" style="height: 40px;width: 40px"><i class="far fa-edit"></i></button></a>
</div>
<hr size="8" width="90%">  

<div class="bg-light border rounded p-3 mb-3">
<div class="d-flex flex-row">
<p class="h3 mr-auto">Bagikan agenda baru di kelas</p>
<a href="{{ url('/dosen/bagimateri/'.$kelas->kode_kelas) }}"><button type="button" class="btn btn-primary mr-2">Materi</button></a>
<a href="{{ url('/dosen/bagitugas/'.$kelas->kode_kelas) }}"><button type="button" class="btn btn-primary mr-2">Tugas</button></a>
<button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#modalpengumuman">  Pengumuman </button>
</div>
</div>
@if (count($agendas) < 1)
            <div class="text-center">
            <h3>Tidak ada agenda apapun</h3>
            </div>
        @else
<div class="d-flex flex-column">
    @foreach ($agendas as $agenda)
    @if (substr($agenda->id,0,3)=='MAT')
    <a href="{{ url('/dosen/editmateri/'.$agenda->id) }}" class="text-dark mb-3">
      <div class="card">
      <div class="card-body">
        <h4 class="card-title"><span class="badge badge-primary mr-1">Materi</span>{{$agenda->judul}}</h4>
        <p class="card-text">Materi dibagikan oleh {{$agenda->nama_dosen}} pada {{ date('d-m-Y', strtotime($agenda->created_at)) }}</p>
      </div>
    </div>
    </a>
    @elseif (substr($agenda->id,0,3)=='TGS')
    @php
        $skrg = time();
        $dl = strtotime($agenda->deadline);
        if ($skrg > $dl) {
          $sisa = 'Melebihi deadline';
        } else {
        $now = new Datetime(date('Y/m/d h:i:s a', time()));
        $datetime2 = new DateTime($agenda->deadline);
        $interval = $now->diff($datetime2);
        $sisa = $interval->format('%d')." Hari ".$interval->format('%h')." Jam ".$interval->format('%i')." Menit";
        }
    @endphp
    <a href="{{ url('/dosen/edittugas/'.$agenda->id) }}" class="text-dark mb-3">
      <div class="card">
      <div class="card-body">
        <h4 class="card-title"><span class="badge badge-danger mr-1">Tugas</span>{{$agenda->judul}}</h4>
        <p class="card-text">Tugas dibagikan oleh {{$agenda->nama_dosen}} pada {{ date('d-m-Y', strtotime($agenda->created_at)) }}</p>
        <p class="card-text"><i class="fas fa-hourglass-start"></i> {{$sisa}}</p>
      </div>
    </div>
    </a>
    @elseif (substr($agenda->id,0,3)=='PEN')
    @php
        $str = $agenda->penjelasan;
        $url_pattern = '/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';   
        $pengumuman= preg_replace($url_pattern, '<a href="$0">$0</a>', $str);
    @endphp
    <div class="card mb-3">
      <div class="card-body">
        <h4 class="clearfix">
          <span class="badge badge-primary">Pengumuman</span>
          <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modaleditpengumuman" data-umum="{{$agenda->penjelasan}}" data-id="{{$agenda->id}}"><i class="far fa-edit"></i></button>
        </h4>
        <h5 class="card-text" style="white-space: pre-wrap;"><?php echo $pengumuman ?></h5>
        <p class="card-text">Dibagikan oleh {{$agenda->nama_dosen}} pada {{ date('d-m-Y', strtotime($agenda->created_at)) }}</p>
      </div>
    </div>
    @endif
    @endforeach
    </div>
    @endif

  <!-- Modal post pengumuman-->
  <div class="modal fade" id="modalpengumuman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Apa yang anda ingin umumkan?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="{{ url('/dosen/pengumumanpost/'.$kelas->kode_kelas) }}" method="post">
    <div class="form-group">
        {{-- <label>Nama Kelas:</label> --}}
        <textarea type="textarea" class="form-control" name="keterangan" rows="4" required maxlength="255"></textarea>
    </div>
    {{csrf_field()}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Bagikan</button>
        </div></form>
      </div>
    </div>
  </div>

  <!-- Modal edit pengumuman-->
  <div class="modal fade" id="modaleditpengumuman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="{{ url('/dosen/pengumumanput') }}" method="post">
    <div class="form-group">
        <textarea type="textarea" id="isipengumuman" class="form-control" name="keterangan" rows="4" required maxlength="255"></textarea>
        <input type="hidden" id="pengumumanId" name="pengumumanId">
    </div>
    {{csrf_field()}}
    <input type="hidden" name="_method" value="PUT">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Edit</button>
        </div></form>
      </div>
    </div>
  </div>
<script>
$('#modaleditpengumuman').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var umum = button.data('umum') // Extract info from data-umum attributes
  var id = button.data('id') // Extract info from data-id attributes
  var modal = $(this)
  modal.find('#isipengumuman').val(umum)
  modal.find('#pengumumanId').val(id)
})
</script>
@endsection