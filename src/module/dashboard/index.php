<?php

include 'src/config/connect.php';

$level = $_SESSION['level'];

if ($level == "Admin" || $level == "Petugas") {
    $id_petugas = $_SESSION['id_petugas'];
} elseif ($level == "Masyarakat") {
    $nik = $_SESSION['nik'];
}

$sql = "SELECT COUNT(*) as masyarakat FROM masyarakat";
$masyarakat = mysqli_query($conn, $sql);

$sql = "SELECT COUNT(*) as petugas FROM petugas";
$petugas = mysqli_query($conn, $sql);

if ($level == "Admin" || $level == "Petugas") {
    $sql = "SELECT COUNT(*) as pengaduan FROM pengaduan WHERE status = 'Proses'";
} elseif ($level == "Masyarakat") {
    $sql = "SELECT COUNT(*) as pengaduan FROM pengaduan WHERE status = 'Proses' AND nik = $nik";
}
$pengaduan = mysqli_query($conn, $sql);

if ($level == "Admin") {
    $sql = "SELECT COUNT(*) as tanggapan FROM tanggapan";
} elseif ($level == "Petugas") {
    $sql = "SELECT COUNT(*) as tanggapan FROM tanggapan WHERE id_petugas = $id_petugas";
} elseif ($level == "Masyarakat") {
    $sql = "SELECT COUNT(*) as tanggapan FROM tanggapan INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan WHERE pengaduan.nik = $nik";
}
$tanggapan = mysqli_query($conn, $sql);


if (mysqli_num_rows($masyarakat) > 0) {
    $row = mysqli_fetch_assoc($masyarakat);
    $masyarakat = $row["masyarakat"];
} else {
    echo "Belum ada user dalam database.";
}

if (mysqli_num_rows($petugas) > 0) {
    $row = mysqli_fetch_assoc($petugas);
    $petugas = $row["petugas"];
} else {
    echo "Belum ada user dalam database.";
}

if (mysqli_num_rows($pengaduan) > 0) {
    $row = mysqli_fetch_assoc($pengaduan);
    $pengaduan = $row["pengaduan"];
} else {
    echo "Belum ada user dalam database.";
}

if (mysqli_num_rows($tanggapan) > 0) {
    $row = mysqli_fetch_assoc($tanggapan);
    $tanggapan = $row["tanggapan"];
} else {
    echo "Belum ada user dalam database.";
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
    <title>Document</title>
</head>

<body>
    <div class="wrapper">
        <div class="row">
            <?php if ($level == "Admin") : ?>
                <div class="col bg-info text-light shadow rounded p-3 m-4">
                    <div class="row">
                        <div class="col">
                            <h1 class="fw-bold"><?= $masyarakat ?></h1>
                            <span class="fs-5">Masyarakat</span>
                        </div>
                        <div class="col justify-content-center d-flex align-items-center">
                            <span class="icon"><i class="fa-solid fa-users"></i></i></span>
                        </div>
                        <a class="text-center" href="?module=datamasyarakat">
                            <div class="fs-1"><i class="fa-solid fa-circle-arrow-right"></i></div>
                        </a>
                    </div>
                </div>
                <div class="col bg-warning text-light shadow rounded p-3 m-4">
                    <div class="row">
                        <div class="col">
                            <h1 class="fw-bold"><?= $petugas ?></h1>
                            <span class="fs-5">Petugas</span>
                        </div>
                        <div class="col justify-content-center d-flex align-items-center">
                            <span class="icon"><i class="fa-solid fa-user"></i></i></span>
                        </div>
                        <a class="text-center" href="?module=datapetugas">
                            <div class="fs-1"><i class="fa-solid fa-circle-arrow-right"></i></div>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col bg-danger text-light shadow rounded p-3 m-4">
                <div class="row">
                    <div class="col">
                        <h1 class="fw-bold"><?= $pengaduan ?></h1>
                        <span class="fs-5">Pengaduan</span>
                    </div>
                    <div class="col justify-content-center d-flex align-items-center">
                        <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>
                    </div>
                    <?php if ($level == "Admin" || $level == "Petugas") : ?>
                        <a class="text-center" href="?module=pengaduan">
                            <div class="fs-1"><i class="fa-solid fa-circle-arrow-right"></i></div>
                        </a>
                    <?php elseif ($level == "Masyarakat") : ?>
                        <a class="text-center" href="?module=pmasyarakat">
                            <div class="fs-1"><i class="fa-solid fa-circle-arrow-right"></i></div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col bg-success text-light shadow rounded p-3 m-4">
                <div class="row">
                    <div class="col">
                        <h1 class="fw-bold"><?= $tanggapan ?></h1>
                        <span class="fs-5">Tanggapan</span>
                    </div>
                    <div class="col justify-content-center d-flex align-items-center">
                        <span class="icon"><i class="fa-solid fa-reply"></i></span>
                    </div>
                    <?php if ($level == "Admin" || $level == "Petugas") : ?>
                        <a class="text-center" href="?module=tanggapan">
                            <div class="fs-1"><i class="fa-solid fa-circle-arrow-right"></i></div>
                        </a>
                    <?php elseif ($level == "Masyarakat") : ?>
                        <a class="text-center" href="?module=tmasyarakat">
                            <div class="fs-1"><i class="fa-solid fa-circle-arrow-right"></i></div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="src/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>