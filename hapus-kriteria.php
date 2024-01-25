<?php
ob_start();
include_once './includes/session.php';
include_once './includes/api.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Menggunakan parameterized query untuk mencegah serangan SQL Injection
    $q1 = $koneksi->prepare("DELETE FROM bobot_kriteria WHERE kriteria_1 = :id OR kriteria_2 = :id");
    $q1->bindParam(':id', $id);
    $q1->execute();

    $q2 = $koneksi->prepare("DELETE FROM nilai_alternatif WHERE kriteria = :id");
    $q2->bindParam(':id', $id);
    $q2->execute();

    $q3 = $koneksi->prepare("DELETE FROM kriteria WHERE id = :id");
    $q3->bindParam(':id', $id);
    
    if ($q3->execute()) {
        $_SESSION['pesan_sukses_dihapus'] = true;
        header('Location: ./data-kriteria.php');
        exit;
    } else {
        $_SESSION['pesan_gagal_dihapus'] = true;
        header('Location: ./data-kriteria.php');
        exit;
    }
} else {
    header('Location: ./data-kriteria.php');
    exit;
}
ob_end_flush();
?>
<?php include_once 'footer.php'; ?>
