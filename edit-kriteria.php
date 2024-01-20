<?php
include './includes/api.php';
include './includes/session.php';
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

include 'header1.php';
?>
<div class="row">
     <div class="col-xs-12 col-sm-12 col-md-8">       
        <div class="page-header">
            <h5>Ubah Kriteria</h5>
        </div>
        <form method="post"  >
            <input type="hidden" name="id" value="<?=$id?>">
            <label class="form-group" for="nama">Nama Kriteria</label>
            <input id="nama" name="nama" class="form-control mb-2 mr-sm-2" type="text" value="<?=$nama?>">
            <label class="form-group" for="atribut">Atribut</label>
            <select id="atribut" name="atribut" class="form-control mb-2 mr-sm-2">
            <?php
            foreach (data_atribut() as $x) {
                if ($x['id']==$atribut) $s = ' selected';
                else $s = '';
                echo "<option$s value=\"{$x['id']}\">{$x['nama']}</option>";
            }
            ?>
            </select>
            <br>
            <button class="btn btn-success" type="submit"><span class="fas fa-save"></span> Simpan</button>
            <button class="btn btn-success" type="reset" onclick="location.href='./data-kriteria'"><span class="fas fa-times"></span> Batal</button>
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
<?php include 'footer.php';?>