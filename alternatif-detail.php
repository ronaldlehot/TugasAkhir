<?php
include_once './includes/session.php';
include_once './includes/api.php';
include_once 'header1.php';
?>

<div class="container">
    <div class="row">
        <!-- Bagian HTML Anda -->
        <!-- ... -->
        <table width="100%" class="table table-striped table-bordered" id="tabeldata">
            <tr class="text-center">
           
           <?php $qNama = $koneksi->prepare("SELECT * FROM alternatif WHERE id = :id");
            $qNama->bindParam(':id', $_GET['id']);
            $qNama->execute();
            $dataNama = $qNama->fetch();
            echo "<tr><td colspan=\"4\" class=\"text-center\">{$dataNama['nama']}</td></tr>";
            ?>
                <th>No</th>
                <th>Kriteria</th>
                <th>Nilai</th>
                <th>Periode</th>
            </tr>

            <?php
            $no = 1;
            foreach (data_kriteria() as $x) {
                $periode = getPeriode($_GET['id']);
                echo "<tr><td class=\"text-center\">$no</td><td>{$x[1]}</td><td>" . nilai_alternatif($_GET['id'], $x[0]) . "</td><td>$periode</td></tr>";
                $no++;
            }
            ?>

            <tr>
                <td colspan="4" class="text-center">
                    <button type="button" onclick="location.href='alternatif.php'" class="btn btn-success">Kembali</button>
                </td>
            </tr>
        </table>
        <!-- ... -->
    </div>
</div>

<?php include_once 'footer.php'; ?>
