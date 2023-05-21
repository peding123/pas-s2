<?php
include "src/config/connect.php";

// Add
if (isset($_POST['submit'])) {
    $nik = htmlspecialchars($_POST['nik']);
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars(md5($_POST['password']));
    $telp = htmlspecialchars($_POST['telp']);

    if (empty($nik) || empty($nama) || empty($username) || empty($password) || empty($telp)) {
        $empty = "Data tidak boleh ada yang kosong!";
    } else {
        $check_query = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik = '$nik'");
        if (mysqli_num_rows($check_query) > 0) {
            $error = "NIK sudah terdaftar cobalah NIK yang lain!";
        } else {
            if ($_FILES['file']['name'] != '') {
                $direktori = "src/account/img/";
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];

                $allowed_extensions = array("jpg", "jpeg", "png");
                $allowed_file_size = 2 * 1024 * 1024; // 2 MB

                // Validasi ekstensi file
                $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                if (!in_array($file_extension, $allowed_extensions)) {
                    echo "<script>
                            alert('Ekstensi file yang diunggah tidak valid. Hanya file dengan ekstensi JPG, JPEG, dan PNG yang diperbolehkan.');
                            document.location='signup.php';
                        </script>";
                    exit;
                }

                // Validasi ukuran file
                if ($file_size > $allowed_file_size) {
                    echo "<script>
                            alert('Ukuran file yang diunggah melebihi batas maksimal 2 MB.');
                            document.location='signup.php';
                        </script>";
                    exit;
                }

                if (file_exists($direktori . $file_name)) {
                    unlink($direktori . $file_name);
                }
                move_uploaded_file($_FILES['file']['tmp_name'], $direktori . $file_name);
            } else {
                $direktori = "src/account/img/";
                $default_image = "src/assets/img/UserImage.png";
                $file_name = "UserImage.png";
                if (!is_dir($direktori)) {
                    mkdir($direktori, 0755, true);
                }
                if (file_exists($direktori . $file_name)) {
                    unlink($direktori . $file_name);
                }
                copy($default_image, $direktori . $file_name);
            }


            $query = mysqli_query($conn, "INSERT INTO masyarakat VALUES ('', '$nik', '$nama', '$username', '$password', '$telp', 'Masyarakat', '$file_name')");

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
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <div class="mb-3 form-floating">
                            <input type="number" class="form-control" id="nik" name="nik" placeholder="NIK">
                            <label>NIK</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                            <label>Name</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                            <label>Username</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3 form-floating">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            <label>Password</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="number" class="form-control" id="telp" name="telp" placeholder="Telp">
                            <label>Telp</label>
                        </div>
                        <div class="mb-3">
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                    </div>
                    <?php if (isset($empty)) : ?>
                        <p style="color: #f9322c; font-style: italic;"><?= $empty; ?></p>
                    <?php endif; ?>
                    <?php if (isset($error)) : ?>
                        <p style="color: #f9322c; font-style: italic;"><?= $error; ?></p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2" name="submit">Register</button>
                <p class="text-center mt-3">A member? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>

    <script src="src/assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>