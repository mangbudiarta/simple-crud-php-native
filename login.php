<?php
session_start();
include 'koneksi.php';
$error = false;
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $query = mysqli_query($db,"SELECT * FROM admin WHERE username = '$username' AND password = '$password'");
    $cek = mysqli_num_rows($query);
    $data = mysqli_fetch_assoc($query);
    if($cek > 0) {
        $_SESSION['login'] = true;
        if(isset($_POST['remember'])){
            setcookie('no_peserta',$data['id'],time()+3600);
            setcookie('key',hash('sha256', $data['username']),time()+3600);
        }
        echo " <script>alert('Berhasil Login')</script>";
        echo '<meta http-equiv="refresh" content="0; url=index.php">';
    } else {
        $error = true;
    }
}


if(isset($_COOKIE['no_peserta']) && isset($_COOKIE['key'])) {
    $no_peserta = $_COOKIE['no_peserta'];
    $key = $_COOKIE['key'];
    $result = mysqli_query($db,"SELECT username FROM admin WHERE id='$no_peserta'");
    $data = mysqli_fetch_assoc($result);
    if($key === hash('sha256', $data['username'])) {
        $_SESSION['login'] = true;
    }
}

if(isset($_SESSION['login'])) {
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Link Bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap.min.css">
</head>

<body class="bg-secondary">
    <div class="container">
        <form action="" method="post" class="col-lg-4 col-md-4 mx-auto mt-5 bg-white p-4">
            <?=  ($error == true) ? '<div class="alert alert-warning">Username / Password Salah! Ulangi lagi</div>':'' ; ?>
            <h2 class="h2 mb-2 text-center">Form Login</h2>
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" id="username" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="mb-2">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-label">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary px-4 py-2 w-100" name='login'>Login</button>
        </form>
    </div>
    <!-- Link js -->
    <script src="assets/bootstrap.bundle.min.js"></script>
</body>

</html>