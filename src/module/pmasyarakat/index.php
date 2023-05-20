<?php

include "src/config/connect.php";

$level = $_SESSION['level'];

if ($level != "Masyarakat") {
    echo "<script>
    alert('Anda tidak berhak mengakses modul ini!');
    document.location='?module=home';
    </script>";
}

$nik = $_SESSION['nik'];
$tanggal = date("Y-m-d");

// Add
if (isset($_POST['add'])) {
    $judul = htmlspecialchars($_POST['judul']);
    $isi = htmlspecialchars($_POST['isi']);

    $direktori = "src/report/img/";
    $file_name = $_FILES['file']['name'];

    if ($_FILES['file']['size'] > 0) {
        // Pengguna telah memilih untuk mengunggah gambar baru
        if (file_exists($direktori . $file_name)) {
            unlink($direktori . $file_name);
        }
        move_uploaded_file($_FILES['file']['tmp_name'], $direktori . $file_name);
    } else {
        // Pengguna tidak memilih untuk mengunggah gambar baru
        $default_image = "src/assets/img/NoImage.jpg";
        $file_name = "NoImage.jpg";
        if (!is_dir($direktori)) {
            mkdir($direktori, 0755, true);
        }
        if (file_exists($direktori . $file_name)) {
            unlink($direktori . $file_name);
        }
        copy($default_image, $direktori . $file_name);
    }

    move_uploaded_file($_FILES['file']['tmp_name'], $direktori . $file_name);

    $query = mysqli_query($conn, "INSERT INTO pengaduan (id_pengaduan, tgl_pengaduan, nik, judul, isi_laporan, foto, status) VALUES ('', '$tanggal', '$nik', '$judul', '$isi', '$file_name', 'Proses')");

    if ($query) {
        echo "<script>
                alert('Pengaduan berhasil dibuat, silahkan tunggu sampai pengaduan ditanggapi!');
                document.location='?module=pmasyarakat';
            </script>";
    } else {
        echo "<script>
                alert('Pengaduan gagal dibuat!');
                document.location='?module=pmasyarakat';
            </script>";
    }
}
// Add

// Edit
if (isset($_POST['edit'])) {
    $judul = htmlspecialchars($_POST['judul']);
    $isi = htmlspecialchars($_POST['isi']);
    $fotolama = htmlspecialchars($_POST['fotolama']);
    $id = $_POST['id_pengaduan'];

    $direktori = "src/report/img/";
    $file_name = $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], $direktori . $file_name);

    if (empty($_FILES['file']['name'])) {
        $query = mysqli_query($conn, "UPDATE pengaduan SET judul = '$judul', isi_laporan = '$isi' WHERE id_pengaduan = '$id'");
    } else {
        unlink($direktori . $fotolama);
        $query = mysqli_query($conn, "UPDATE pengaduan SET judul = '$judul', isi_laporan = '$isi', foto = '$file_name' WHERE id_pengaduan = '$id'");
    }


    if ($query) {
        echo "<script>
                alert('Pengaduan berhasil dirubah!');
                document.location='?module=pmasyarakat';
            </script>";
    } else {
        echo "<script>
                alert('Pengaduan gagal dirubah!');
                document.location='?module=pmasyarakat';
            </script>";
    }
}
// Edit

// Delete
if (isset($_POST['delete'])) {
    $foto = htmlspecialchars($_POST['foto']);
    $direktori = "src/report/img/";

    unlink($direktori . $foto);
    $query = mysqli_query($conn, "DELETE FROM pengaduan WHERE id_pengaduan = '$_POST[id_pengaduan]'");

    if ($query) {
        echo "<script>
                alert('Pengaduan berhasil dihapus!');
                document.location='?module=pmasyarakat';
            </script>";
    } else {
        echo "<script>
                alert('Pengaduan gagal dirubah!');
                document.location='?module=pmasyarakat';
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
    <title>Document</title>
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
    <div class="wrapper bg-light shadow rounded p-2">
        <h1>Pengaduan</h1>
        <table id="table" class="table border table-hover">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Tanggal Masuk</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php $query = mysqli_query($conn, "SELECT * FROM pengaduan INNER JOIN masyarakat ON pengaduan.nik=masyarakat.nik WHERE pengaduan.nik = $nik AND pengaduan.status = 'Proses' ORDER BY pengaduan.tgl_pengaduan DESC"); ?>
                <?php while ($result = mysqli_fetch_array($query)) : ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $result['nik']; ?></td>
                        <td><?php echo $result['nama']; ?></td>
                        <td><?php echo $result['tgl_pengaduan']; ?></td>
                        <td><?php echo $result['judul']; ?></td>
                        <td><?php echo $result['status']; ?></td>
                        <td>
                            <div class='text-center'>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#moreModal<?= $no ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a> |
                                <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $no ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="moreModal<?= $no ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <input type="hidden" name="id_pengaduan" value="<?= $result['id_pengaduan']; ?>">
                                    <div class="modal-body">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="Judul" name="judul" value="<?= $result['judul'] ?>" required>
                                            <label>Judul</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea type="text" class="form-control" placeholder="Isi Laporan" name="isi" style="height: 200px" required><?= $result['isi_laporan'] ?></textarea>
                                            <label>Isi Laporan</label>
                                        </div>
                                        <div class="text-center mb-3">
                                            <img width="400" src="src/report/img/<?php echo $result['foto']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1" for="image">Tambahkan Foto</label>
                                            <input type="file" name="file" class="form-control" id="image" value="<?= $result['foto'] ?>">
                                            <input type="hidden" name="fotolama" value="<?= $result['foto'] ?>">
                                        </div>
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
                                    <input type="hidden" name="id_pengaduan" value="<?= $result['id_pengaduan'] ?>">
                                    <input type="hidden" name="foto" value="<?= $result['foto'] ?>">
                                    <div class="modal-body text-center">
                                        <p>Apakah anda yakin ingin menghapus pengaduan ini? <br>
                                            <span class="fw-bold text-danger"><?= $result['judul'] ?></span>
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

        <!-- Insert Modal -->
        <div class="modal fade" id="insertModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Complaint</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" placeholder="judul" name="judul" required>
                                <label>Judul Laporan</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Leave a comment here" name="isi" id="floatingTextarea" style="height: 200px" required></textarea>
                                <label for="floatingTextarea">Isi Laporan</label>
                            </div>
                            <div class="mb-3">
                                <label class="mb-1" for="image">Tambahkan Foto</label>
                                <input type="file" name="file" class="form-control" id="image">
                            </div>
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