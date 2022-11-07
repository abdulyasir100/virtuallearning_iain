<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Halaman Admin')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="{{ url('/admin') }}">
    <img src="{{asset('img/assets/logo_iain.png')}}" height="40" class="d-inline-block align-top" style="float:left"alt="">
    <h3 style="padding-left:10px float:right">IAIN PADANGSIDIMPUAN</h3>
  </a>
  <div class="ms-auto">
  Anda login sebagai {{$name}}
  <a href="{{ url('/logoutadmin') }}">(Logout)</a>
  </div>

</nav>
    
    @yield('content')
</body>
</html>