<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';



?>

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
        <td class=\"text-center\">
        <a href=\"edit-kriteria.php?id={$x[0]}\" class=\"btn btn-warning \"><span class=\"glyphicon glyphicon-pencil\"> </span></a>
        <a href=\"hapus-kriteria.php?id={$x[0]}\" class=\"btn btn-danger \" onclick=\"return confirm('Apakah kamu yakin ingin menghapus data ini?');\"><span class=\"glyphicon glyphicon-trash\"></span></a>
        </td>";
        echo '</tr>';
        $no++;
    } ?> 
    </tbody>

</table>


 <?php include_once 'footer.php'; ?>


 