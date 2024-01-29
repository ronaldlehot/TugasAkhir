<?php
include_once './includes/session.php';
include_once './includes/api.php';
include_once 'header1.php';





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

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style="background: transparent; padding:0px;">
                <li><a href="home.php" style="color: #333;">Beranda</a></li>
                <li class="text-success" style="font-weight: bold;">Data</li>
            </ol>
        </div>
        <div class="col-md-6 text-left">
            <h5>Data</h5>

        </div>
    </div>
</div>
<form method="get" action="">
    <label for="periode">Pilih Periode: </label>
    <select id="periode" name="periode" onchange="this.form.submit()" style="width: 70px; height: 30px;">
        <?php
        // Ambil data periode yang tersedia
        $q_periode = $koneksi->prepare("SELECT DISTINCT periode FROM histori");
        $q_periode->execute();
        $periodes = $q_periode->fetchAll(PDO::FETCH_COLUMN);

        // Definisikan variabel $selected_periode
        $selected_periode = isset($_GET['periode']) ? $_GET['periode'] : '';

        foreach ($periodes as $p) : ?>
            <option value="<?= $p ?>" <?= ($p == $selected_periode) ? 'selected' : '' ?>><?= $p ?></option>
        <?php endforeach; ?>
    </select>
</form>

<div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div class="row">


    <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="page-header">
            <h5>Kriteria-Kriteria</h5>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <ol class="list-unstyled">

                    <?php
                    foreach (data_kriteria() as $x) {
                        echo "<li>{$x[1]} ({$x[5]})</li>";
                    }
                    ?>
                </ol>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-4" style="float: right;">
        <div class="page-header">
            <h5>Alternatif </h5>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <ol class="list-unstyled">

                    <?php
                    foreach (data_alternatif() as $x) {
                        echo "<li>{$x[1]}</li>";
                    }
                    ?>
                </ol>
            </div>
        </div>
    </div>
</div>



<script>
    var chart1; // globally available
    $(document).ready(function() {
        chart1 = new Highcharts.Chart({
            chart: {
                renderTo: 'container2',
                type: 'column'
            },
            title: {
                text: 'Grafik Perangkingan'
            },
            xAxis: {
                categories: ['Alternatif']
            },
            yAxis: {
                title: {
                    text: 'Jumlah Nilai'
                }
            },
            series: [
                // Ambil data alternatif berdasarkan hasil akhir dari tabel nilai_alternatif
                <?php
                // Ambil data periode yang tersedia
                $q_periode = $koneksi->prepare("SELECT DISTINCT periode FROM histori");
                $q_periode->execute();
                $periodes = $q_periode->fetchAll(PDO::FETCH_COLUMN);

                $selected_periode = isset($_GET['periode']) ? $_GET['periode'] : $periodes[0]; // Pilih periode pertama sebagai default

                // Ambil data alternatif berdasarkan hasil akhir dari tabel nilai_alternatif
                $q = $koneksi->prepare("SELECT DISTINCT nama_alternatif FROM histori WHERE periode = ?");
                $q->execute(array($selected_periode));
                $q->setFetchMode(PDO::FETCH_NUM);

                while ($r = $q->fetch()) {
                    $nama_alternatif = $r[0];
                    $q2 = $koneksi->prepare("SELECT hasil_akhir FROM histori WHERE nama_alternatif = ? AND periode = ?");
                    $q2->execute(array($nama_alternatif, $selected_periode));
                    $q2->setFetchMode(PDO::FETCH_NUM);
                    $nilai = array();

                    while ($r2 = $q2->fetch()) {
                        $nilai[] = $r2[0];
                    }

                    $nilai = implode(",", $nilai);
                    echo "{name: '{$nama_alternatif}', data: [{$nilai}]},";
                }
                ?>
            ]
        });
    });
</script>


<!-- Tombol Kembali ke Atas -->
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
</script>

<?php include_once 'footer.php';
if (isset($_SESSION['login_success'])) {
    echo "<script>
    swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Login Berhasil',
            showConfirmButton: false,
            timer: 1500
    });
    </script>";
    unset($_SESSION['login_success']);
}

?>