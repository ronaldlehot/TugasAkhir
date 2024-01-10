<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';





?>

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
            
                
               
                
            


           
            
               
            ]
        });
    });
</script>

<?php include_once 'footer.php'; ?>
