<?php
include_once './includes/session.php';
include_once './includes/api.php';
include_once 'header1.php';


?>

<div class="row">
<div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style="background: transparent; padding:0px;">
                <li><a href="home.php" style="color: #333;">Beranda</a></li>
                <li class="text-success" style="font-weight: bold;">Data Pengguna</li>
            </ol>
        </div>
    <div class="col-md-6 text-left">
        <h4>Data Pengguna</h4>
    </div>
    <div class="col-md-6 text-right">
        <button onclick="location.href='tambah-pengguna.php'" class="btn btn-success">Tambah Data</button>
    </div>
</div>
<br />
<table width="100%" class="table table-striped table-bordered" id="tabeldata">
    <thead>
        <tr>
            <th width="30px">No</th>
            <th>Username</th>
            <th>Level</th>
            <th>Nama</th>
            <th width="100px">Aksi</th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Level</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </tfoot>
    
    <tbody>

    <?php
       $users = data_pengguna();
       foreach ($users as $index => $user) {
           $no = $index + 1;
           echo "<tr>";
           echo "<td class=\"text-center\">$no</td>
               <td>{$user['username']}</td>
               <td class=\"text-center\">{$user['keterangan']}</td>
               <td>{$user['nama']}</td>
               <td class=\"text-center\">
                   <button onclick=\"location.href='./edit-pengguna.php?username={$user['username']}'\" class=\"btn btn-warning\">
                       <span class=\"glyphicon glyphicon-pencil\"></span> 
                   </button>
                   <button onclick=\"hapusPengguna('{$user['username']}')\" class=\"btn btn-danger\" >
                       <span class=\"glyphicon glyphicon-trash\"></span> 
                   </button>
               </td>";
           echo '</tr>';
       }
       
        ?>


       

    </tbody>
</table>

<script>
    function hapusPengguna(username) {
        if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
            location.href = './hapus-pengguna.php?username=' + username;
        }
    }
</script>

<?php include_once 'footer.php'; 

if (isset($_SESSION['pesan'])) {
    echo "
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Data Berhasil Ditambahkan',
                showConfirmButton: false,
                timer: 1500
            });
        </script>";
    unset($_SESSION['pesan']);
} elseif (isset($_SESSION['pesan_gagal'])) {
    echo "
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Data Gagal Ditambahkan',
                showConfirmButton: false,
                timer: 1500
            });
        </script>";
    unset($_SESSION['pesan_gagal']);
}

if (isset($_SESSION['pesan_sukses'])) {
    echo "
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Data Berhasil Diubah',
                showConfirmButton: false,
                timer: 1500
            });
        </script>";
    unset($_SESSION['pesan_sukses']);
} elseif (isset($_SESSION['pesan_gagal_diubah'])) {
    echo "
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Data Gagal Diubah',
                showConfirmButton: false,
                timer: 1500
            });
        </script>";
    unset($_SESSION['pesan_gagal_diubah']);
}

if (isset($_SESSION['pesan_sukses_hapus'])) {
    echo "
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Data Berhasil Dihapus',
                showConfirmButton: false,
                timer: 1500
            });
        </script>";
    unset($_SESSION['pesan_sukses_hapus']);
} elseif (isset($_SESSION['pesan_gagal_hapus'])) {
    echo "
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Data Gagal Dihapus',
                showConfirmButton: false,
                timer: 1500
            });
        </script>";
    unset($_SESSION['pesan_gagal_hapus']);
}

?>