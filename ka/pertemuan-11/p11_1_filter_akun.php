<?php
// Lembar P11.1: Pemrosesan Parameter Kode Akun Buku Besar (Murni PHP)
$kodeAkun = $_GET['kode'] ?? '101';
$daftarAkun = [
    '101' => ['nama' => 'Kas Operasional', 'saldo' => 45000000],
    '102' => ['nama' => 'Bank Mandiri Utama', 'saldo' => 125000000],
    '103' => ['nama' => 'Piutang Usaha', 'saldo' => 38000000]
];

$akun = $daftarAkun[$kodeAkun] ?? ['nama' => 'Akun Tidak Ditemukan', 'saldo' => 0];

echo "=== SISTEM INFORMASI AKUN BUKU BESAR ===\n";
echo "Kode Parameter : {$kodeAkun}\n";
echo "Nama Rekening  : {$akun['nama']}\n";
echo "Saldo Berjalan : Rp " . number_format($akun['saldo'], 0, ',', '.') . "\n";
