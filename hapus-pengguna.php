<?php 
include './includes/session.php';
include './includes/api.php';


if (!empty($_GET['username'])) {
    $username = $_GET['username'];

    $q1 = $koneksi->prepare("DELETE FROM masuk WHERE pengguna = :username");
    $q1->bindParam(':username', $username);
    $q1->execute();

    $q2 = $koneksi->prepare("DELETE FROM pengguna WHERE username = :username");
    $q2->bindParam(':username', $username);

    if($q2->execute()){
        $_SESSION['pesan_sukses_hapus'] = true;
        header('Location: ./manajemen-pengguna.php');
        exit;
    }else{
        $_SESSION['pesan_gagal_hapus'] = true;
        header('Location: ./manajemen-pengguna.php');
        exit;
    }
}

// if (!empty($_GET)) {
//     @$username = $_GET['username'];
//     $q = $conn->prepare("DELETE FROM masuk WHERE pengguna='$username'");
//     $q->execute();
//     $q = $conn->prepare("DELETE FROM pengguna WHERE username='$username'");
//     $q->execute();
//     header('Location: ./manajemen-pengguna');
// } else header('Location: ./manajemen-pengguna');
?>
