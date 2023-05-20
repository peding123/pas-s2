<?php

include "src/config/connect.php";

$level = $_SESSION['level'];
if ($level == "Masyarakat") {
    $nama = $_SESSION['nama'];
} elseif ($level == "Admin" || $level == "Petugas") {
    $nama_petugas = $_SESSION['nama_petugas'];
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
    <link rel="stylesheet" href="src/assets/style/home/style.css">
    <title>Home</title>
</head>

<body>
    <div class="welcome text-center shadow bg-light rounded">
        <?php if ($level == "Masyarakat") : ?>
            <h3>Selamat datang <?= $nama; ?> <br> Untuk mengakses modul, klik pada sidebar bagian kiri!</h3>
        <?php elseif ($level == "Admin" || $level == "Petugas") : ?>
            <h3>Selamat datang <?= $nama_petugas; ?> <br> Untuk mengakses modul, klik pada sidebar bagian kiri!</h3>
        <?php endif; ?>
    </div>
</body>

</html>