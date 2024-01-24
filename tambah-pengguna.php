<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';

if (!empty($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];
    $nama = $_POST['nama'];
    
    $validasi = true;
    $pesan_error = array();

    $q = $koneksi->prepare("SELECT * FROM pengguna WHERE username='$username'");
    $q->execute();
    if ($q->rowCount() > 0) array_push($pesan_error, 'Username sudah digunakan');
    if ($username=='') array_push($pesan_error, 'Username tidak boleh kosong');

    if ($password=='') array_push($pesan_error, 'Password tidak boleh kosong');
    
    if ($nama=='') array_push($pesan_error, 'Nama tampilan tidak boleh kosong');

    if (empty($pesan_error)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $q_insert = $koneksi->prepare("INSERT INTO pengguna (username, password, level, nama) VALUES (:username, :password, :level, :nama)");
        $q_insert->bindParam(':username', $username);
        $q_insert->bindParam(':password', $hashed_password);
        $q_insert->bindParam(':level', $level);
        $q_insert->bindParam(':nama', $nama);

        if ($q_insert->execute()) {
            $_SESSION['pesan'] = true;
            header('Location: ./manajemen-pengguna.php');
            exit(); // Penting untuk menghentikan eksekusi script setelah header redirect
        } else {
            $_SESSION['pesan_gagal'] = true;
            header('Location: ./manajemen-pengguna.php');
            exit(); // Penting untuk menghentikan eksekusi script setelah header redirect
        }
    }
}
?>

<!-- CSS untuk gaya notifikasi -->
<style>
.notificationPengguna {
    position: fixed;
    top: 10px;
    right: 10px;
    background-color: #4CAF50;
    color: white;
    padding: 15px;
    border-radius: 5px;
    z-index: 9999;
}
</style>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8">
        <div class="page-header">
            <h5>Tambah Pengguna</h5>
        </div>

        <form method="post">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?=@$nama?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?=@$username?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?=@$password?>" required>
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
            <button type="submit" class="btn btn-success" onclick="addDataPengguna()" >Simpan</button>
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

<!-- Skrip JavaScript -->
<script>
        function addDataPengguna() {
            // Simulasi data berhasil ditambahkan
            // Anda harus menyesuaikan ini dengan logika sesungguhnya pada aplikasi Anda
            var dataAddedSuccessfully = true; // Ganti dengan logika pengaturan variabel data berhasil

            if (dataAddedSuccessfully) {
                // Buat elemen div untuk notifikasi
                var notification = document.createElement('div');
                notification.textContent = 'Data berhasil ditambahkan!';
                notification.classList.add('notification'); // Tambahkan kelas untuk gaya notifikasi

                // Tambahkan notifikasi ke dalam dokumen
                document.body.appendChild(notificationPengguna);

                // Hilangkan notifikasi setelah 20 detik
                setTimeout(function() {
                    notification.remove();
                }, 5000000);

        }
    }
    
</script>


<?php include_once 'footer.php'; ?>