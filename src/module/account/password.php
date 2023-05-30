<?php

$level = $_SESSION['level'];

if ($level == "Masyarakat") {
    $nik = $_SESSION['nik'];
} else if ($level == "Admin" || $level == "Petugas") {
    $id_petugas = $_SESSION['id_petugas'];
}

if (isset($_POST['save'])) {
    $oldPassword = md5($_POST['old']);
    $username = $_SESSION['username'];

    if ($level == "Masyarakat") {
        $nik = $_SESSION['nik'];

        $show = mysqli_query($conn, "SELECT * FROM masyarakat WHERE username = '$username' AND password = '$oldPassword'");
        $data = mysqli_fetch_array($show);
        if ($data) {
            $newPassword = $_POST['new'];
            $confirmPassword = $_POST['confirm'];

            if ($newPassword == $confirmPassword) {
                $pass_ok = md5($confirmPassword);
                $ubah = mysqli_query($conn, "UPDATE masyarakat SET password = '$pass_ok' WHERE nik = $nik");

                if ($ubah) {
                    $success = "Password berhasil dirubah!";
                } else {
                    $error = "Password baru anda tidak sesuai dengan konfirmasi password!";
                }
            }
        } else {
            $notsame = "Password lama tidak sesuai!";
        }
    } else {
        $show = mysqli_query($conn, "SELECT * FROM petugas WHERE username = '$username' AND password = '$oldPassword'");
        $data = mysqli_fetch_array($show);
        if ($data) {
            $newPassword = $_POST['new'];
            $confirmPassword = $_POST['confirm'];

            if ($newPassword == $confirmPassword) {
                $pass_ok = md5($confirmPassword);
                $ubah = mysqli_query($conn, "UPDATE petugas SET password = '$pass_ok' WHERE id_petugas = $id_petugas");

                if ($ubah) {
                    $success = "Password berhasil dirubah!";
                } else {
                    $error = "Password baru anda tidak sesuai dengan konfirmasi password!";
                }
            }
        } else {
            $notsame = "Password lama tidak sesuai!";
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
    <title>Document</title>
    <script>
        function validateForm() {
            var oldPassword = document.getElementById("old").value;
            var newPassword = document.getElementById("new").value;
            var confirmPassword = document.getElementById("confirm").value;

            if (oldPassword === "" && newPassword === "" && confirmPassword === "") {
                alert("Mohon isi semua kolom password");
                return false;
            }

            if (oldPassword !== "" && (newPassword === "" || confirmPassword === "")) {
                alert("Mohon isi password baru dan konfirmasi password");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="card">
        <div class="card-header fw-bold">
            Ubah Password
        </div>
        <div class="card-body">
            <form action="" method="POST" onsubmit="return validateForm()">
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="old" id="old" placeholder="Old Password">
                            <label>Old Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="new" id="new" placeholder="New Password">
                            <label>New Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="confirm" id="confirm" placeholder="Confirm Password">
                            <label>Confirm Password</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <?php if (isset($success)) : ?>
                                <p style="color: #198754;"><?= $success; ?></p>
                            <?php endif; ?>
                            <?php if (isset($error)) : ?>
                                <p style="color: #f9322c; font-style: italic;"><?= $error; ?></p>
                            <?php endif; ?>
                            <?php if (isset($notsame)) : ?>
                                <p style="color: #f9322c; font-style: italic;"><?= $notsame; ?></p>
                            <?php endif; ?>
                            <div class="col">
                                <a href="?module=account" class="btn btn btn-danger w-100"><i class="fa-solid fa-xmark"></i></a>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-warning w-100" name="save"><i class="fa-solid fa-floppy-disk"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>