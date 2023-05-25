<?php

include "src/config/connect.php";

$level = $_SESSION['level'];

$row = mysqli_query($conn, "SELECT * FROM masyarakat ORDER BY nama ASC");

if ($level != "Admin") {
    echo "<script>
    alert('Anda tidak berhak mengakses modul ini!');
    document.location='?module=home';
    </script>";
}

// Edit
if (isset($_POST['edit'])) {
    $nik = htmlspecialchars($_POST['nik']);
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $telp = htmlspecialchars($_POST['telp']);
    $blokir = htmlspecialchars($_POST['blokir']);

    $query = mysqli_query($conn, "UPDATE masyarakat SET nama = '$nama', username = '$username', telp = '$telp', blokir = '$blokir' WHERE nik = '$nik'");

    if ($query) {
        echo "<script>
                alert('Data berhasil diubah!');
                document.location='?module=datamasyarakat';
            </script>";
    } else {
        echo "<script>
                alert('Data gagal diubah!');
                document.location='?module=datamasyarakat';
            </script>";
    }
}
// Edit

// Delete
if (isset($_POST['delete'])) {
    $foto = $_POST['foto'];
    $direktori = "src/account/img/";

    unlink($direktori . $foto);

    $query = mysqli_query($conn, "DELETE FROM masyarakat WHERE nik = '$_POST[nik]'");

    if ($query) {
        echo "<script>
                alert('Hapus data berhasil!');
                document.location='?module=datamasyarakat';
            </script>";
    } else {
        echo "<script>
                alert('Hapus data gagal!');
                document.location='?module=datamasyarakat';
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
        $('#table').dataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": true
        });
    });
</script>

<body>
    <div class="card">
        <div class="card-header fw-bold">
            Masyarakat
        </div>
        <div class="card-body">
            <table id="table" class="table border table-hover">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">NIK</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Telp</th>
                        <th scope="col">Blokir</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php while ($result = mysqli_fetch_array($row)) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $result["nik"] ?></td>
                            <td><?= $result["nama"] ?></td>
                            <td><?= $result["username"] ?></td>
                            <td><?= $result["password"] ?></td>
                            <td><?= $result["telp"] ?></td>
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
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                <img class="rounded-circle bg-dark" width="50" height="50" src="src/account/img/<?= $result['foto_masyarakat'] ?>">
                                            </div>
                                            <input type="hidden" name="id_masyarakat" value="<?= $result['id_masyarakat'] ?>">
                                            <input type="hidden" class="form-control" placeholder="NIK" name="nik" value="<?= $result['nik'] ?>" required>
                                            <input type="hidden" class="form-control" placeholder="Nama" name="nama" value="<?= $result['nama'] ?>" required>
                                            <input type="hidden" class="form-control" placeholder="Username" name="username" value="<?= $result['username'] ?>" required>
                                            <input type="hidden" class="form-control" placeholder="Password" name="password" value="<?= $result['password'] ?>" required>
                                            <input type="hidden" class="form-control" placeholder="Telp" name="telp" value="<?= $result['telp'] ?>" required>
                                            <p class="fw-bold text-center"><?= $result['nama'] ?></p>
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
                                        <input type="hidden" name="nik" value="<?= $result['nik'] ?>">
                                        <input type="hidden" name="foto" value="<?= $result['foto_masyarakat'] ?>">
                                        <div class="modal-body text-center">
                                            <p>Apakah anda yakin ingin menghapus data ini? <br>
                                                <span class="fw-bold text-danger"><?= $result['nama'] ?></span>
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
        </div>
    </div>
</body>

</html>