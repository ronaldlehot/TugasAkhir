
<?php
include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';

?>

<style>
#btnBackToTop {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 99;
    font-size: 18px;
    border: none;
    outline: none;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    padding: 15px;
    border-radius: 5px;
}

#btnBackToTop:hover {
    background-color: #0056b3;
}



    
</style>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb" style="background: transparent; padding:0px;">
            <li><a href="home.php" style="color: #333;">Beranda</a></li>
            <li class="text-success" style="font-weight: bold;">Data Kriteria</li>
        </ol>

    </div>
    <div class="col-md-6 text-left">
        <h5>Data Kriteria</h5>
    </div>
    <div class="col-md-6 text-right">
        <button onclick="location.href='tambah-kriteria.php'" class="btn btn-success">Tambah Data</button>
    </div>
</div>
<br />

<table width="100%" class="table table-striped table-bordered" id="tabeldata">
    <thead>
        <tr>
            <th width="30px">No</th>
            <th>Nama Kriteria</th>
            <th>Atribut Kriteria</th>
             <th>Bobot Kriteria</th> 
            <th width="100px">Aksi</th>
        </tr>
    </thead>

    <tfoot>
        <tr>
        <th width="30px">No</th>
            <th>Nama Kriteria</th>
            <th>Atribut Kriteria</th>
            <th>Bobot Kriteria</th> 
            <th width="100px">Aksi</th>
        </tr>
    </tfoot>

    <tbody>
    <?php $no=1; 
 foreach (data_kriteria() as $x) {
        echo "<tr>";
        echo "<td class=\"text-center\">$no</td>
        <td>{$x[1]}</td>
        <td class=\"text-center\">{$x[5]}</td>
        <td class=\"text-center\">{$x[3]}</td>
        <td class=\"text-center table-actions\">
        <a href=\"edit-kriteria.php?id={$x[0]}\" class=\"btn btn-warning \"><span class=\"glyphicon glyphicon-pencil\"> </span></a>
        <a href=\"hapus-kriteria.php?id={$x[0]}\" class=\"btn btn-danger \" onclick=\"confirmAndAlert()\"><span class=\"glyphicon glyphicon-trash\"></span></a>
        </td>";
        echo '</tr>';
        $no++;
    } ?> 
    </tbody>

</table>


<button onclick="topFunction()" id="btnBackToTop" title="Kembali ke Atas">&#8679;</button>

<script>
window.onscroll = function() {
    scrollFunction();
};

function scrollFunction() {
    var btnBackToTop = document.getElementById("btnBackToTop");
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        btnBackToTop.style.display = "block";
    } else {
        btnBackToTop.style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0; // Untuk Safari
    document.documentElement.scrollTop = 0; // Untuk Chrome, Firefox, IE, dan Opera
}


function confirmAndAlert() {
        if (confirm('Apakah kamu yakin ingin menghapus data ini?')) {
            showAlert();
            return true;
        } else {
            return false;
        }
    }

    function showAlert() {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Data Berhasil Dihapus',
            showConfirmButton: false,
            timer: 15000  // Ubah timer sesuai kebutuhan Anda
        });
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

 ?>


 