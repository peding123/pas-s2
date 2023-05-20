<?php

include "src/config/connect.php";

// Add
if (isset($_POST['submit'])) {
    $nik = htmlspecialchars($_POST['nik']);
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars(md5($_POST['password']));
    $telp = htmlspecialchars($_POST['telp']);

    $query = mysqli_query($conn, "INSERT INTO masyarakat VALUES ('$nik', '$nama', '$username', '$password', '$telp')");

    if ($query) {
        echo "<script>
                    alert('Register berhasil! silahkan login untuk melanjutkan');
                    document.location='login.php';
                </script>";
    } else {
        echo "<script>
                    alert('Register gagal! silahkan coba lagi');
                    document.location='signup.php';
                </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/assets/style/login/style.css">
    <title>Register</title>
</head>

<body>
    <div class="wrapper">
        <div class="login-content py-5">
            <h1 class="text-center border-bottom pb-3 mb-5">Register</h1>
            <form method="post" action="">
                <div class="mb-3">
                    <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <input type="number" class="form-control" id="telp" name="telp" placeholder="Telp" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2" name="submit">Register</button>
                <p class="text-center mt-3">A member? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>

    <script src="src/assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>