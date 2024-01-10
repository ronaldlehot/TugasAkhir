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
                <li class="text-success" style="font-weight: bold;">Detail Alternatif</li>
            </ol>
        </div>
        <div class="col-md-6 text-left">
            <h5>Detail </h5>
        
          
            <table width="100%" class="table table-striped table-bordered" id="tabeldata">
                <tr class="text-center">
                    <th>No</th>
                    <th>Kriteria</th>
                    <th>Nilai</th>
                </tr>
              
                <?php
                $no = 1;
                foreach (data_kriteria() as $x) {
                    echo "<tr><td class=\"text-center\">$no</td><td>{$x[1]}</td><td>" . nilai_alternatif($_GET['id'], $x[0]) . "</td></tr>";
                    $no++;
                }
                ?>
              
                <button type="button" onclick="location.href='alternatif.php'" class="btn btn-success">Kembali</button>

            </table>
        
        

        </div>
    </div>
</div>


<?php include_once 'footer.php'; ?>