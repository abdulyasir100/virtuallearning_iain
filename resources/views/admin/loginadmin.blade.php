<html lang="en">
<head>
 <title>Halaman Login</title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

 <style>
 body, html {
     height: 100%;
     margin: 0;
     background-position: center;
     background-repeat: no-repeat;
     background-size: cover;
     background-attachment: fixed;
 }
 </style>
 <body>
     <div class="" style="margin:80px;">
<hr>
<nav class="navbar navbar-expand-sm navbar-light fixed-top" style="background-color: #ffffff;">
    <a class="navbar-brand" href="#"><img src="{{asset('img/assets/logo_iain.png')}}" alt="Kembali" style="width:40px;"></a>
</nav>
    @if(\Session::has('alert'))
<div class="alert alert-danger" style="margin:80px;">
    <div>{{Session::get('alert')}}</div>
</div>
@endif
@if(\Session::has('alert-success'))
<div class="alert alert-success" style="margin:80px;">
    <div>{{Session::get('alert-success')}}</div>
</div>
@endif
<form action="{{ url('/loginadminPost') }}" method="post" style="margin:80px;">
{{ csrf_field() }}
<div class="form-group"
    <label for="username">Username:</label>
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
<br>
 </div>
 </body>
