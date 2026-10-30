<?php
// Lembar P10.4: Fungsi Modular hitungPajakGaji dengan Type Hinting & UI Card
declare(strict_types=1);

function hitungPajakGaji(float $gajiKotor, float $tarifPajak = 0.05): float {
    if ($gajiKotor <= 4500000) return 0.0;
    return $gajiKotor * $tarifPajak;
}

$namaKaryawan = "Ahmad Zaelani";
$divisi = "Backend Developer";
$gajiPokok = 7800000.0;
$pajakPPh21 = hitungPajakGaji($gajiPokok);
$gajiBersih = $gajiPokok - $pajakPPh21;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji Karyawan</title>
    <style>
        body { font-family: Arial, sans-serif; background: #F1F5F9; padding: 20px; }
        .card { max-width: 400px; margin: auto; background: #FFF; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 20px; }
        .title { color: #1E3A8A; font-size: 18px; border-bottom: 2px solid #3B82F6; padding-bottom: 8px; margin-bottom: 15px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; }
        .total { font-weight: bold; color: #047857; border-top: 1px dashed #CBD5E1; padding-top: 8px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="title">Rincian Slip Gaji Karyawan</div>
        <div class="row"><span>Nama / Divisi:</span><strong><?= $namaKaryawan ?> (<?= $divisi ?>)</strong></div>
        <div class="row"><span>Gaji Bruto:</span><span>Rp <?= number_format($gajiPokok, 0, ',', '.') ?></span></div>
        <div class="row"><span>Pajak PPh 21 (5%):</span><span>Rp <?= number_format($pajakPPh21, 0, ',', '.') ?></span></div>
        <div class="row total"><span>Gaji Bersih (Take Home):</span><span>Rp <?= number_format($gajiBersih, 0, ',', '.') ?></span></div>
    </div>
</body>
</html>
