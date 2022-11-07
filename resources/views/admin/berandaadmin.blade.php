@extends('layout.admin')
@section('title','Beranda Admin')
@section('content')
<div class="m-2 gap-2">
<h2>Tabel Dosen</h2>
  <a href="{{ url('/admin/tambahdosen') }}"> <button type="button" class="btn btn-primary">Buat akun dosen </button><img src="img/assets/button/add-48.png" alt="add" title="add" height="32"></a>
  <table class="table table-condensed table-hover table-bordered mt-2">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama dosen</th>
        <th>Link gambar Profil</th>
        <th>kode dosen</th>
        <th>Edit profil</th>
        <th>Hapus akun</th>
      </tr>
    </thead>
    <tbody>
      @php
        $i=1;
      @endphp
  @foreach ($dosens as $dosen)
    <tr>
      <td>{{$i}}</td>
      <td><a href="{{ url('/admin/profildosen/'.$dosen->kode_dosen) }}">{{ $dosen->nama_dosen }}</a></td>
      <td> {{ $dosen->foto_path}}</td>
      <td>{{ $dosen->kode_dosen }}</td>
      <td>
        <form class="" action="{{ url('/admin/profildosen/'.$dosen->kode_dosen) }} ">
              <input type="image" src="img/assets/button/edit-64.png" alt="edit" title="edit" height="32" name="submit">
              </form>
      </td>
      <td>
        <form class="" action="{{ url('/admin/hapusdosen/'.$dosen->kode_dosen) }} " method="post">
              <input type="image" src="img/assets/button/delete-48.png" alt="delete" title="delete" height="32" name="submit" value="delete">
               {{ csrf_field() }}
               <input type="hidden" name="_method" value="DELETE">
              </form>
      </td>
      </tr>
      @php
        $i++;
      @endphp
  @endforeach
  </tbody>
  </table>

  <h2>Tabel mahasiswa</h2>
  <a href="{{ url('/admin/tambahmahasiswa') }}"> <button type="button" class="btn btn-primary">Buat akun mahasiswa </button><img src="img/assets/button/add-48.png" alt="add" title="add" height="32"></a>
  <table class="table table-condensed table-hover table-bordered mt-2">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama mahasiswa</th>
        <th>Link gambar Profil</th>
        <th>NIM</th>
        <th>Edit profil</th>
        <th>Hapus akun</th>
      </tr>
    </thead>
    <tbody>
      @php
        $i=1;
      @endphp
  @foreach ($siswas as $mahasiswa)
    <tr>
      <td>{{$i}}</td>
      <td><a href="{{ url('/admin/profilmahasiswa/'.$mahasiswa->NIM) }}">{{ $mahasiswa->nama_mahasiswa }}</a></td>
      <td> {{ $mahasiswa->foto_path}}</td>
      <td>{{ $mahasiswa->NIM }}</td>
      <td>
        <form class="" action="{{ url('/admin/profilmahasiswa/'.$mahasiswa->NIM) }} ">
              <input type="image" src="img/assets/button/edit-64.png" alt="edit" title="edit" height="32" name="submit">
              </form>
      </td>
      <td>
        <form class="" action="{{ url('/admin/hapusmahasiswa/'.$mahasiswa->NIM) }} " method="post">
              <input type="image" src="img/assets/button/delete-48.png" alt="delete" title="delete" height="32" name="submit" value="delete">
               {{ csrf_field() }}
               <input type="hidden" name="_method" value="DELETE">
              </form>
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