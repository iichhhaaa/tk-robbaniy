<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

// Check if user role is admin
if ($_SESSION['role'] !== 'admin') {
    // If user is not admin, redirect to dashboard page
    header('Location: ../dashboard-capen/index.php');
    exit();
}

// Include database connection file
include '../../../koneksi.php';

// SQL query to select all necessary data from pendaftaran, murid, ayah, and ibu tables
$sql = "SELECT 
            p.id AS pendaftaran_id, p.kode_pendaftaran, 
            m.id AS murid_id, m.nama AS nama_murid, m.nik AS nik_murid, m.tempat_lahir AS tempat_lahir_murid, 
            m.tanggal_lahir AS tanggal_lahir_murid, m.jenis_kelamin AS jenis_kelamin_murid, m.alamat AS alamat_murid,
            m.telepon AS telepon_murid, m.riwayat_kesehatan AS riwayat_kesehatan_murid, m.anak_ke AS anak_ke_murid,
            i.id AS ibu_id, i.nama AS nama_ibu, i.tempat_lahir AS tempat_lahir_ibu, i.tanggal_lahir AS tanggal_lahir_ibu, 
            i.nik AS nik_ibu, i.agama AS agama_ibu, i.pekerjaan AS pekerjaan_ibu, i.penghasilan AS penghasilan_ibu, 
            i.alamat AS alamat_ibu, i.telepon AS telepon_ibu,
            a.id AS ayah_id, a.nama AS nama_ayah, a.tempat_lahir AS tempat_lahir_ayah, a.tanggal_lahir AS tanggal_lahir_ayah,
            a.nik AS nik_ayah, a.agama AS agama_ayah, a.pekerjaan AS pekerjaan_ayah, a.penghasilan AS penghasilan_ayah, 
            a.alamat AS alamat_ayah, a.telepon AS telepon_ayah, 
            p.status AS status_pendaftaran
        FROM pendaftaran p
        JOIN murid m ON p.murid_id = m.id
        JOIN ayah a ON p.ayah_id = a.id
        JOIN ibu i ON p.ibu_id = i.id";

$result = $conn->query($sql);

// Check if there are any records to export
if ($result->num_rows > 0) {
    // Set HTTP headers to initiate CSV file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="laporan_data_pendaftaran.csv"');
    
    // Open output stream
    $output = fopen('php://output', 'w');
    
    // Write CSV column headers matching database fields
    fputcsv($output, array(
        'Pendaftaran ID', 'Kode Pendaftaran', 'Murid ID', 'Nama Murid', 'NIK Murid', 'Tempat Lahir Murid', 
        'Tanggal Lahir Murid', 'Jenis Kelamin Murid', 'Alamat Murid', 'Telepon Murid', 'Riwayat Kesehatan Murid', 
        'Anak Ke Murid', 'Ibu ID', 'Nama Ibu', 'Tempat Lahir Ibu', 'Tanggal Lahir Ibu', 'NIK Ibu', 
        'Agama Ibu', 'Pekerjaan Ibu', 'Penghasilan Ibu', 'Alamat Ibu', 'Telepon Ibu', 'Ayah ID', 
        'Nama Ayah', 'Tempat Lahir Ayah', 'Tanggal Lahir Ayah', 'NIK Ayah', 'Agama Ayah', 'Pekerjaan Ayah', 
        'Penghasilan Ayah', 'Alamat Ayah', 'Telepon Ayah', 'Status Pendaftaran'
    ));

    // Loop through each record and output CSV rows
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array(
            $row['pendaftaran_id'], $row['kode_pendaftaran'], $row['murid_id'], $row['nama_murid'], $row['nik_murid'], 
            $row['tempat_lahir_murid'], $row['tanggal_lahir_murid'], $row['jenis_kelamin_murid'], $row['alamat_murid'], 
            $row['telepon_murid'], $row['riwayat_kesehatan_murid'], $row['anak_ke_murid'], $row['ibu_id'], $row['nama_ibu'], 
            $row['tempat_lahir_ibu'], $row['tanggal_lahir_ibu'], $row['nik_ibu'], $row['agama_ibu'], $row['pekerjaan_ibu'], 
            $row['penghasilan_ibu'], $row['alamat_ibu'], $row['telepon_ibu'], $row['ayah_id'], $row['nama_ayah'], 
            $row['tempat_lahir_ayah'], $row['tanggal_lahir_ayah'], $row['nik_ayah'], $row['agama_ayah'], 
            $row['pekerjaan_ayah'], $row['penghasilan_ayah'], $row['alamat_ayah'], $row['telepon_ayah'], 
            $row['status_pendaftaran']
        ));
    }

    // Close the output stream
    fclose($output);
} else {
    // Show message in Indonesian if no data found to export
    echo "Tidak ada data yang dapat diekspor.";
}

// Close database connection
$conn->close();
exit();
?>