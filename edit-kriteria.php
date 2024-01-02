<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';


if (!empty($_POST)) {
    $pesan_error = array();
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    if ($nama=='') array_push($pesan_error, 'Nama kriteria tidak boleh kosong');
    $atribut = $_POST['atribut'];
    if (empty($pesan_error)) {
        $q = $koneksi->prepare("UPDATE kriteria SET nama='$nama', atribut='$atribut' WHERE id='$id'");
        $q->execute();
        ob_clean();
        header('Location: ./data-kriteria.php');
    }
} else if (!empty($_GET)) {
    @$id = $_GET['id'];
    $q = $koneksi->prepare("SELECT * FROM kriteria JOIN atribut ON kriteria.atribut=atribut.id WHERE kriteria.id='$id'");
    $q->execute();
    @$data = $q->fetchAll()[0];
    if ($data) {
        $id = $data[0];
        $nama = $data[1];
        $atribut = $data[4];
    } else header('Location: ./data-kriteria.php');
} else header('Location: ./data-kriteria.php');

?>



<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8">
        <div class="page-header">
            <h5>Ubah Kriteria</h5>
        </div>

        <form method="post">
            
            <!-- <div class="form-group">
                <label for="kt">ID Kriteria</label>
                <input type="text" class="form-control" id="id" name="id" value="<?=$id?>"  >
            </div> -->
            <div class="form-group">
                <label for="kt">Nama Kriteria</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?=$nama?>">
            </div>
            <div class="form-group">
                <label for="atribut">Atribut Kriteria</label>
                <select id="atribut" name="atribut" class="form-control mb-2 mr-sm-2">
                    <?php
                    foreach (data_atribut() as $x) {
                        if ($x['id']==$atribut) $s = ' selected';
                        else $s = '';
                        echo "<option$s value=\"{$x['id']}\">{$x['nama']}</option>";
                    }
                    ?>
                    </select>
            </div>
         
            <button type="submit" class="btn btn-success" onclick="editData()">Ubah</button>
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

<script>
    // Menampilkan alert ketika tombol "Simpan" ditekan
    function editData() {
        if  (document.getElementById("nama").value == "") {
            alert("Nama kriteria tidak boleh kosong");
            return false;
        }
        else {
            alert("Data berhasil diubah");
            return true;
        }
    }
</script>

<?php
include_once 'footer.php';
?>
