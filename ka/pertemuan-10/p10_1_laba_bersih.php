<?php
// Lembar P10.1: Kalkulasi Laba Bersih Operasional (Murni PHP)
$pendapatanKotor = 85000000;
$bebanOperasional = 32000000;
$bebanPajak = 5500000;

$labaOperasional = $pendapatanKotor - $bebanOperasional;
$labaBersih = $labaOperasional - $bebanPajak;
$marginLaba = ($labaBersih / $pendapatanKotor) * 100;

echo "=== LAPORAN LABA BERSIH INDUSTRI ===\n";
echo "Pendapatan Kotor  : Rp " . number_format($pendapatanKotor, 0, ',', '.') . "\n";
echo "Beban Operasional : Rp " . number_format($bebanOperasional, 0, ',', '.') . "\n";
echo "Beban Pajak       : Rp " . number_format($bebanPajak, 0, ',', '.') . "\n";
echo "Laba Bersih Akhir : Rp " . number_format($labaBersih, 0, ',', '.') . "\n";
echo "Margin Keuntungan : " . round($marginLaba, 2) . "%\n";
