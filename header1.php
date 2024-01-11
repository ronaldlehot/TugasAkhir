<?php
include_once './includes/api.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Administrasi</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap.min.css" rel="stylesheet">

    <!-- My Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

   
    <style>
    body {
        font-family: Poppins;
    }

    nav {
        background-color: #0A9343;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    nav .navbar-brand {
        font-weight: bold;
        font-size: 18px !important;
    }

    a {
        color: #fff;
        display: flex;
        gap: 10px;
    }

    a img {
        margin-top: -10px;
    }

    .panel {
        background-color: white;
        border: none !important;
    }

    a:hover {
        background-color: transparent !important;
        color: #E3A413 !important;
        font-weight: bold;
    }
</style>
</head>



<body>

    <nav class="navbar">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php"><img src="images/puskesmas.png" alt="" width="32" height="40 mb-3">SPK AHP dan SAW</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                 <li><a href="home.php">Home</a></li>
                 <?php if (akses_pengguna(array(0))): ?>
                 <li><a href="list-alternatif.php">Data Alternatif</a></li>
                 <li><a href="manajemen-pengguna.php">Manajemen Pengguna</a></li>
                 <?php endif; ?>

                 <?php if (akses_pengguna(array(2))): ?>
                    <li><a href="data-kriteria.php">Data Kriteria</a></li>
                    <li><a href="perbandingan-kriteria.php">Perbandingan Kriteria</a></li>
                
                    <li><a href="alternatif.php">Alternatif</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></span>Analisa Alternatif <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                           
                            <li><a href="data-alternatif.php">Analisa Alternatif</a></li>
                            <li><a href="histori.php">Histori Alternatif</a></li>
                        </ul>
                <?php endif; ?>
                            

               

            </ul>

                <ul class="nav navbar-nav navbar-right">
                   
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></span>(<?=pengguna()['keterangan']?>) <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="keluar.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
</body>