<?php
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit();
}

include '../../../koneksi.php';  // Connect to the database

// Get the registration ID from the parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die('ID pendaftaran tidak valid.'); // Invalid registration ID
}

// Query registration data along with student, mother, and father data
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
    $stmt->bind_param("i", $id); // Bind ID as integer
    $stmt->execute();            // Execute the query
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        die('Data pendaftaran tidak ditemukan.'); // Registration data not found
    }
    $data = $result->fetch_assoc();
    $stmt->close();
} else {
    die('Query error: ' . $conn->error); // Error executing query
}

// Helper function to format a label and value row
function addRow($pdf, $label, $value) {
    $pdf->Cell(55, 8, $label, 0, 0);            // Label column
    $pdf->Cell(0, 8, ': ' . $value, 0, 1);      // Value column
}

// Initialize TCPDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TK ISLAM ROBBANIY');
$pdf->SetTitle('Bukti Pendaftaran');
$pdf->SetSubject('Bukti Pendaftaran TK');
$pdf->SetKeywords('TK, Pendaftaran, Bukti');

// Disable default header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set margin and create a new page
$pdf->SetMargins(20, 10, 20);
$pdf->AddPage();

// ===== HEADER SECTION =====
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 7, 'TK ISLAM ROBBANIY', 0, 1, 'C');

$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(0, 6, 'Jl. Margonda Raya Gg. Mawar No. 35, Kemiri Muka, Beji, Depok 16423', 0, 1, 'C');
$pdf->Cell(0, 6, 'Telepon: 0217758103 | Email: tkrobbaniy@yahoo.com', 0, 1, 'C');

// Draw horizontal line
$pdf->Ln(3);
$y = $pdf->GetY();
$pdf->Line(20, $y, $pdf->getPageWidth() - 20, $y);
$pdf->Ln(5);

// ===== TITLE SECTION =====
$pdf->SetFont('helvetica', 'B', 13);
$pdf->Cell(0, 10, 'BUKTI PENDAFTARAN', 0, 1, 'C');
$pdf->Ln(5);

// ===== STUDENT DATA =====
$pdf->SetFont('helvetica', '', 12);
addRow($pdf, 'No Pendaftaran', $data['kode_pendaftaran']);
addRow($pdf, 'Nama', $data['nama_murid']);
addRow($pdf, 'Tempat, Tanggal Lahir', $data['tempat_lahir_murid'] . ', ' . date('d-m-Y', strtotime($data['tanggal_lahir_murid'])));
addRow($pdf, 'NIK', $data['nik_murid']);
addRow($pdf, 'Jenis Kelamin', $data['jenis_kelamin_murid']);

// Use MultiCell for long address text to ensure proper formatting
$pdf->Cell(55, 8, 'Alamat', 0, 0);
$pdf->MultiCell(0, 8, ': ' . $data['alamat_murid'], 0, 'L', 0, 1);

$pdf->Ln(10);

// ===== PARENT DATA =====
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 8, 'DATA ORANG TUA', 0, 1);

$pdf->SetFont('helvetica', '', 12);
addRow($pdf, 'Nama Ibu', $data['nama_ibu']);
addRow($pdf, 'Telepon Ibu', $data['telepon_ibu']);
addRow($pdf, 'Nama Ayah', $data['nama_ayah']);
addRow($pdf, 'Telepon Ayah', $data['telepon_ayah']);

$pdf->Ln(15);

date_default_timezone_set('Asia/Jakarta');
$pdf->SetFont('helvetica', 'I', 9);
$pdf->Cell(0, 10, 'Dicetak pada: ' . date('d-m-Y H:i:s'), 0, 0, 'R');


// Output PDF to browser
$pdf->Output('bukti_pendaftaran.pdf', 'I');

?>