<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #00485C;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            width: 70%;
            height: 500px;
            display: flex;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border-radius: 10px;
        }
        .login-form {
            background-color: #f9f9f9;
            padding: 50px;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-image {
            width: 50%;
            background: url('image/bk.jpg') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #ffffff;
            font-weight: bold;
            font-size: 32px;
            backdrop-filter: blur(100px) brightness(0.7);
        }
        .form-control {
            margin-bottom: 20px;
            padding-left: 40px;
            background-image: url('https://img.icons8.com/ios/20/ffa200/user.png');
            background-repeat: no-repeat;
            background-position: 10px center;
        }
        .password {
            background-image: url('https://img.icons8.com/ios/20/ffa200/lock.png');
        }
        .btn-primary {
            background-color: #ffa200;
            border: none;
            font-weight: bold;
        }
        .btn-primary:hover {
            background-color: #ff8c00;
        }
        .login-title {
            font-weight: bold;
            font-size: 36px;
            margin-bottom: 20px;
        }
        .login-title span {
            border-bottom: 3px solid #ffa200;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-form">
        <h1 class="login-title"><span>Login</span></h1>
        @if($errors->any())
            <div>
                <strong>{{$errors->first()}}</strong>
            </div>
        @endif
        <form action="{{ route('login') }}" method="post">
            @csrf
            <input type="text" class="form-control" placeholder="Masukan nis" name="login" required>
            <input type="password" class="form-control password" placeholder="Masukan password" name="password" required>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
    </div>
    <div class="login-image">
        Laporkan Masalah <br> Bersama BK.
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
