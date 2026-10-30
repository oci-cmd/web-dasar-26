<?php
// Lembar P11.2: Validasi & Pemrosesan Voucher Kas Masuk/Keluar (Murni PHP)
$saldoAwal = 50000000;
$inputNominal = $_POST['nominal'] ?? 15000000;
$jenisMutasi = $_POST['jenis'] ?? 'D'; // D: Masuk, K: Keluar
$keterangan = trim($_POST['keterangan'] ?? 'Penerimaan Piutang Dagang');

$nominal = filter_var($inputNominal, FILTER_VALIDATE_FLOAT);
$status = 'Valid'; $pesanError = '';

if ($nominal === false || $nominal <= 0) {
    $status = 'Gagal'; $pesanError = 'Nominal transaksi harus angka lebih dari nol!';
} elseif ($jenisMutasi === 'K' && $nominal > $saldoAwal) {
    $status = 'Gagal'; $pesanError = 'Pengeluaran kas melebihi saldo kas tersedia!';
} else {
    $saldoAkhir = ($jenisMutasi === 'D') ? $saldoAwal + $nominal : $saldoAwal - $nominal;
}

echo "=== VERIFIKASI VOUCHER KAS OPERASIONAL ===\n";
echo "Keterangan Transaksi : {$keterangan}\n";
echo "Saldo Kas Semula     : Rp " . number_format($saldoAwal, 0, ',', '.') . "\n";
echo "Jenis Mutasi         : " . ($jenisMutasi === 'D' ? 'Debet (Masuk)' : 'Kredit (Keluar)') . "\n";
echo "Nominal Mutasi       : Rp " . number_format((float)$nominal, 0, ',', '.') . "\n";
if ($status === 'Valid') {
    echo "Status Verifikasi    : BERHASIL DIVALIDASI\n";
    echo "Saldo Kas Terbaru    : Rp " . number_format($saldoAkhir, 0, ',', '.') . "\n";
} else {
    echo "Status Verifikasi    : DITOLAK ({$pesanError})\n";
}
