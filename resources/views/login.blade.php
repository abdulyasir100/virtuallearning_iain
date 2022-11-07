<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Situs Virtual Learning IAIN PADANGSIDIMPUAN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <style>
    body {
    background-image: url("img/assets/bg_kampus.png");
    background-position: left bottom;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: auto 240px;
    background-color: rgba(0, 191, 255);
    background-blend-mode: screen;
    width: 98vw;
    }
</style>
</head>
<body>
<div class="row" style="margin-top:25vh">
    <div class="col-8 text-center mt-3">
    <h1 class="text-white font-weight-bolder display-4">Selamat Datang</h1>
    <h1 class="text-white">di Virtual Learning</h1>
    <img src="img/assets/logo_iain.png" alt="IAIN PADANGSIDIMPUAN">

    </div>

<div class="col-4">
<div class="container bg-light border border-3 border-white rounded rounded-lg p-3">
    @if (session('status'))
    <div class="alert alert-danger">
        {{ session('status') }}
    </div>
@endif
<form action="{{ url('/loginPost') }}" method="post" style="">
{{ csrf_field() }}
<div class="form-group">
    <label for="exampleFormControlSelect1">Masuk sebagai:</label>
    <select class="form-control" name="role">
      <option>Mahasiswa</option>
      <option>Dosen</option>
    </select>
  </div>
<div class="form-group"
    <label for="username">Username:</label>
    <h6 style="color:red">*Untuk Mahasiswa masukkan NIM</h6>
    <input type="username" class="form-control" name="username">
</div>
<div class="form-group">
    <label for="Password">Password:</label>
    <input type="password" class="form-control" name="password"></input>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-md btn-primary">Login</button>
</div>
</form>
</div>
</div>

</div>
</body>
</html>