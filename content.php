<?php

include "src/config/connect.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_GET['module'] == 'dashboard') {
    include "src/module/dashboard/index.php";
}
if ($_GET['module'] == 'home') {
    include "src/module/home/index.php";
}
if ($_GET['module'] == 'datamasyarakat') {
    include "src/module/masyarakat/index.php";
}
if ($_GET['module'] == 'datapetugas') {
    include "src/module/petugas/index.php";
}
if ($_GET['module'] == 'pengaduan') {
    include "src/module/pengaduan/index.php";
}
if ($_GET['module'] == 'tanggapan') {
    include "src/module/tanggapan/index.php";
}
if ($_GET['module'] == 'pmasyarakat') {
    include "src/module/pmasyarakat/index.php";
}
if ($_GET['module'] == 'tmasyarakat') {
    include "src/module/tmasyarakat/index.php";
}
