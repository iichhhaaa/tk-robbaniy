<?php
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');
session_start();

// Cek login (sesuaikan dengan sistem Anda)
if (!isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit();
}

include '../../../koneksi.php';  // Koneksi ke database

// Ambil id pendaftaran dari parameter (misal GET atau POST)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die('ID pendaftaran tidak valid.');
}

// Query data pendaftaran beserta data murid, ibu, ayah
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

// Inisialisasi TCPDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TK ISLAM ROBBANIY');
$pdf->SetTitle('Bukti Pendaftaran');
$pdf->SetSubject('Bukti Pendaftaran TK');
$pdf->SetKeywords('TK, Pendaftaran, Bukti');

$pdf->SetMargins(15, 15, 15);
$pdf->SetHeaderData('', 0, 'TK ISLAM ROBBANIY', 'Jl. Margonda Raya Gg. Mawar No. 35, Kemiri Muka, Beji, Depok 16423 | 0217758103 | tkrobbaniy@yahoo.com', [0,0,0], [0,0,0]); // Black color
$pdf->setHeaderFont(['helvetica', '', 12]);
$pdf->setFooterFont(['helvetica', '', 10]);
$pdf->AddPage();

// Set font for the text
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Ln(20); // Space after header

// Title of the document (Centered)
$pdf->Cell(0, 10, 'BUKTI PENDATARAN', 0, 1, 'C');

// Set normal font for content
$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(10);

// Pendaftaran Data
$pdf->Cell(0, 10, 'NO PENDATARAN : ' . $data['kode_pendaftaran'], 0, 1);
$pdf->Cell(0, 10, 'NAMA : ' . $data['nama_murid'], 0, 1);
$pdf->Cell(0, 10, 'NIK : ' . $data['nik_murid'], 0, 1);
$pdf->Cell(0, 10, 'TEMPAT, TANGGAL LAHIR : ' . $data['tempat_lahir_murid'] . ', ' . $data['tanggal_lahir_murid'], 0, 1);
$pdf->Cell(0, 10, 'JENIS KELAMIN : ' . $data['jenis_kelamin_murid'], 0, 1);
$pdf->Cell(0, 10, 'ALAMAT : ' . $data['alamat_murid'], 0, 1);
$pdf->Ln(10);

// Parents Data Section
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'DATA ORANG TUA', 0, 1);
$pdf->SetFont('helvetica', '', 12);

$pdf->Cell(0, 10, 'NAMA IBU : ' . $data['nama_ibu'], 0, 1);
$pdf->Cell(0, 10, 'TELEPON IBU : ' . $data['telepon_ibu'], 0, 1);
$pdf->Cell(0, 10, 'NAMA AYAH : ' . $data['nama_ayah'], 0, 1);
$pdf->Cell(0, 10, 'TELEPON AYAH : ' . $data['telepon_ayah'], 0, 1);

$pdf->Ln(20);
$pdf->Cell(0, 10, 'Terima kasih telah melakukan pendaftaran di TK ISLAM ROBBANIY.', 0, 1);

// Output the PDF
$pdf->Output('bukti_pendaftaran.pdf', 'I');
?>
