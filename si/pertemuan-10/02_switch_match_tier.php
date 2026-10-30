<?php
// Lembar P10.2: Evaluasi Nilai Diskret Match & Switch (Ekspedisi Kilat)
$layanan = "EXPRESS";
$ongkirDasar = 25000;
$estimasiHari = match($layanan) {
    "INSTANT" => 1,
    "EXPRESS" => 2,
    "REGULER" => 4,
    default   => 7
};
$totalOngkir = ($layanan === "INSTANT") ? $ongkirDasar * 1.5 : $ongkirDasar;
echo "Layanan Ekspedisi : {$layanan}\n";
echo "Estimasi Tiba     : {$estimasiHari} Hari Kerja\n";
echo "Total Biaya Kirim : Rp " . number_format($totalOngkir, 0, ',', '.');
