<?php

session_start();

include "src/config/connect.php";

if (@$_GET['module'] == "") {
    echo "<script>
    document.location='login.php';
    </script>";
}

$level = $_SESSION['level'];
if ($level == "Masyarakat") {
    $nama = $_SESSION['nama'];
    $nik = $_SESSION['nik'];
} elseif ($level == "Admin" || $level == "Petugas") {
    $nama_petugas = $_SESSION['nama_petugas'];
    $id_petugas = $_SESSION['id_petugas'];
}
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

if ($level == "Masyarakat") {
    $query = mysqli_query($conn, "SELECT foto_masyarakat FROM masyarakat WHERE nik = '$nik'");
    if (mysqli_num_rows($query) > 0) {
        // Baris yang cocok ditemukan
        while ($result = mysqli_fetch_array($query)) {
            $foto_masyarakat = $result['foto_masyarakat'];
        }
    }
} else if ($level == "Admin" || $level == "Petugas") {
    $query = mysqli_query($conn, "SELECT foto_petugas FROM petugas WHERE id_petugas = '$id_petugas'");
    if (mysqli_num_rows($query) > 0) {
        // Baris yang cocok ditemukan
        while ($result = mysqli_fetch_array($query)) {
            $foto_petugas = $result['foto_petugas'];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/assets/style/dashboard/style.css">
    <title>Aplikasi Pengaduan Masyarakat</title>
</head>

<body>

    <div class="wrapper">
        <div class="row">
            <div class="col-md-2 menu-side bg-dark text-light px-4 rounded">
                <?php include "menu.php" ?>
            </div>
            <div class="col-md-10 bg-body-secondary">
                <nav class="navbar navbar-expand-lg bg-primary navbar-dark shadow rounded mt-2">
                    <div class="container-fluid">
                        <?php if ($level == "Masyarakat") : ?>
                            <img width="40" height="40" class="bg-dark rounded-circle mx-2" src="src/account/img/<?= $foto_masyarakat ?>" alt="">
                            <a class="navbar-brand" href="?module=account"><?= $nama ?> | <?= $level ?></a>
                        <?php elseif ($level == "Admin" || $level == "Petugas") : ?>
                            <img width="40" height="40" class="bg-dark rounded-circle mx-2" src="src/account/img/<?= $foto_petugas ?>" alt="">
                            <a class="navbar-brand" href="?module=account"><?= $nama_petugas ?> | <?= $level ?></a>
                        <?php endif; ?>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <?php include "clock.php" ?>
                                </li>
                            </ul>
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php">Logout <i class="fa-solid fa-right-from-bracket"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="content-side mt-3">
                    <div id="content">
                        <?php include "content.php"; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="src/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>