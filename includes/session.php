<?php
session_start();

if (!isset($_COOKIE['masuk'])) {
    // If the user is not logged in, redirect to the login page
    header('Location: ./login.php');
    exit;
}

// Jika pengguna sudah login, lanjutkan dengan kode Anda...

