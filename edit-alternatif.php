<?php
include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';

if (!empty($_POST['alternatif']) && !empty($_POST['kriteria']) && !empty($_POST['id_kriteria'])) {
    global $koneksi;

    $alternatif = $_POST['alternatif'];
    $kriteria = $_POST['kriteria'];
    $id_kriteria = $_POST['id_kriteria'];
    $nilai = $_POST['nilai'];

    if (is_array($id_kriteria)) {
        foreach ($id_kriteria as $key => $value) {
            $id_alternatif = $alternatif;
            $current_kriteria = $value; // Gunakan variabel baru untuk kriteria saat ini

            $sql = "UPDATE nilai_alternatif SET nilai = :nilai WHERE alternatif = :alternatif AND kriteria = :kriteria";
            $stmt = $koneksi->prepare($sql);
            $stmt->bindParam(':alternatif', $id_alternatif);
            $stmt->bindParam(':kriteria', $current_kriteria); // Gunakan variabel baru
            $stmt->bindParam(':nilai', $nilai[$key]);
            $stmt->execute();
        }

        header('Location: data-alternatif.php');
        exit();
    } else {
        echo "ID Kriteria tidak valid.";
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="">
                <!-- Tambahkan input untuk nilai baru yang akan diupdate -->
                <!-- <input type="hidden" name="alternatif" value="<?php echo $_POST['alternatif']; ?>">
                <input type="hidden" name="kriteria" value="<?php echo $_POST['kriteria']; ?>">
                <input type="hidden" name="id_kriteria" value="<?php echo $_POST['id_kriteria']; ?>"> -->

                <?php if (isset($_POST['kriteria']) && is_array($_POST['kriteria'])) : ?>
                    <?php foreach ($_POST['id_kriteria'] as $key => $value) : ?>
                        <div class="form-group">
                            <label for="nilai<?= $value ?>">Nilai Kriteria: <?= $value ?></label>
                            <input type="number" class="form-control" id="nilai<?= $value ?>" name="nilai[]" value="<?php echo $_POST['nilai'][$key]; ?>">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" onclick="location.href='alternatif.php'" class="btn btn-danger">Cancel</button>
            </form>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>
