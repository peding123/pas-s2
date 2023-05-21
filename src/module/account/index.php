<?php
include "src/config/connect.php";

$level = $_SESSION['level'];

if ($level == "Masyarakat") {
    $nik = $_SESSION['nik'];
} else if ($level == "Admin" || $level == "Petugas") {
    $id_petugas = $_SESSION['id_petugas'];
}

if (isset($_POST['save'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $fotolama = mysqli_real_escape_string($conn, $_POST['fotolama']);

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $allowedFormats = array('image/jpeg', 'image/jpg', 'image/png');
        $fileType = $_FILES['file']['type'];
        $fileSize = $_FILES['file']['size'];

        // Validasi format file
        if (in_array($fileType, $allowedFormats)) {
            // Validasi ukuran file
            if ($fileSize <= 2097152) { // 2 MB
                $direktori = "src/account/img/";
                $file_name = $_FILES['file']['name'];
                move_uploaded_file($_FILES['file']['tmp_name'], $direktori . $file_name);

                if ($level == "Masyarakat") {
                    if (!empty($file_name)) {
                        unlink($direktori . $fotolama);
                        $query = mysqli_query($conn, "UPDATE masyarakat SET nama = '$nama', username = '$username', telp = '$telp', foto_masyarakat = '$file_name' WHERE nik = '$nik'");
                    } else {
                        $query = mysqli_query($conn, "UPDATE masyarakat SET nama = '$nama', username = '$username', telp = '$telp' WHERE nik = '$nik'");
                    }
                } else if ($level == "Admin" || $level == "Petugas") {
                    if (!empty($file_name)) {
                        unlink($direktori . $fotolama);
                        $query = mysqli_query($conn, "UPDATE petugas SET nama_petugas = '$nama', username = '$username', telp = '$telp', foto_petugas = '$file_name' WHERE id_petugas = '$id_petugas'");
                    } else {
                        $query = mysqli_query($conn, "UPDATE petugas SET nama_petugas = '$nama', username = '$username', telp = '$telp' WHERE id_petugas = '$id_petugas'");
                    }
                }
            } else {
                // File melebihi ukuran yang diizinkan
                echo "<script>
                        alert('Ukuran gambar terlalu besar. Maksimal ukuran gambar adalah 2 MB!');
                        document.location='?module=account';
                    </script>";
                exit;
            }
        } else {
            // File yang diunggah bukan format yang diizinkan
            echo "<script>
                    alert('Format gambar tidak valid. Hanya file JPEG, JPG, dan PNG yang diperbolehkan!');
                    document.location='?module=account';
                </script>";
            exit;
        }
    } else {
        if ($level == "Masyarakat") {
            $query = mysqli_query($conn, "UPDATE masyarakat SET nama = '$nama', username = '$username', telp = '$telp' WHERE nik = '$nik'");
        } else if ($level == "Admin" || $level == "Petugas") {
            $query = mysqli_query($conn, "UPDATE petugas SET nama_petugas = '$nama', username = '$username', telp = '$telp' WHERE id_petugas = '$id_petugas'");
        }
    }

    if ($query) {
        echo "<script>
                alert('Data pribadi berhasil diperbarui!');
                document.location='?module=account';
            </script>";
    } else {
        echo "<script>
                alert('Data pribadi gagal diperbarui!');
                document.location='?module=account';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/assets/bootstrap/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <div class="card">
        <div class="card-header fw-bold">
            Data Pribadi
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <?php if ($level == "Masyarakat") : ?>
                        <?php $query = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik = '$nik'"); ?>
                    <?php elseif ($level == "Admin" || $level == "Petugas") : ?>
                        <?php $query = mysqli_query($conn, "SELECT * FROM petugas WHERE id_petugas = '$id_petugas'"); ?>
                    <?php endif; ?>
                    <?php while ($result = mysqli_fetch_array($query)) : ?>
                        <div class="col">
                            <div class="mb-3">
                                <div class="justify-content-center align-items-center d-flex">
                                    <?php if ($level == "Masyarakat") : ?>
                                        <img width="100" height="100" class="bg-dark rounded-circle float-end mb-3" src="src/account/img/<?php echo $result['foto_masyarakat']; ?>">
                                    <?php elseif ($level == "Admin" || $level == "Petugas") : ?>
                                        <img width="100" height="100" class="bg-dark rounded-circle float-end mb-3" src="src/account/img/<?php echo $result['foto_petugas']; ?>">
                                    <?php endif; ?>
                                </div>
                                <input type="file" name="file" class="form-control" id="image">
                                <?php if ($level == "Masyarakat") : ?>
                                    <input type="hidden" name="fotolama" value="<?= $result['foto_masyarakat'] ?>">
                                <?php elseif ($level == "Admin" || $level == "Petugas") : ?>
                                    <input type="hidden" name="fotolama" value="<?= $result['foto_petugas'] ?>">
                                <?php endif; ?>
                            </div>
                            <?php if ($level == "Masyarakat") : ?>
                                <div class="form-floating mb-3">
                                    <input type="number" name="nik" id="nik" class="form-control" value="<?= $result['nik'] ?>" disabled>
                                    <label>NIK</label>
                                </div>
                            <?php endif; ?>
                            <div class="form-floating mb-3">
                                <?php if ($level == "Masyarakat") : ?>
                                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $result['nama'] ?>" required>
                                <?php elseif ($level == "Admin" || $level == "Petugas") : ?>
                                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $result['nama_petugas'] ?>" required>
                                <?php endif; ?>
                                <label>Nama</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="username" id="username" class="form-control" value="<?= $result['username'] ?>" required>
                                <label>Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="telp" id="telp" class="form-control" value="<?= $result['telp'] ?>" required>
                                <label>Telp</label>
                            </div>
                        </div>
                        <div class="col">
                            <label class="mb-1">Change Password</label>
                            <div class="form-floating mb-3">
                                <input type="password" name="oldPassword" id="oldPassword" class="form-control">
                                <label>Old Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="newPassword" id="newPassword" class="form-control">
                                <label>New Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                                <label>Confirm Password</label>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <a href="?module=home" class="btn btn btn-danger w-100"><i class="fa-solid fa-xmark"></i></a>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-warning w-100" name="save"><i class="fa-solid fa-floppy-disk"></i></button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>