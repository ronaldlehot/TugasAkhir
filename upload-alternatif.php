<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';
require_once "./PHPExcel-1.8/Classes/PHPExcel.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style="background: transparent; padding:0px;">
                <li><a href="home.php" style="color: #333;">Beranda</a></li>
                <li class="text-success" style="font-weight: bold;">Upload Alternatif</li>
            </ol>
        </div>
        <div class="col-md-6 text-left">
            <h5>Upload Alternatif</h5>
            <?php 
                if (!empty($_FILES)) {
                    $eks = explode('.', $_FILES['file']['name']);
                    $eks = $eks[count($eks) - 1];
                    $file = './upload/' . mt_rand(0, 999999999) . '.' . $eks;
                    move_uploaded_file($_FILES['file']['tmp_name'], $file);
                
                    //baca excel
                    $excelReader = PHPExcel_IOFactory::createReaderForFile($file);
                    $excelObj = $excelReader->load($file);
                    unlink($file);
                    $worksheet = $excelObj->getSheet(0);
                    $baris_terakhir = $worksheet->getHighestRow();
                
                    //set kolom
                    $baris_mulai_data = @$_POST['baris'];
                    $nama = @$_POST['nama'];
                    $kriteria = array();
                    foreach (data_kriteria() as $x) {
                        $kriteria[$x[0]] = $_POST[$x[0]];
                    }
                
                    $q = $koneksi->prepare("DELETE FROM nilai_alternatif");
                    $q->execute();
                    $q = $koneksi->prepare("DELETE FROM alternatif");
                    $q->execute();
                    
                    for ($baris = $baris_mulai_data; $baris <= $baris_terakhir; $baris++) {
                        $q = $koneksi->prepare("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA='$NAMA_DATABASE' AND TABLE_NAME='alternatif'");
                        $q->execute();
                        $_next_id = @$q->fetchAll()[0][0];
                        $_nama = $worksheet->getCell($nama . $baris)->getValue();
                
                        $q = $koneksi->prepare("INSERT INTO alternatif VALUE (NULL, '$_nama')"); //insert nama alternatif
                        $q->execute();
                
                        foreach (data_kriteria() as $x) { //insert nilai alternatif ke setiap kriteria pada baris ke x
                            $_nilai = $worksheet->getCell($kriteria[$x[0]] . $baris)->getValue();
                            $_nilai = str_replace(',', '.', $_nilai);
                            $periode = date('Y'); // Ambil tahun saat ini sebagai nilai periode
                            $q = $koneksi->prepare("INSERT INTO nilai_alternatif VALUE ('$_next_id', '{$x[0]}', '$_nilai')");
                            $q->execute();
    
                                                    // Insert data periode ke dalam tabel histori
                            $q = $koneksi->prepare("INSERT INTO histori (alternatif, periode) VALUES ('$_next_id', '$periode')");
                            $q->execute();

                           
                        }

                        
                        $q = $koneksi->prepare("DELETE FROM tanggapan WHERE 1"); //hapus tanggapan
                        $q->execute();
                    }
                    header('Location: ./data-alternatif.php');
                } else {
                     ?>
                    
                    <hr>
                    <form enctype="multipart/form-data" method="post" id="form-upload-data-siswa">
                        <div class="custom-file mb-2 mr-sm-2">
                            <input class="custom-file-input" name="file" id="file" required type="file" accept=".xls,.xlsx">
                            <label class="custom-file-label" for="file">File Excel</label>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Kolom Nama Alternatif:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Kolom nama alternatif" value="A" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="baris" class="col-sm-3 col-form-label">Baris Mulai Data:</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" id="baris" name="baris" placeholder="Baris mulai data" value="2" required>
                            </div>
                        </div>
                        <input type="hidden" name="abaikan">
                        <?php $k = 66;
                        foreach (data_kriteria() as $x) { ?>
                            <div class="form-group row">
                                <label for="<?= $x[0] ?>" class="col-sm-3 col-form-label">Kolom <?= $x[1] ?>:</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="<?= $x[0] ?>" name="<?= $x[0] ?>" placeholder="Kolom alternatif <?= $x[1] ?>" value="<?= chr($k) ?>" required>
                                </div>
                            </div>
                        <?php $k++;
                        } ?>
                        <button class="btn btn-danger" id="upload" type="submit"><span class="fas fa-upload"></span> Upload</button>
                        <button type="button" onclick="location.href='alternatif.php'" class="btn btn-danger">Kembali</button>
                    </form>
                <?php }
            ?>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>

