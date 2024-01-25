<?php
include_once './includes/session.php';
include_once './includes/api.php';
include_once 'header1.php';

?>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb" style="background: transparent; padding:0px;">
            <li><a href="home.php" style="color: #333;">Beranda</a></li>
            <li class="text-success" style="font-weight: bold;">Data Alternatif</li>
        </ol>
    </div>
    <div class="col-md-6 text-left">
        <h5>Data Alternatif</h5>
        <?php
            if (count(data_alternatif()) > 0 & count(data_kriteria()) > 0 & cek_valid_bobot()) {
                ?>
    </div>
</div>
<br />

<table width="100%" class="table table-striped table-bordered" id="tabeldata">
<tr class="text-center">
                        <th>No</th><th>Alternatif</th>
                        <?php
                        foreach (data_kriteria() as $x) echo "<th>{$x[1]}</th>";
                        ?>
                    </tr>
                    <?php $no = 1;
                    foreach (data_alternatif() as $x) {
                        echo "<tr><td class=\"text-center\">$no</td><td>{$x[1]}</td>";
                        foreach (data_kriteria() as $y) {
                            $n = nilai_alternatif($x[0], $y[0]);
                            echo "<td>$n</td>";
                        }
                        echo '</tr>';
                        $no++;
                    }
                    ?>

</table>

<button class="btn btn-danger" onclick="location.href='proses-data.php'"><span class="fas fa-radiation"></span> Proses Data</button>
                <?php
                } else {
                    if (count(data_kriteria()) < 1) echo '<div class="alert alert-dismissable alert-danger"><b>Data kriteria kosong</b>, silahkan di isi terlebih dahulu.</div>';
                    if (count(data_alternatif()) < 1) echo '<div class="alert alert-dismissable alert-danger"><b>Data alternatif kosong</b>, silahkan di isi terlebih dahulu.</div>';
                    if (!cek_valid_bobot()) echo '<div class="alert alert-dismissable alert-danger"><b>Perbadingan bobot kriteria tidak valid</b></div>';
                }
            ?>
    </div>

</div>
<br />


<?php

include_once 'footer.php';
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


if (isset($_SESSION['pesan_success'])) {
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
    unset($_SESSION['pesan_success']);
} elseif (isset($_SESSION['pesan_gagal'])) {
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
    unset($_SESSION['pesan_gagal']);
}

if (isset($_SESSION['pesan_sudah_ada'])) {
    echo '
        <script>
        Swal.fire({
            title: "Data yang dinilai sudah ada",
            showClass: {
                popup: "animate__animated animate__fadeInUp animate__faster"
            },
            hideClass: {
                popup: "animate__animated animate__fadeOutDown animate__faster"
            }
        });
        </script>';
    unset($_SESSION['pesan_sudah_ada']);
}
?>


