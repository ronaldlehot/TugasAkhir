<?php
include_once './includes/api.php';
$q = $koneksi->prepare("DELETE FROM masuk WHERE id='{$_COOKIE['masuk']}'");
setcookie('masuk', '', time()-3600);
$q->execute();
header('Location: ./');