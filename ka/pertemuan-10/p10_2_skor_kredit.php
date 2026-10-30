<?php
// Lembar P10.2: Evaluasi Skor Kredit & Suku Bunga Pinjaman (Murni PHP)
$namaDebitur = "PT Sumber Makmur Sentosa";
$pengajuanDana = 150000000;
$skorKredit = 780; // Skala 300 - 850

if ($skorKredit >= 800) {
    $tier = "Platinum"; $bungaTahunan = 0.06; $status = "Disetujui Penuh";
} elseif ($skorKredit >= 700) {
    $tier = "Gold"; $bungaTahunan = 0.085; $status = "Disetujui Standar";
} elseif ($skorKredit >= 600) {
    $tier = "Silver"; $bungaTahunan = 0.11; $status = "Disetujui Bersyarat";
} else {
    $tier = "High Risk"; $bungaTahunan = 0.15; $status = "Ditolak / Review Khusus";
}

$estimasiBungaTahun1 = $pengajuanDana * $bungaTahunan;
$totalKewajiban = $pengajuanDana + $estimasiBungaTahun1;

echo "=== ANALISIS RISIKO KREDIT KOMERSIAL ===\n";
echo "Debitur         : {$namaDebitur}\n";
echo "Plafon Pinjaman : Rp " . number_format($pengajuanDana, 0, ',', '.') . "\n";
echo "Skor Kelayakan  : {$skorKredit} (Tier: {$tier})\n";
echo "Suku Bunga/Thn  : " . ($bungaTahunan * 100) . "%\n";
echo "Beban Bunga Th 1: Rp " . number_format($estimasiBungaTahun1, 0, ',', '.') . "\n";
echo "Total Tagihan   : Rp " . number_format($totalKewajiban, 0, ',', '.') . "\n";
echo "Status Evaluasi : {$status}\n";
