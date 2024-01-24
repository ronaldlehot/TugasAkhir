<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';

$pesan = "";
if (!empty($_POST)) {
    $pesan_error = array();
    $nama = $_POST['nama'];
    if ($nama == '') array_push($pesan_error, 'Nama alternatif tidak boleh kosong');
    
    // Cek apakah data sudah ada
    $cek_data = $koneksi->prepare("SELECT COUNT(*) FROM alternatif WHERE nama = :nama");
    $cek_data->bindParam(':nama', $nama);
    $cek_data->execute();
    $jumlah_data = $cek_data->fetchColumn();

    if ($jumlah_data > 0) {
        array_push($pesan_error, 'Data dengan nama alternatif tersebut sudah ada.');
    }

    if (empty($pesan_error)) {
        $q = $koneksi->prepare("INSERT INTO alternatif VALUE (NULL, '$nama')");
        $q->bindParam(':nama', $nama);

        if ($q->execute()) {
            $_SESSION['pesan']= true;
            header('Location: list-alternatif.php');
            exit(); // Penting untuk menghentikan eksekusi script setelah header redirect
        } else {
            $_SESSION['pesan_gagal'] = false;
            header('Location: list-alternatif.php');
            exit(); // Penting untuk menghentikan eksekusi script setelah header redirect
        }
    }
}

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style="background: transparent; padding:0px;">
                <li><a href="home.php" style="color: #333;">Beranda</a></li>
                <li class="text-success" style="font-weight: bold;">Tambah Data Alternatif</li>
            </ol>
        </div>
        <div class="col-md-6 text-left">
            <h5>Tambah Data Alternatif</h5>
            <form method="post">

                <div class="form-group">
                    <label for="nama">Nama Alternatif</label>
                    <input type="text" class="form-control" name="nama" id="nama" required="">

                </div>

                <!-- Tombol untuk menambahkan data -->
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" onclick="location.href='list-alternatif.php'" class="btn btn-success">Kembali</button>
                <?php if (!empty($pesan_error)) {
                    echo '<hr><div class="alert alert-dismissable alert-danger"><ul>';
                    foreach ($pesan_error as $x) {
                        echo '<li>' . $x . '</li>';
                    }
                    echo '</ul></div>';
                } elseif ($pesan != "") {
                    echo '<hr><div class="alert alert-dismissable alert-success">' . $pesan . '</div>';
                }
                ?>
            </form>

        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>
