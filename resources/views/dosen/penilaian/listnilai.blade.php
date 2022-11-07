@extends('layout.dosen')
@section('title','Daftar penilaian')
@section('content')

<div class="mb-2"></div>
<a href="{{ url('dosen/listtugas') }}" > <button class="btn btn-primary"><img src="{{asset('img/assets/button/back.png')}}" alt="back" title="back" height="36"> Kembali</button> </a>
<div class="m-2 gap-2">
<h2>Tabel Nilai</h2>
  <table class="table table-condensed table-hover table-bordered mt-2">
    <thead>
      <tr>
        <th>No.</th>
        <th>NIM</th>
        <th>Nama Mahasiswa</th>
        <th>Nilai</th>
        <th>Tanggal Submit</th>
        <th>Beri nilai</th>
      </tr>
    </thead>
    <tbody>
      @php
        $i=1;
      @endphp
  @foreach ($members as $member)
    <tr>
      <td>{{$i}}</td>
      <td>{{ $member->NIM }}</td>
      <td>{{ $member->nama_mahasiswa }}</td>
        @php
            if (is_null($member->nilai)) {
              $nilai = 'Belum dinilai';
            } else {
              $nilai = $member->nilai;
            }
        @endphp
      <td> {{$nilai}}</td>
        @php
            if (is_null($member->submit)) {
              $submit = 'Belum mengumpulkan';
            } else {
              $submit = date('d-m-Y', strtotime($member->submit));
            }
        @endphp      
      <td>{{$submit}}</td>
      <td>
        @if (is_null($member->submit))
          Belum mengumpulkan
        @else
        <a href="{{ url('/dosen/penilaian/'.$member->id_jawaban) }}"><i class="fas fa-marker" alt="beri nilai"></i>Beri Nilai</a>           
        @endif        
      </td>
      </tr>
      @php
        $i++;
      @endphp
  @endforeach
  </tbody>
  </table>



  </div>

@endsection