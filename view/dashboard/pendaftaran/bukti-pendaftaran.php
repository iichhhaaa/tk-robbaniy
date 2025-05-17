<?php
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');
session_start();

// Cek login
if (!isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit();
}

include '../../../koneksi.php';  // Koneksi ke database

// Ambil id pendaftaran dari parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die('ID pendaftaran tidak valid.');
}

// Query data pendaftaran
$sql = "SELECT 
            p.kode_pendaftaran, p.berkas,
            m.nama AS nama_murid, m.nik AS nik_murid, m.tempat_lahir AS tempat_lahir_murid, m.tanggal_lahir AS tanggal_lahir_murid, m.jenis_kelamin AS jenis_kelamin_murid, m.alamat AS alamat_murid,
            i.nama AS nama_ibu, i.telepon AS telepon_ibu,
            a.nama AS nama_ayah, a.telepon AS telepon_ayah
        FROM tk_robbaniy.pendaftaran p
        LEFT JOIN tk_robbaniy.murid m ON p.murid_id = m.id
        LEFT JOIN tk_robbaniy.ibu i ON p.ibu_id = i.id
        LEFT JOIN tk_robbaniy.ayah a ON p.ayah_id = a.id
        WHERE p.id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        die('Data pendaftaran tidak ditemukan.');
    }
    $data = $result->fetch_assoc();
    $stmt->close();
} else {
    die('Query error: ' . $conn->error);
}

// Fungsi bantu untuk merapikan format kolom (label dan nilai)
function addRow($pdf, $label, $value) {
    $pdf->Cell(55, 8, $label, 0, 0);  // Kolom label
    $pdf->Cell(0, 8, ': ' . $value, 0, 1); // Kolom nilai
}

// Inisialisasi TCPDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TK ISLAM ROBBANIY');
$pdf->SetTitle('Bukti Pendaftaran');
$pdf->SetSubject('Bukti Pendaftaran TK');
$pdf->SetKeywords('TK, Pendaftaran, Bukti');

// Nonaktifkan header dan footer bawaan
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Atur margin dan buat halaman baru
$pdf->SetMargins(20, 10, 20);
$pdf->AddPage();

// ===== HEADER =====
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 7, 'TK ISLAM ROBBANIY', 0, 1, 'C');

$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 6, 'Jl. Margonda Raya Gg. Mawar No. 35, Kemiri Muka, Beji, Depok 16423', 0, 1, 'C');
$pdf->Cell(0, 6, 'Telepon: 0217758103 | Email: tkrobbaniy@yahoo.com', 0, 1, 'C');

// Garis horizontal
$pdf->Ln(3);
$y = $pdf->GetY();
$pdf->Line(20, $y, $pdf->getPageWidth() - 20, $y);
$pdf->Ln(5);

// ===== JUDUL =====
$pdf->SetFont('helvetica', 'B', 13);
$pdf->Cell(0, 10, 'BUKTI PENDAFTARAN', 0, 1, 'C');
$pdf->Ln(5);

// ===== DATA MURID =====
$pdf->SetFont('helvetica', '', 12);
addRow($pdf, 'No Pendaftaran', $data['kode_pendaftaran']);
addRow($pdf, 'Nama', $data['nama_murid']);
addRow($pdf, 'NIK', $data['nik_murid']);
addRow($pdf, 'Tempat, Tanggal Lahir', $data['tempat_lahir_murid'] . ', ' . date('d-m-Y', strtotime($data['tanggal_lahir_murid'])));
addRow($pdf, 'Jenis Kelamin', $data['jenis_kelamin_murid']);

// Untuk alamat gunakan MultiCell agar teks panjang tetap rapi
$pdf->Cell(55, 8, 'Alamat', 0, 0);
$pdf->MultiCell(0, 8, ': ' . $data['alamat_murid'], 0, 'L', 0, 1);

$pdf->Ln(10);

// ===== DATA ORANG TUA =====
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 8, 'DATA ORANG TUA', 0, 1);

$pdf->SetFont('helvetica', '', 12);
addRow($pdf, 'Nama Ibu', $data['nama_ibu']);
addRow($pdf, 'Telepon Ibu', $data['telepon_ibu']);
addRow($pdf, 'Nama Ayah', $data['nama_ayah']);
addRow($pdf, 'Telepon Ayah', $data['telepon_ayah']);

$pdf->Ln(15);

// Output PDF ke browser
$pdf->Output('bukti_pendaftaran.pdf', 'I');
?>
