<?php

include_once './includes/api.php';

include_once './includes/session.php';
// if (!empty($_GET)) {
//     @$id = $_GET['id'];
//     $q = $koneksi->prepare("DELETE FROM bobot_kriteria WHERE kriteria_1='$id' OR kriteria_2='$id'");
//     $q->execute();
//     $q = $koneksi->prepare("DELETE FROM nilai_alternatif WHERE kriteria='$id'");
//     $q->execute();
//     $q = $koneksi->prepare("DELETE FROM kriteria WHERE id='$id'");
//     $q->execute();
//     header('Location: ./data-kriteria.php');
// } else header('Location: ./data-kriteria.php');


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Menggunakan parameterized query untuk mencegah serangan SQL Injection
    $q = $koneksi->prepare("DELETE FROM bobot_kriteria WHERE kriteria_1 = :id OR kriteria_2 = :id");
    $q->bindParam(':id', $id);
    $q->execute();

    $q = $koneksi->prepare("DELETE FROM nilai_alternatif WHERE kriteria = :id");
    $q->bindParam(':id', $id);
    $q->execute();

    $q = $koneksi->prepare("DELETE FROM kriteria WHERE id = :id");
    $q->bindParam(':id', $id);
    $q->execute();

    header('Location: ./data-kriteria.php');
} else {
    header('Location: ./data-kriteria.php');
}

?> 


<?php include_once 'footer.php'; ?> -->
