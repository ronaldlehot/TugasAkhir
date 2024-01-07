<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';


if (!empty($_POST)) {
    $pesan_error = array();
    $nama = $_POST['nama'];
    if ($nama=='') array_push($pesan_error, 'Nama kriteria tidak boleh kosong');
    $atribut = $_POST['atribut'];
    if (empty($pesan_error)) {
        $q = $koneksi->prepare("INSERT INTO kriteria VALUE (NULL, '$nama', '$atribut', NULL)");
        $q->execute();
        header('Location: data-kriteria.php');
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
        <button type="submit" class="btn btn-success" onclick="addData()">Simpan</button>
            <button type="button" onclick="location.href='data-kriteria.php'" class="btn btn-success">Kembali</button>
            <?php if (!empty($pesan_error)) {
                echo '<hr><div class="alert alert-dismissable alert-danger"><ul>';
                foreach ($pesan_error as $x) {
                    echo '<li>'.$x.'</li>';
                }
                echo '</ul></div>';
            }
            ?>
        </form>

        </div>
    </div>
</div>

<!-- Skrip JavaScript -->
<script>
    // Menampilkan alert ketika tombol "Simpan" ditekan
    function addData() {
        if  (document.getElementById("nama").value == "") {
            alert("Nama kriteria tidak boleh kosong");
            return false;
        }
        alert("Data telah berhasil ditambahkan, silahkan tekan tombol ok untuk kembali ke halaman data kriteria");
    }
</script>



<?php include_once 'footer.php'; ?>