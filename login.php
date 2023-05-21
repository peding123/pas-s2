<?php

include 'src/config/connect.php';

if (isset($_POST["submit"])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars(md5($_POST['password']));
    if (empty($username) || empty($password)) {
        $empty = "Username dan password harus di isi!";
    } else {
        $proses = mysqli_query($conn, "SELECT * FROM petugas WHERE username = '$username' AND password = '$password'");
        $user = mysqli_num_rows($proses);
        $db = mysqli_fetch_array($proses);

        $proses2 = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username = '$username' AND password = '$password'");
        $user2 = mysqli_num_rows($proses2);
        $db2 = mysqli_fetch_array($proses2);

        if ($user > 0) {
            session_start();
            $_SESSION['id_petugas'] = $db['id_petugas'];
            $_SESSION['username'] = $db['username'];
            $_SESSION['nama_petugas'] = $db['nama_petugas'];
            $_SESSION['password'] = $db['password'];
            $_SESSION['level'] = $db['level'];
            header('Location: index.php?module=home');
            exit;
        } else if ($user2 > 0) {
            session_start();
            $_SESSION['nik'] = $db2['nik'];
            $_SESSION['nama'] = $db2['nama'];
            $_SESSION['username'] = $db2['username'];
            $_SESSION['telp'] = $db2['telp'];
            $_SESSION['password'] = $db2['password'];
            $_SESSION['level'] = $db2['level'];
            header('Location: index.php?module=home');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
        mysqli_close($conn);
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
    <title>Login</title>
</head>

<body>
    <div class="wrapper">
        <div class="login-content py-5">
            <h1 class="text-center border-bottom pb-3 mb-5">Login</h1>
            <form method="post" action="">
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    <label>Username</label>
                </div>
                <div class="mb-3 form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <label>Password</label>
                </div>
                <?php if (isset($error)) : ?>
                    <p style="color: #f9322c; font-style: italic;"><?= $error; ?></p>
                <?php endif; ?>
                <?php if (isset($empty)) : ?>
                    <p style="color: #f9322c; font-style: italic;"><?= $empty; ?></p>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary w-100 mt-2" name="submit">Login</button>
                <p class="text-center mt-3">Not a member? <a href="signup.php">Signup</a></p>
            </form>
        </div>
    </div>

    <script src="src/assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>