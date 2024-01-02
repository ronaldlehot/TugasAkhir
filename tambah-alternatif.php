<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';


if (!empty($_POST)) {
    $pesan_error = array();
    $nama = $_POST['nama'];
    if ($nama=='') array_push($pesan_error, 'Nama alternatif tidak boleh kosong');
    if (empty($pesan_error)) {
        $q = $koneksi->prepare("INSERT INTO alternatif VALUE (NULL, '$nama')");
        $q->execute();
        header('Location: list-alternatif.php');
    }
}


?>



<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style="background: transparent; padding:0px;">
                <li><a href="main.php" style="color: #333;">Beranda</a></li>
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
        <button type="submit" class="btn btn-success" onclick="addData()">Simpan</button>
            <button type="button" onclick="location.href='list-alternatif.php'" class="btn btn-success">Kembali</button>
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
            alert("Nama alternaitif tidak boleh kosong");
            return false;
        }
        alert("Data telah berhasil ditambahkan, silahkan tekan tombol ok untuk kembali ke halaman data alternatif");
    }
</script>



<?php include_once 'footer.php'; ?>