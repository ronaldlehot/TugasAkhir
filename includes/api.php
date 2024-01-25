<?php
$NAMA_DATABASE = 'tugas_spk3';
$USERNAME_DATABASE = 'root';
$PASSWORD_DATABASE = '';
$koneksi = new PDO("mysql:host=localhost;dbname=$NAMA_DATABASE", $USERNAME_DATABASE, $PASSWORD_DATABASE);
if (isset($_SESSION['tanggapan'])) $TANGGAPAN = $_SESSION['tanggapan'];
else {
    $q = $koneksi->prepare('SELECT UUID()');
    $q->execute();
    $uuid = @$q->fetchAll()[0][0];
    $TANGGAPAN = $uuid;
    setcookie('tanggapan', $uuid, time()+3600*24*30*12);
}

//make check session for login



function tanggapan() {
    global $TANGGAPAN, $koneksi;
    @$action = $_POST['action'];
    if ($action=='push') {
        $q = $koneksi->prepare("DELETE FROM tanggapan WHERE id='$TANGGAPAN'");
        $q->execute();
        $q = $koneksi->prepare("INSERT INTO tanggapan VALUE ('$TANGGAPAN', '{$_POST['tanggapan']}', '{$_POST['akurasi']}')");
        $q->execute();
    } else {
        $q = $koneksi->prepare("SELECT akurasi FROM tanggapan");
        $q->execute();
        if ($q->rowCount() > 0) {
            $data = $q->fetchAll();
            $j = 0;
            foreach($data as $x) $j += $x['akurasi'];
            return strval($j/count($data)).' % ('.strval(count($data)).' tanggapan)';
        }
        else return strval(100).' % (0 tanggapan)';
    }
}



function akses_pengguna($level = false) {
    $loggedInUser = pengguna(); // Simpan informasi pengguna ke dalam variabel

    if (!empty($loggedInUser)) {
        if ($level !== false) {
            // Memastikan $level adalah array atau dapat diiterasi
            if (!is_array($level)) {
                $level = [$level]; // Ubah ke dalam array tunggal
            }
            
            foreach ($level as $x) {
                if ($x == $loggedInUser['level']) {
                    return true; // Mengembalikan true jika level ditemukan
                }
            }
            
            return false; // Mengembalikan false jika tidak ada akses yang sesuai
        } else {
            // Jika $level tidak ditentukan, artinya akses diijinkan
            return true;
        }
    } else {
        // Jika pengguna tidak login, maka akses ditolak
        return false;
    }
}



function cek_valid_bobot() {
    global $koneksi;
    $q = $koneksi->prepare("SELECT * FROM kriteria WHERE bobot IS NULL");
    $q->execute();
    if ($q->rowCount() > 0) return false;
    return true;
}

function pengguna($pengguna=false) {
    global $koneksi;
    @$id = $_COOKIE['masuk'];
    if ($pengguna!=false) $q = $koneksi->prepare("SELECT * FROM pengguna p JOIN level l on p.level=l.id WHERE p.username='$pengguna'");
    else $q = $koneksi->prepare("SELECT * FROM masuk m JOIN pengguna p ON m.pengguna=p.username JOIN level l on p.level=l.id WHERE m.id='$id'");
    $q->execute();
    return @$q->fetchAll()[0];
}

function data_kriteria() {
    global $koneksi;
    $q = $koneksi->prepare('SELECT * FROM kriteria JOIN atribut ON kriteria.atribut=atribut.id');
    $q->execute();
    return @$q->fetchAll();
}

function data_kriteria_2() {
    global $koneksi;
    $q = $koneksi->prepare('SELECT * FROM kriteria');
    $q->execute();
    return @$q->fetchAll();
}

function data_pengguna() {
    global $koneksi;
    $q = $koneksi->prepare("SELECT * FROM pengguna p JOIN level l on p.level=l.id");
    $q->execute();
    return @$q->fetchAll();
}

function data_atribut() {
    global $koneksi;
    $q = $koneksi->prepare('SELECT * FROM atribut');
    $q->execute();
    return @$q->fetchAll();
}

function data_level() {
    global $koneksi;
    $q = $koneksi->prepare('SELECT * FROM level');
    $q->execute();
    return @$q->fetchAll();
}

function bobot_kriteria($k1, $k2) {
    if ($k1==$k2) return array('bobot' => '1/1', 'nilai' => 1);
    global $koneksi;
    $q = $koneksi->prepare("SELECT * FROM bobot_kriteria WHERE (kriteria_1='$k1' AND kriteria_2='$k2') OR (kriteria_1='$k2' AND kriteria_2='$k1')");
    $q->execute();
    @$data = $q->fetchAll()[0];
    if ($data) {
        @$bobot1 = explode('/', $data['bobot'])[0];
        @$bobot2 = explode('/', $data['bobot'])[1];
        @$n1 = $bobot1/$bobot2;
        @$n2 = $bobot2/$bobot1;
        if ($k1==$data['kriteria_1']) return array('bobot' => $data['bobot'], 'nilai' => $n1);
        else return array('bobot' => $bobot2.'/'.$bobot1, 'nilai' => $n2);
        return $data;
    } else return false;
}

function nilai_alternatif($a, $k) {
    global $koneksi;
    $q = $koneksi->prepare("SELECT * FROM nilai_alternatif WHERE alternatif='$a' AND kriteria='$k'");
    $q->execute();
    @$data = $q->fetchAll()[0][2];
    if ($data) return $data;
    else return 0;
}

function data_alternatif() {
    global $koneksi;
    $q = $koneksi->prepare("SELECT * FROM alternatif");
    $q->execute();
    @$data = $q->fetchAll();
    if ($data) return $data;
    else return array();
}





//fungsi untuk menampilkan periode sesuai dengan id alternatif
function getPeriode($id) {
    global $koneksi;
    $q = $koneksi->prepare("SELECT * FROM histori WHERE alternatif = :id");
    $q->bindParam(':id', $id);
    $q->execute();
    $data = $q->fetch();
    return $data['periode'];
}


//fungsi untuk menampilkan nama alternatif dan hasil akhir pada tabel histori
function getNamaAlternatif($id) {
    global $koneksi;
    $q = $koneksi->prepare("SELECT * FROM alternatif WHERE id = :id");
    $q->bindParam(':id', $id);
    $q->execute();
    $data = $q->fetch();
    return $data['nama'];
}