<?php
ob_clean(); // Menghapus semua data yang ada di output buffer
ob_start();
include_once './includes/session.php';
include_once './includes/api.php';
include_once 'header1.php';
if (!empty($_POST)) {
    global $koneksi;

    // Periksa apakah nilai yang dibutuhkan ada dalam $_POST
    if (isset($_POST['alternatif']) && isset($_POST['kriteria']) && isset($_POST['periode'])) {
        $alternatif = $_POST['alternatif'];
        $kriteria = $_POST['kriteria'];
        $id_kriteria = $_POST['id_kriteria'];
        $periode = $_POST['periode'];

        // Ambil nama alternatif dari database
        $nama_alternatif_sql = "SELECT nama FROM alternatif WHERE id = :id_alternatif";
        $nama_alternatif_stmt = $koneksi->prepare($nama_alternatif_sql);
        $nama_alternatif_stmt->bindParam(':id_alternatif', $alternatif);
        $nama_alternatif_stmt->execute();
        $nama_alternatif = $nama_alternatif_stmt->fetchColumn();

        foreach ($id_kriteria as $key => $value) {
            // Lakukan pemeriksaan untuk memastikan data belum ada sebelumnya
            $check_sql = "SELECT COUNT(*) as count FROM nilai_alternatif WHERE alternatif = '{$alternatif}' AND kriteria = '{$value}'";
            $check_stmt = $koneksi->query($check_sql);
            $row = $check_stmt->fetch(PDO::FETCH_ASSOC);

            // Jika data sudah ada, tampilkan alert dan hentikan proses penyimpanan
            if ($row['count'] > 0) {
                $_SESSION['pesan_sudah_ada'] = true;
                header('Location: data-alternatif.php');
                exit; // Hentikan proses penyimpanan
            }

            // Jika data belum ada, lanjutkan proses penyimpanan kedalam kedua tabel (nilai_alternatif dan history)
            $data = array(
                'id_alternatif' => $alternatif,
                'id_kriteria' => $value,
                'nilai' => $kriteria[$key],
                'periode' => $periode // Tambahkan nilai periode ke dalam data yang akan disimpan
            );

            // Simpan nama alternatif ke tabel histori
            $sql = "INSERT INTO histori (alternatif, nama_alternatif, periode) VALUES (:id_alternatif, :nama_alternatif, :periode)";
            $stmt = $koneksi->prepare($sql);
            $stmt->bindParam(':id_alternatif', $alternatif);
            $stmt->bindParam(':nama_alternatif', $nama_alternatif);
            $stmt->bindParam(':periode', $periode);
            $stmt->execute();

            // Simpan data ke tabel nilai_alternatif
            $sql = "INSERT INTO nilai_alternatif (alternatif, kriteria, nilai) VALUES (:id_alternatif, :id_kriteria, :nilai )";
            $stmt = $koneksi->prepare($sql);
            $stmt->bindParam(':id_alternatif', $data['id_alternatif']);
            $stmt->bindParam(':id_kriteria', $data['id_kriteria']);
            $stmt->bindParam(':nilai', $data['nilai']);

            // Jika berhasil
            if ($stmt->execute()) {
                $_SESSION['pesan'] = true;
            } else {
                // Jika gagal
                $_SESSION['pesan_gagal'] = true;
            }
        }

        header('Location: data-alternatif.php');
        exit;
    }
}

ob_end_flush();
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="">
                <div class="form-group">
                    <label for="alternatif">Alternative:</label>
                    <select class="form-control" id="alternatif" name="alternatif"> <!-- Ubah name menjadi "nama[]" untuk mendapatkan array -->
                        <?php
                        foreach (data_alternatif() as $x) {
                            echo "<option value=\"{$x[0]}\">{$x[1]}</option>";
                        }
                        ?>
                    </select>
                </div>

                <?php foreach (data_kriteria() as $x) : ?>
                    <div class="form-group">
                        <label for="kriteria<?= $x[0] ?>">Kriteria: <?= $x[1] ?></label>
                        <input type="hidden" name="id_kriteria[]" value="<?= $x[0] ?>">
                        <select class="form-control" id="kriteria<?= $x[0] ?>" name="kriteria[]"> 
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                <?php endforeach; ?> 

                <div class="form-group">
                    <label>Periode</label>
                    <select class="form-control" name="periode">
                        <?php for ($i = 1; $i <= 28; $i += 2) { // 18 iterasi = 6 tahun (2023-2040)
                            $year = 2024 + floor(($i - 1) / 12); // Menghitung tahun
                            $month = ($i - 1) % 12 + 1; // Menghitung bulan
                            $date = date("F Y", mktime(0, 0, 0, $month, 1, $year)); // Format bulan dan tahun
                            if ($periode == "$year-$month") $s = ' selected';
                            else $s = '';
                            echo "<option$s value=\"$year-$month\">$date</option>";
                        }

                        ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-danger">Submit</button>
                <button type="button" onclick="location.href='alternatif.php'" class="btn btn-danger">Kembali</button>
            </form>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>