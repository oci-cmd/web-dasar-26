<?php
// Lembar P10.3: Tabel Penyusutan Garis Lurus Aset Tetap (Murni PHP)
$hargaPerolehan = 120000000; // Harga mesin pabrik
$nilaiResidu = 20000000;    // Nilai sisa di akhir periode
$umurEkonomis = 5;          // 5 Tahun masa manfaat

$penyusutanPerTahun = ($hargaPerolehan - $nilaiResidu) / $umurEkonomis;
$nilaiBuku = $hargaPerolehan;

echo "=== JADWAL PENYUSUTAN GARIS LURUS MESIN INDUSTRI ===\n";
echo "Harga Perolehan : Rp " . number_format($hargaPerolehan, 0, ',', '.') . "\n";
echo "Nilai Residu    : Rp " . number_format($nilaiResidu, 0, ',', '.') . "\n";
echo "Beban Depresiasi: Rp " . number_format($penyusutanPerTahun, 0, ',', '.') . "/tahun\n";
echo str_repeat("-", 50) . "\n";
echo sprintf("%-6s | %-16s | %-16s\n", "Tahun", "Beban Akumulasi", "Nilai Buku Akhir");
echo str_repeat("-", 50) . "\n";

$akumulasiBeban = 0;
for ($tahun = 1; $tahun <= $umurEkonomis; $tahun++) {
    $akumulasiBeban += $penyusutanPerTahun;
    $nilaiBuku -= $penyusutanPerTahun;
    echo sprintf("Thn %-2d | Rp %-13s | Rp %-13s\n", 
        $tahun, 
        number_format($akumulasiBeban, 0, ',', '.'), 
        number_format($nilaiBuku, 0, ',', '.')
    );
}
echo str_repeat("-", 50) . "\n";
