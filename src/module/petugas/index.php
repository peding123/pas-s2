<?php

include "src/config/connect.php";

$level = $_SESSION['level'];

if ($level != "Admin") {
    echo "<script>
    alert('Anda tidak berhak mengakses modul ini!');
    document.location='?module=home';
    </script>";
}

$row = mysqli_query($conn, "SELECT * FROM petugas ORDER BY nama_petugas ASC");

// Add
if (isset($_POST['add'])) {
    $nama_petugas = htmlspecialchars($_POST['nama_petugas']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars(md5($_POST['password']));
    $telp = htmlspecialchars($_POST['telp']);
    $level = htmlspecialchars($_POST['level']);

    $direktori = "src/account/img/";
    $default_image = "src/assets/img/UserImage.png";
    $file_name = "UserImage.png";

    if (!is_dir($direktori)) {
        mkdir($direktori, 0755, true);
    }

    // Copy the default profile photo to the petugas directory
    copy($default_image, $direktori . $file_name);

    $query = mysqli_query($conn, "INSERT INTO petugas (nama_petugas, username, password, telp, level, blokir, foto_petugas) VALUES ('$nama_petugas', '$username', '$password', '$telp', '$level', 'No', '$file_name')");

    if ($query) {
        echo "<script>
                alert('Data berhasil disimpan!');
                document.location='?module=datapetugas';
            </script>";
    } else {
        echo "<script>
                alert('Data gagal disimpan!');
                document.location='?module=datapetugas';
            </script>";
    }
}
// Add

// Edit
if (isset($_POST['edit'])) {
    $nama_petugas = htmlspecialchars($_POST['nama_petugas']);
    $username = htmlspecialchars($_POST['username']);
    $telp = htmlspecialchars($_POST['telp']);
    $level = htmlspecialchars($_POST['level']);
    $blokir = htmlspecialchars($_POST['blokir']);

    $query = mysqli_query($conn, "UPDATE petugas SET nama_petugas = '$nama_petugas', username = '$username', telp = '$telp', level = '$level', blokir = '$blokir' WHERE id_petugas = '$_POST[id_petugas]'");

    if ($query) {
        echo "<script>
                alert('Data berhasil diubah!');
                document.location='?module=datapetugas';
            </script>";
    } else {
        echo "<script>
                alert('Data gagal diubah!');
                document.location='?module=datapetugas';
            </script>";
    }
}
// Edit

// Delete
if (isset($_POST['delete'])) {
    $foto = $_POST['foto'];
    $direktori = "src/account/img/";

    unlink($direktori . $foto);

    $query = mysqli_query($conn, "DELETE FROM petugas WHERE id_petugas = '$_POST[id_petugas]'");

    if ($query) {
        echo "<script>
                alert('Hapus data berhasil!');
                document.location='?module=datapetugas';
            </script>";
    } else {
        echo "<script>
                alert('Hapus data gagal!');
                document.location='?module=datapetugas';
            </script>";
    }
}
// Delete

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/assets/datatables/datatables.css">
    <script src="src/assets/datatables/datatables.js"></script>
    <title>Petugas</title>
</head>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": true
        });
    });
</script>

<body>
    <div class="card">
        <div class="card-header fw-bold">
            Petugas
        </div>
        <div class="card-body">
            <table id="table" class="table border table-hover">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama Petugas</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">No. Telp</th>
                        <th scope="col">Level</th>
                        <th scope="col">Blokir</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1 ?>
                    <?php while ($result = mysqli_fetch_array($row)) : ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= $result["nama_petugas"] ?></td>
                            <td><?= $result["username"] ?></td>
                            <td><?= $result["password"] ?></td>
                            <td><?= $result["telp"] ?></td>
                            <td><?= $result["level"] ?></td>
                            <td><?= $result["blokir"] ?></td>
                            <td>
                                <div class='text-center'>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editModal<?= $no ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a> |
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $no ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $no ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="">
                                        <input type="hidden" name="id_petugas" value="<?= $result['id_petugas'] ?>">
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                <img class="rounded-circle bg-dark" width="50" height="50" src="src/account/img/<?= $result['foto_petugas'] ?>">
                                            </div>
                                            <input type="hidden" class="form-control" placeholder="nama_petugas" name="nama_petugas" value="<?= $result['nama_petugas'] ?>" required>
                                            <input type="hidden" class="form-control" placeholder="Username" name="username" value="<?= $result['username'] ?>" required>
                                            <input type="hidden" class="form-control" placeholder="Password" name="password" value="<?= $result['password'] ?>" disabled required>
                                            <input type="hidden" class="form-control" placeholder="Telp" name="telp" value="<?= $result['telp'] ?>" required>
                                            <p class="fw-bold text-center"><?= $result['nama_petugas'] ?></p>
                                            <label>Level</label>
                                            <select class="form-select mb-3" name="level" required>
                                                <option><?= $result['level'] ?></option>
                                                <option value="Admin">Admin</option>
                                                <option value="Petugas">Petugas</option>
                                            </select>
                                            <label>Blokir</label>
                                            <select class="form-select mb-3" name="blokir" required>
                                                <option><?= $result['blokir'] ?></option>
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="edit">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Modal -->

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?= $no ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="">
                                        <input type="hidden" name="id_petugas" value="<?= $result['id_petugas'] ?>">
                                        <input type="hidden" name="foto" value="<?= $result['foto_petugas'] ?>">
                                        <div class="modal-body text-center">
                                            <p>Apakah anda yakin ingin menghapus data ini? <br>
                                                <span class="fw-bold text-danger"><?= $result['nama_petugas'] ?></span>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="delete">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Modal -->
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="button" class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#insertModal">
                <i class="fa-solid fa-plus"></i></i>
            </button>
        </div>

        <!-- Insert Modal -->
        <div class="modal fade" id="insertModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" placeholder="nama_petugas" name="nama_petugas" required>
                                <label>Nama Petugas</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" placeholder="Username" name="username" required>
                                <label>Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" placeholder="Password" name="password" required>
                                <label>Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" placeholder="Telp" name="telp" required>
                                <label>Telp</label>
                            </div>
                            <select class="form-select" name="level" required>
                                <option value="Admin">Admin</option>
                                <option value="Petugas">Petugas</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="add">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Insert Modal -->
    </div>
</body>

</html>