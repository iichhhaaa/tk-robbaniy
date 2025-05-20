<?php
session_start();

// Include the PhpSpreadsheet autoloader
require '../../../vendor/autoload.php';  // Correct path to autoload.php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    // If not logged in, redirect to login page
    header('Location: ../../../login.php');
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    // If not logged in or role is not admin, redirect to dashboard
    header('Location: ../dashboard-capen/index.php');
    exit();
}

// Include database connection
include '../../../koneksi.php';

// Query to get all the data including pendaftaran, murid, ayah, ibu
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

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set column headings
$sheet->setCellValue('A1', 'Pendaftaran ID')
      ->setCellValue('B1', 'Kode Pendaftaran')
      ->setCellValue('C1', 'Murid ID')
      ->setCellValue('D1', 'Nama Murid')
      ->setCellValue('E1', 'NIK Murid')
      ->setCellValue('F1', 'Tempat Lahir Murid')
      ->setCellValue('G1', 'Tanggal Lahir Murid')
      ->setCellValue('H1', 'Jenis Kelamin Murid')
      ->setCellValue('I1', 'Alamat Murid')
      ->setCellValue('J1', 'Telepon Murid')
      ->setCellValue('K1', 'Riwayat Kesehatan Murid')
      ->setCellValue('L1', 'Anak Ke Murid')
      ->setCellValue('M1', 'Ibu ID')
      ->setCellValue('N1', 'Nama Ibu')
      ->setCellValue('O1', 'Tempat Lahir Ibu')
      ->setCellValue('P1', 'Tanggal Lahir Ibu')
      ->setCellValue('Q1', 'NIK Ibu')
      ->setCellValue('R1', 'Agama Ibu')
      ->setCellValue('S1', 'Pekerjaan Ibu')
      ->setCellValue('T1', 'Penghasilan Ibu')
      ->setCellValue('U1', 'Alamat Ibu')
      ->setCellValue('V1', 'Telepon Ibu')
      ->setCellValue('W1', 'Ayah ID')
      ->setCellValue('X1', 'Nama Ayah')
      ->setCellValue('Y1', 'Tempat Lahir Ayah')
      ->setCellValue('Z1', 'Tanggal Lahir Ayah')
      ->setCellValue('AA1', 'NIK Ayah')
      ->setCellValue('AB1', 'Agama Ayah')
      ->setCellValue('AC1', 'Pekerjaan Ayah')
      ->setCellValue('AD1', 'Penghasilan Ayah')
      ->setCellValue('AE1', 'Alamat Ayah')
      ->setCellValue('AF1', 'Telepon Ayah')
      ->setCellValue('AG1', 'Status Pendaftaran');

// Output data rows for all pendaftaran
$rowNum = 2;  // Start from the second row for data
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNum, $row['pendaftaran_id'])
          ->setCellValue('B' . $rowNum, $row['kode_pendaftaran'])
          ->setCellValue('C' . $rowNum, $row['murid_id'])
          ->setCellValue('D' . $rowNum, $row['nama_murid'])
          ->setCellValue('E' . $rowNum, $row['nik_murid'])
          ->setCellValue('F' . $rowNum, $row['tempat_lahir_murid'])
          ->setCellValue('G' . $rowNum, $row['tanggal_lahir_murid'])
          ->setCellValue('H' . $rowNum, $row['jenis_kelamin_murid'])
          ->setCellValue('I' . $rowNum, $row['alamat_murid'])
          ->setCellValue('J' . $rowNum, $row['telepon_murid'])
          ->setCellValue('K' . $rowNum, $row['riwayat_kesehatan_murid'])
          ->setCellValue('L' . $rowNum, $row['anak_ke_murid'])
          ->setCellValue('M' . $rowNum, $row['ibu_id'])
          ->setCellValue('N' . $rowNum, $row['nama_ibu'])
          ->setCellValue('O' . $rowNum, $row['tempat_lahir_ibu'])
          ->setCellValue('P' . $rowNum, $row['tanggal_lahir_ibu'])
          ->setCellValue('Q' . $rowNum, $row['nik_ibu'])
          ->setCellValue('R' . $rowNum, $row['agama_ibu'])
          ->setCellValue('S' . $rowNum, $row['pekerjaan_ibu'])
          ->setCellValue('T' . $rowNum, $row['penghasilan_ibu'])
          ->setCellValue('U' . $rowNum, $row['alamat_ibu'])
          ->setCellValue('V' . $rowNum, $row['telepon_ibu'])
          ->setCellValue('W' . $rowNum, $row['ayah_id'])
          ->setCellValue('X' . $rowNum, $row['nama_ayah'])
          ->setCellValue('Y' . $rowNum, $row['tempat_lahir_ayah'])
          ->setCellValue('Z' . $rowNum, $row['tanggal_lahir_ayah'])
          ->setCellValue('AA' . $rowNum, $row['nik_ayah'])
          ->setCellValue('AB' . $rowNum, $row['agama_ayah'])
          ->setCellValue('AC' . $rowNum, $row['pekerjaan_ayah'])
          ->setCellValue('AD' . $rowNum, $row['penghasilan_ayah'])
          ->setCellValue('AE' . $rowNum, $row['alamat_ayah'])
          ->setCellValue('AF' . $rowNum, $row['telepon_ayah'])
          ->setCellValue('AG' . $rowNum, $row['status_pendaftaran']);
    $rowNum++;
}

// Create the Excel file and force download
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="pendaftaran_complete.xlsx"');
$writer->save('php://output');

// Close the connection
$conn->close();
exit();
?>
