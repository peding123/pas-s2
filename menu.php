<?php

include "src/config/connect.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['level'] == 'Admin') {
    $sql = mysqli_query($conn, "SELECT * FROM module WHERE (status='Admin' OR status='Petugas' OR status='All') AND aktif='Y' ORDER BY urutan");
} else if ($_SESSION['level'] == 'Petugas') {
    $sql = mysqli_query($conn, "SELECT * FROM module WHERE (status='Petugas' OR status='All') AND aktif='Y' ORDER BY urutan");
} else if ($_SESSION['level'] == 'Masyarakat') {
    $sql = mysqli_query($conn, "SELECT * FROM module WHERE (status='Masyarakat' OR status='All') AND aktif='Y' ORDER BY urutan");
}
while ($m = mysqli_fetch_array($sql)) {
    echo "<a style='text-decoration: none; color: inherit; display: block; padding: 15px 15px; border-radius: 5px; font-size: 1.2rem;' href='$m[link]' class='hover-effect'>$m[icon] $m[nama_modul]</a>";
}
