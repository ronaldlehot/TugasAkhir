<?php
include_once './includes/session.php';
include_once './includes/api.php';



//hapus data alternatif berdasarkan id dan hapus juga data nilai alternatif berdasarkan id alternatif
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Menggunakan parameterized query untuk mencegah serangan SQL Injection
    $q = $koneksi->prepare("DELETE FROM nilai_alternatif WHERE alternatif = :id");
    $q->bindParam(':id', $id);
    $q->execute();

    $q = $koneksi->prepare("DELETE FROM alternatif WHERE id = :id");
    $q->bindParam(':id', $id);
    

    if($q->execute()){
        $_SESSION['pesan_sukses_dihapus'] = true;
        header('Location: ./list-alternatif.php');
        exit;
    }else{
        $_SESSION['pesan_gagal_dihapus'] = true;
        header('Location: ./list-alternatif.php');
        exit;
    }

    header('Location: ./list-alternatif.php');
} else {
    header('Location: ./list-alternatif.php');
}

?>

<?php include_once 'footer.php'; ?> 
