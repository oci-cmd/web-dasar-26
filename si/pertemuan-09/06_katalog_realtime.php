<?php
// Langkah 6 (P9.6): Tabel Inventaris Dinamis & Kalkulasi Pilihan Produk
$katalog = [
    ["id" => 1, "nama" => "Mouse Wireless Silent", "harga" => 150000],
    ["id" => 2, "nama" => "Webcam Full HD 1080p",  "harga" => 350000],
    ["id" => 3, "nama" => "USB Hub Multiport 4in1", "harga" => 200000]
];
$pajakPersen = 0.11;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>P9.6 - HTML + CSS + JS + PHP</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f1f5f9; padding: 25px; }
        .container { max-width: 550px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
        table { width: 100%; border-collapse: collapse; margin: 12px 0; }
        th, td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; font-size: 13px; }
        th { background: #f8fafc; color: #0d3b66; }
        .panel-total { background: #e0f2fe; padding: 12px; border-radius: 6px; text-align: right; font-weight: bold; }
        button { background: #0d3b66; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h3>Pilih Komoditas Belanja</h3>
        <table>
            <tr><th>Produk</th><th>Harga</th><th>Aksi</th></tr>
            <?php foreach ($katalog as $item) : ?>
            <tr>
                <td><?= $item['nama'] ?></td>
                <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td><button onclick="pilihBarang('<?= $item['nama'] ?>', <?= $item['harga'] ?>)">Pilih</button></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="panel-total">
            Item Terpilih: <span id="labelBarang">-</span><br>
            Total Bayar (+PPN 11%): <span id="labelTotal">Rp 0</span>
        </div>
    </div>
    <script>
        const PPN = <?= $pajakPersen ?>;
        function pilihBarang(nama, harga) {
            let total = harga + (harga * PPN);
            document.getElementById('labelBarang').textContent = nama;
            document.getElementById('labelTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
</body>
</html>
