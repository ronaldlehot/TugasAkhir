<?php
ob_clean() ; // Menghapus semua data yang ada di output buffer
ob_start(); // Memulai output buffering baru
include_once './includes/session.php';
include_once './includes/api.php';
include_once 'header1.php';



if (!empty($_GET)) {
    $username = $_GET['username'];
    $q = $koneksi->prepare("SELECT * FROM pengguna WHERE username='$username'");
    $q->execute();
    @$data = $q->fetchAll()[0];
    if ($data) {
        $username = $data['username'];
        $level = $data['level'];
        $nama = $data['nama'];
    } else header('Location: ./manajemen-pengguna');
} else header('Location: ./manajemen-pengguna');

if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];
    $nama = $_POST['nama'];
    
    $validasi = true;
    $pesan_error = array();

    if ($username!=$_GET['username']) {
        $q = $koneksi->prepare("SELECT * FROM pengguna WHERE username='$username'");
        $q->execute();
        if ($q->rowCount() > 0) array_push($pesan_error, 'Username sudah digunakan');
    }
    if ($username=='') array_push($pesan_error, 'Username tidak boleh kosong');

    if (pengguna()['username']==$_GET['username'] & $level!=pengguna()['level']) array_push($pesan_error, 'Tidak dapat mengubah level diri sendiri');

    if ($nama=='') array_push($pesan_error, 'Nama tampilan tidak boleh kosong');

    if (empty($pesan_error)) {
        if ($password!='') $q = $koneksi->prepare("UPDATE pengguna SET username='$username', password=SHA2('$password', 0), level='$level', nama='$nama' WHERE username='{$_GET['username']}'");
        else $q = $koneksi->prepare("UPDATE pengguna SET username='$username', level='$level', nama='$nama' WHERE username='{$_GET['username']}'");
       

        if($q->execute()){
            $_SESSION['pesan_sukses'] = true;
            header('Location: ./manajemen-pengguna.php');
            exit;
        }else{
            $_SESSION['pesan_gagal_diubah'] = true;
            header('Location: ./manajemen-pengguna.php');
            exit;
        }
        
        header('Location: ./manajemen-pengguna.php');
    }
}
ob_end_flush();
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8">
        <div class="page-header">
            <h5>Ubah Pengguna</h5>
        </div>

        <form method="post">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?=@$nama?>" >
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?=@$username?>" >
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?=@$password?>" >
            </div>
            <div class="form-group">
                <label for="level">Level Pengguna</label>
                <select class="form-control" id="level" name="level">
                <?php
                    foreach (data_level() as $x) {
                        $s = '';
                        if ($x['id']==@$level) $s = ' selected';
                        echo "<option$s value=\"{$x['id']}\">{$x['keterangan']}</option>";
                    }
                    ?>
                </select>

            </div>
            <button type="submit"  class="btn btn-success">Ubah</button>
            <button type="button" onclick="location.href='manajemen-pengguna.php'" class="btn btn-success">Kembali</button>
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
