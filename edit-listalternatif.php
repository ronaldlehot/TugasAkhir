<?php
include_once './includes/session.php';
include_once './includes/api.php';
include_once 'header1.php';


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $q = $koneksi->prepare("SELECT * FROM alternatif WHERE id = :id");
    $q->bindParam(':id', $id);
    $q->execute();
    $data = $q->fetch();
    if (empty($data)) header('Location: ./list-alternatif.php');
    $nama = $data['nama'];
} else header('Location: ./list-alternatif.php');

if (!empty($_POST)) {
    $nama = $_POST['nama'];
    
    $validasi = true;
    $pesan_error = array();

    if ($nama=='') array_push($pesan_error, 'Nama tidak boleh kosong');

    if (empty($pesan_error)) {
        $q = $koneksi->prepare("UPDATE alternatif SET nama='$nama' WHERE id='$id'");
        $q->bindParam(':nama', $nama);
        $q->bindParam(':id', $id);
       

        if($q->execute()){
            $_SESSION['pesan_sukses'] = true;
            header('Location: ./list-alternatif.php');
            exit;
        }else{
            $_SESSION['pesan_gagal'] = true;
            header('Location: ./list-alternatif.php');
            exit;
        }
        
        header('Location: ./list-alternatif.php');
    }
}

?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8">
        <div class="page-header">
            <h5>Ubah Data Alternatif</h5>
        </div>

        <form method="post">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?=@$nama?>" >
            </div>
            <button type="submit"  class="btn btn-success">Ubah</button>
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

<?php
include_once 'footer.php';
?>
