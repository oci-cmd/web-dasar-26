<?php
// Langkah 2 (P9.2): Variabel & Tipe Data Jurnal Transaksi
$kodeAkun    = "1101-KAS-BESAR";        // String
$namaItem    = "Kertas Faktur Continuous"; // String
$hargaSatuan = 125000;                  // Integer
$tarifPajak  = 0.11;                    // Float (PPN 11%)
$statusAktif = true;                    // Boolean

echo "Item: " . $namaItem . " (" . $kodeAkun . ")<br>";
echo "Harga Pokok: Rp " . number_format($hargaSatuan, 0, ',', '.') . "<br>";
echo "Tarif PPN: " . ($tarifPajak * 100) . "% | Status: " . ($statusAktif ? "Aktif" : "Non-Aktif") . "<br>";
var_dump($hargaSatuan);
