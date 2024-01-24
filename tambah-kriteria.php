
<?php
include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';

$pesan = "";
if (!empty($_POST)) {
    $pesan_error = array();
    $nama = $_POST['nama'];
    if ($nama == '') array_push($pesan_error, 'Nama kriteria tidak boleh kosong');
    $atribut = $_POST['atribut'];

    // Cek apakah data sudah ada
    $cek_data = $koneksi->prepare("SELECT COUNT(*) FROM kriteria WHERE nama = :nama");
    $cek_data->bindParam(':nama', $nama);
    $cek_data->execute();
    $jumlah_data = $cek_data->fetchColumn();

    if ($jumlah_data > 0) {
        array_push($pesan_error, 'Data dengan nama kriteria tersebut sudah ada.');
    }

    if (empty($pesan_error)) {
        $q = $koneksi->prepare("INSERT INTO kriteria VALUE (NULL, :nama, :atribut, NULL)");
        $q->bindParam(':nama', $nama);
        $q->bindParam(':atribut', $atribut);

        if ($q->execute()) {
            $_SESSION['pesan'] = true;
            header("Location: data-kriteria.php");
            exit(); // Penting untuk menghentikan eksekusi script setelah header redirect
        } else {
            $_SESSION['pesan_gagal'] = false;
            header("Location: data-kriteria.php");
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
                <li class="text-success" style="font-weight: bold;">Tambah Data Kriteria</li>
            </ol>
        </div>
        <div class="col-md-6 text-left">
            <h5>Tambah Data Kriteria</h5>
            <form method="post">
                <div class="form-group">
                    <label for="nama">Nama Kriteria</label>
                    <input type="text" class="form-control" name="nama" id="nama" required="">
                </div>
                <div class="form-group">
                    <label for="atribut">Atribut Kriteria</label>
                    <select class="form-control" id="atribut" name="atribut">
                        <?php
                        foreach (data_atribut() as $x) {
                            echo "<option value=\"{$x['id']}\">{$x['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Tombol untuk menambahkan data -->
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="data-kriteria.php" class="btn btn-success">Kembali</a>
                <?php
                if (!empty($pesan_error)) {
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
