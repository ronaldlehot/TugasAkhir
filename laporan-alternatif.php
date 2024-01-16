<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';

// Cari data histori berdasarkan periode yang di-input user
$data = array(); // Inisialisasi array untuk menampung data

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['periode'])) {
    $periode = $_POST['periode'];
    $sql = "SELECT * FROM histori WHERE periode = :periode";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':periode', $periode);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ambil nama alternatif berdasarkan id alternatif yang ada di tabel histori
    foreach ($data as $key => $value) {
        $id_alternatif = $value['alternatif'];
        $sql = "SELECT * FROM alternatif WHERE id = :id";
        $stmt = $koneksi->prepare($sql);
        $stmt->bindParam(':id', $id_alternatif);
        $stmt->execute();
        $data[$key]['alternatif'] = $stmt->fetch(PDO::FETCH_ASSOC);
    }
  
}

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style="background: transparent; padding:0px;">
                <li><a href="home.php" style="color: #333;">Beranda</a></li>
                <li class="text-success" style="font-weight: bold;">Laporan Alternatif</li>
            </ol>
        </div>
        <div class="col-md-6 text-left">
            <h5>Laporan Alternatif</h5>

            <form action="" method="post">
                <div class="form-group">
                    <label >Periode:</label>
                    <select class="form-control" name="periode">
                        <option></option>
                        <?php for ($i = 2023; $i <= 2040; $i++) : ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <br>
                    <button type="submit" class="btn btn-danger">Cari</button>
                </div>
            </form>

            <!-- Tampilkan tabel berdasarkan periode yang di-input user yakni atribut alternatif, periode, dan hasil_akhir -->
            <table width="100%" class="table table-striped table-bordered" id="tabeldata">
                <thead>
                    <tr>
                        <th width="30px">No</th>
                        <th>Alternatif</th>
                        <th>Periode</th>
                        <th>Hasil Akhir</th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Alternatif</th>
                        <th>Periode</th>
                        <th>Hasil Akhir</th>
                    </tr>
                </tfoot>

                <tbody>
                    <?php
                    $no = 1;
                    foreach ($data as $row) {
                    ?>
                        <tr>
                            <td class="text-center"><?= $no ?></td>
                            <td><?= $row['alternatif']['nama'] ?></td>
                            <td><?= $row['periode'] ?></td>
                            <td><?= $row['hasil_akhir'] ?></td>
                        </tr>
                    <?php
                        $no++;
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>
