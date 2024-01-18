<?php

include_once './includes/api.php';
include_once './includes/fpdf/fpdf.php';

// Fungsi untuk mengambil dan mengatur data berdasarkan periode
function getDataForPDF($periode) {
    global $koneksi; // Gunakan variabel koneksi yang sudah didefinisikan

    $data = array();

    // Query untuk mendapatkan data histori berdasarkan periode
    $sql = "SELECT * FROM histori WHERE periode = :periode";
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':periode', $periode);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ambil nama alternatif berdasarkan id alternatif yang ada di tabel histori
    foreach ($data as $key => $value) {
        $id_alternatif = $value['alternatif'];
        $sql = "SELECT * FROM alternatif WHERE id = :id";
        $stmt = $koneksi->prepare($sql);
        $stmt->bindParam(':id', $id_alternatif);
        $stmt->execute();
        $data[$key]['alternatif'] = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Urutkan data berdasarkan hasil akhir dari yang terbesar ke terkecil
    usort($data, function ($a, $b) {
        if ($a['hasil_akhir'] == $b['hasil_akhir']) {
            return 0;
        }
        return ($a['hasil_akhir'] > $b['hasil_akhir']) ? -1 : 1;
    });

    // Berikan peringkat berdasarkan urutan hasil akhir
    $peringkat = 1;
    foreach ($data as $key => $value) {
        $data[$key]['peringkat'] = $peringkat;
        $peringkat++;
    }

    return $data;
}

// Fungsi untuk membuat file PDF
function createPDF($data) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Judul
    $pdf->Cell(170, 10, 'Laporan Pemilihan Pegawai Terbaik di Puskesmas Oesapa ' . $_GET['periode'], 0, 1, 'C');
    $pdf->Ln(10);

    // Header tabel
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 7, 'Peringkat', 1);
    $pdf->Cell(60, 7, 'Nama', 1);
    $pdf->Cell(40, 7, 'Periode', 1);
    $pdf->Cell(40, 7, 'Hasil Akhir', 1);
    $pdf->Ln();

    // Isi tabel
    foreach ($data as $row) {
        $pdf->Cell(30, 7, $row['peringkat'], 1);
        $pdf->Cell(60, 7, $row['alternatif']['nama'], 1);
        $pdf->Cell(40, 7, $row['periode'], 1);
        $pdf->Cell(40, 7, $row['hasil_akhir'], 1);
        $pdf->Ln();
    }

    // Output PDF
    $pdf->Output();
}

// Cek apakah parameter periode telah diset
if (isset($_GET['periode'])) {
    $periode = $_GET['periode'];

    // Mendapatkan data untuk PDF
    $dataForPDF = getDataForPDF($periode);

    // Membuat file PDF
    createPDF($dataForPDF);
} else {
    // Tampilkan pesan error jika parameter tidak ditemukan
    echo 'Parameter periode tidak ditemukan.';
}
?>
