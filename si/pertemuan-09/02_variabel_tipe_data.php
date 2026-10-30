<?php
// Langkah 2 (P9.2): Variabel & Tipe Data Produk
$skuBarang    = "PRD-NUSA-101";        // String
$namaBarang   = "Headset Wireless Pro"; // String
$hargaSatuan  = 350000;                // Integer
$ratingReview = 4.85;                  // Float
$stokTersedia = true;                  // Boolean

echo "Produk: " . $namaBarang . " (" . $skuBarang . ")<br>";
echo "Harga Satuan: Rp " . number_format($hargaSatuan, 0, ',', '.') . "<br>";
echo "Rating: " . $ratingReview . " | Status: " . ($stokTersedia ? "Tersedia" : "Habis") . "<br>";
var_dump($hargaSatuan);
