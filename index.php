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
} elseif ($level == "Admin" || $level == "Petugas") {
    $nama_petugas = $_SESSION['nama_petugas'];
}
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                            <a class="navbar-brand" href="#"><?= $nama ?> | <?= $level ?></a>
                        <?php elseif ($level == "Admin" || $level == "Petugas") : ?>
                            <a class="navbar-brand" href="#"><?= $nama_petugas ?> | <?= $level ?></a>
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
                                    <a class="nav-link" href="logout.php">Logout</a>
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