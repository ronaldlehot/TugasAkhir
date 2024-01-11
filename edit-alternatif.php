<?php


include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';
// ambil id alternatif dari parameter
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    // buat query untuk mengambil semua data nilai_alternatif berdasarkan alternatif menggunakan perulangan
    $q = $koneksi->prepare("SELECT * FROM nilai_alternatif WHERE alternatif = :id");
    $q->bindParam(':id', $id);
    $q->execute();
    $data = $q->fetchAll();
    // buat array kosong untuk menampung data kriteria
    $kriteria = array();
    // buat perulangan untuk mengambil data kriteria
    foreach (data_kriteria() as $x) {
        // buat array kosong untuk menampung data kriteria
        $kriteria[$x[0]] = array();
        // buat perulangan untuk mengambil data nilai_alternatif
        foreach ($data as $y) {
            // jika id_kriteria pada data nilai_alternatif sama dengan id_kriteria pada data kriteria
            if ($y['kriteria'] == $x[0]) {
                // masukkan nilai ke dalam array kriteria
                $kriteria[$x[0]] = $y['nilai'];
            }
        }
    }
    $dataKriteria = $kriteria;
    $qNama = $koneksi->prepare("SELECT * FROM alternatif WHERE id = :id");
    $qNama->bindParam(':id', $id);
    $qNama->execute();
    $dataNama = $qNama->fetch();
    $alternatif = $dataNama['nama'];
} else header('Location: ./alternatif.php');


if (isset($_POST['update'])) {
    $id = $_GET['id'];
    $kriteria = $_POST['kriteria'];
    $id_kriteria = $_POST['id_kriteria'];
    $queryDelete = $koneksi->prepare("DELETE FROM nilai_alternatif WHERE alternatif = :id");
    $queryDelete->bindParam(':id', $id);
    $queryDelete->execute();

    foreach ($id_kriteria as $key => $value) {
        $q = $koneksi->prepare("INSERT INTO nilai_alternatif (alternatif, kriteria, nilai) values (:alternatif, :kriteria, :nilai)");
        $q->bindParam(':alternatif', $id);
        $q->bindParam(':kriteria', $value);
        $q->bindParam(':nilai', $kriteria[$key]);
        $q->execute();
    }

    // Update data periode di tabel histori
    $periode = $_POST['periode'];
    $sql = "UPDATE histori SET periode = :periode WHERE alternatif = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':periode', $periode);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    header('Location: ./alternatif.php');
}



?>




<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="">

                <div class="form-group">
                    <label for="alternatif">Nama Lengkap</label>
                    <input type="text" class="form-control" id="alternatif" name="alternatif" value="<?= htmlspecialchars($alternatif) ?>" readonly>
                </div>

                <?php
                foreach ($dataKriteria as $key => $value) {
                    $q = $koneksi->prepare("SELECT * FROM kriteria WHERE id = :id");
                    $q->bindParam(':id', $key);
                    $q->execute();
                    $data = $q->fetch();
                    $nama = $data['nama'];
                    $atribut = $data['atribut'];
                    $bobot = $data['bobot'];
                    $q = $koneksi->prepare("SELECT * FROM atribut WHERE id = :id");
                    $q->bindParam(':id', $atribut);
                    $q->execute();
                    $data = $q->fetch();
                    $atribut = $data['nama'];
                    echo "<div class=\"form-group\">
                    <label for=\"kriteria$key\">$nama ($atribut)</label>
                    <input type=\"hidden\" name=\"id_kriteria[]\" value=\"$key\">
                    <select class=\"form-control\" id=\"kriteria$key\" name=\"kriteria[]\">";

                    for ($i = 1; $i <= 5; $i++) {
                        if ($value == $i) $s = ' selected';
                        else $s = '';
                        echo "<option$s value=\"$i\">$i</option>";
                    }
                    echo "</select>
                    
                </div>";
                    }
                    ?> 
                    <?php echo "<div class=\"form-group\">
                    <label for=\"periode\">Periode</label>
                    <select class=\"form-control\" name=\"periode\">";
                       
                    for ($i = 2023; $i <= 2040; $i++) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                    
                    echo "</select>
                </div>";
                ?>
                


                <button type="submit" name="update" class="btn btn-danger">Update</button>
                <button type="button" onclick="location.href='alternatif.php'" class="btn btn-danger">Cancel</button>
            </form>
        </div>
    </div>



</div>
<?php


include_once 'footer.php';
?>