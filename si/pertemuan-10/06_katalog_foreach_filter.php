<?php
// Lembar P10.6: Looping Foreach Data Multi-dimensi & Filter Dinamis JavaScript
$inventarisHardware = [
    ["sku" => "HW-01", "nama" => "SSD NVMe 1TB", "kategori" => "Storage", "harga" => 1250000, "stok" => 8],
    ["sku" => "HW-02", "nama" => "RAM DDR5 32GB", "kategori" => "Memory",  "harga" => 1850000, "stok" => 12],
    ["sku" => "HW-03", "nama" => "Mechanical Keyboard", "kategori" => "Peripheral", "harga" => 750000, "stok" => 15],
    ["sku" => "HW-04", "nama" => "Monitor IPS 24 Inch", "kategori" => "Display", "harga" => 1950000, "stok" => 6]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Katalog Inventaris Komponen</title>
    <style>
        body { font-family: Arial, sans-serif; background: #F8FAFC; margin: 25px; }
        .kontainer { max-width: 800px; margin: auto; background: #FFF; border-radius: 8px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.08); }
        .cari-box input { width: 100%; box-sizing: border-box; padding: 9px; border: 1px solid #CBD5E1; border-radius: 4px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #E2E8F0; padding: 10px; text-align: left; }
        th { background: #3B82F6; color: #FFF; }
        tr:nth-child(even) { background: #F8FAFC; }
        .badge { background: #E0E7FF; color: #3730A3; padding: 3px 8px; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="kontainer">
        <h2>Inventaris Perangkat Keras Komputer</h2>
        <div class="cari-box"><input type="text" id="cariBarang" placeholder="Cari nama komponen..." onkeyup="filterKatalog()"></div>
        <table id="tabelBarang">
            <thead><tr><th>SKU</th><th>Komponen</th><th>Kategori</th><th>Harga</th><th>Stok</th></tr></thead>
            <tbody>
                <?php foreach ($inventarisHardware as $item): ?>
                <tr>
                    <td><strong><?= $item['sku'] ?></strong></td>
                    <td class="nama-item"><?= $item['nama'] ?></td>
                    <td><span class="badge"><?= $item['kategori'] ?></span></td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td align="center"><?= $item['stok'] ?> Unit</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        function filterKatalog() {
            let filter = document.getElementById("cariBarang").value.toLowerCase();
            let baris = document.getElementById("tabelBarang").getElementsByTagName("tbody")[0].getElementsByTagName("tr");
            for (let i = 0; i < baris.length; i++) {
                let kolom = baris[i].getElementsByClassName("nama-item")[0];
                let teks = kolom.textContent || kolom.innerText;
                baris[i].style.display = teks.toLowerCase().includes(filter) ? "" : "none";
            }
        }
    </script>
</body>
</html>
