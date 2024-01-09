<?php

include_once './includes/api.php';

include_once './includes/session.php';

//hapus data alternatif berdasarkan id dan hapus juga data nilai alternatif berdasarkan id alternatif
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Menggunakan parameterized query untuk mencegah serangan SQL Injection
    $q = $koneksi->prepare("DELETE FROM nilai_alternatif WHERE alternatif = :id");
    $q->bindParam(':id', $id);
    $q->execute();

    $q = $koneksi->prepare("DELETE FROM alternatif WHERE id = :id");
    $q->bindParam(':id', $id);
    $q->execute();

    header('Location: ./list-alternatif.php');
} else {
    header('Location: ./list-alternatif.php');
}

?>

<?php include_once 'footer.php'; ?> -->
