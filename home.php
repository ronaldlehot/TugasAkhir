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
                text: 'Grafik Perangkingan '
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
            
                //ambii data  alternatif  berdasarkan hasil akhir dari taeble histori
                <?php
                $q = $koneksi->prepare("SELECT * FROM alternatif");
                $q->execute();
                $data = $q->fetchAll();
                foreach ($data as $x) {
                    $id = $x[0];
                    $nama = $x[1];
                    $q = $koneksi->prepare("SELECT * FROM histori WHERE alternatif='$id'");
                    $q->execute();
                    $data = $q->fetchAll();
                    $hasil_akhir = $data[0][3];
                    echo "{name: '$nama',data: [$hasil_akhir]},";
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

<?php include_once 'footer.php'; ?>
