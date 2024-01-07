<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';
?>


<style>
td.text-center a.btn {
    padding: 5px 10px; 
    font-size: 12px; 
}
</style>



<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb" style="background: transparent; padding:0px;">
            <li><a href="main.php" style="color: #333;">Home</a></li>
            <li class="text-success" style="font-weight: bold;">Data Alternatif</li>
        </ol>
    </div>
    <div class="col-md-6 text-left">
        <h5>Data Alternatif</h5>
    </div>
    <div class="col-md-6 text-right">
        <button onclick="location.href='upload-alternatif.php'" class="btn btn-success">Upload Data Excel</button>
        <button onclick="location.href='penilaian-alternatif.php'" class="btn btn-success">Input Penilaian</button>
    </div>
</div>
<br />

<table width="100%" class="table table-striped table-bordered" id="tabeldata">
    <thead>
        <tr>
            <th width="30px">No</th>
            <th>ID</th>
            <th>Nama </th>
            <th width="100px">Aksi</th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Nama </th>
            <th>Aksi</th>
        </tr>
    </tfoot>

    <tbody>
    <?php
        $no = 1;
        foreach (data_alternatif() as $row) {
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['nama'] ?></td>
                <!-- <td><?php echo $row['hasil_akhir'] ?></td> -->
                <td class="text-center"  >
                    <a href="alternatif-detail.php?id=<?php echo $row['id'] ?>" class="btn btn-info"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                    <a href="edit-alternatif.php?id=<?php echo $row['nama'] ?>" class="btn btn-warning"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                    <!-- <a href="alternatif-hapus.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data')" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> -->
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>

</table>
<?php
include_once 'footer.php';
?>


