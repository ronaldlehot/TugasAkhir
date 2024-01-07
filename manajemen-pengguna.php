<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';

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
                    <button onclick=\"location.href='./edit-pengguna.php?username={$user[0]}'\" class=\"btn btn-warning\">
                        <span class=\"glyphicon glyphicon-pencil\"></span> 
                    </button>
                    <button onclick=\"hapusPengguna('{$user[0]}')\" class=\"btn btn-danger\">
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
        var confirmation = confirm('Apakah kamu yakin ingin menghapus data ini?');
        if (confirmation) {
            window.location.href = 'hapus-pengguna.php?username=' + username;
        }
    }
</script>

<?php include_once 'footer.php'; ?>