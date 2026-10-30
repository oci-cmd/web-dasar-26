<?php
// Lembar P10.7: Mini POS Kasir Terintegrasi (Fungsi, Array Multidimensi & Validasi JS)
declare(strict_types=1);

function hitungPotonganMember(string $tier, float $subtotal): float {
    return match (strtoupper($tier)) {
        "VIP" => $subtotal * 0.15, "GOLD" => $subtotal * 0.10, "SILVER" => $subtotal * 0.05, default => 0.0
    };
}

$faktur = "INV-" . date("Ymd") . "-884";
$pelanggan = ["nama" => "Hendro Wijaya", "tier" => "GOLD", "saldoDompet" => 5000000];
$keranjang = [
    ["kode" => "BRG-01", "nama" => "Headset Wireless ANC", "harga" => 850000, "qty" => 2],
    ["kode" => "BRG-02", "nama" => "Mouse Gaming Optical", "harga" => 450000, "qty" => 1],
    ["kode" => "BRG-03", "nama" => "USB-C Multiport Hub",  "harga" => 350000, "qty" => 3]
];

$totalKotor = 0.0;
foreach ($keranjang as $item) {
    $totalKotor += ($item['harga'] * $item['qty']);
}
$diskonMember = hitungPotonganMember($pelanggan['tier'], $totalKotor);
$totalTagihan = $totalKotor - $diskonMember;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Sistem Kasir Ritel Mandiri</title>
    <style>
        body { font-family: Segoe UI, Tahoma, sans-serif; background: #F1F5F9; padding: 25px; }
        .struk { max-width: 580px; margin: auto; background: #FFF; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); padding: 24px; }
        .header { text-align: center; border-bottom: 2px dashed #CBD5E1; padding-bottom: 12px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { padding: 8px 6px; text-align: left; font-size: 13.5px; border-bottom: 1px solid #E2E8F0; }
        th { background: #EEF2FF; color: #3730A3; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 6px; font-size: 14px; }
        .grand-total { font-size: 17px; font-weight: bold; color: #1E3A8A; border-top: 2px solid #CBD5E1; padding-top: 10px; }
        .btn-bayar { width: 100%; padding: 11px; background: #2563EB; color: #FFF; border: none; border-radius: 6px; font-size: 15px; cursor: pointer; margin-top: 12px; }
        .btn-bayar:hover { background: #1D4ED8; }
    </style>
</head>
<body>
    <div class="struk">
        <div class="header"><h3 style="margin:0; color:#1E3A8A;">Nusa Retail Digital POS</h3><small>Faktur: <?= $faktur ?> | Kasir Mandiri 01</small></div>
        <p style="font-size:13.5px;">Pelanggan: <strong><?= $pelanggan['nama'] ?></strong> (Tier: <span style="color:#B45309; font-weight:bold;"><?= $pelanggan['tier'] ?></span>)</p>
        <table>
            <thead><tr><th>Produk</th><th style="text-align:center;">Qty</th><th>Harga</th><th style="text-align:right;">Subtotal</th></tr></thead>
            <tbody>
                <?php foreach ($keranjang as $brg): $sub = $brg['harga'] * $brg['qty']; ?>
                <tr><td><?= $brg['nama'] ?></td><td align="center"><?= $brg['qty'] ?></td><td>Rp <?= number_format($brg['harga'], 0, ',', '.') ?></td><td align="right">Rp <?= number_format($sub, 0, ',', '.') ?></td></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="summary-row"><span>Total Kotor:</span><span>Rp <?= number_format($totalKotor, 0, ',', '.') ?></span></div>
        <div class="summary-row"><span>Diskon Member (<?= $pelanggan['tier'] ?>):</span><span style="color:#DC2626;">- Rp <?= number_format($diskonMember, 0, ',', '.') ?></span></div>
        <div class="summary-row grand-total"><span>Total Tagihan Akhir:</span><span id="txtTagihan">Rp <?= number_format($totalTagihan, 0, ',', '.') ?></span></div>
        <button class="btn-bayar" onclick="eksekusiPembayaran()">Konfirmasi & Bayar Tagihan</button>
    </div>
    <script>
        const TAGIHAN_AKHIR = <?= $totalTagihan ?>;
        const SALDO_PELANGGAN = <?= $pelanggan['saldoDompet'] ?>;
        function eksekusiPembayaran() {
            if (SALDO_PELANGGAN >= TAGIHAN_AKHIR) {
                let sisaSaldo = SALDO_PELANGGAN - TAGIHAN_AKHIR;
                alert("Pembayaran SUKSES!\nTotal: Rp " + TAGIHAN_AKHIR.toLocaleString('id-ID') + "\nSisa Saldo: Rp " + sisaSaldo.toLocaleString('id-ID'));
            } else {
                alert("GAGAL: Saldo tidak mencukupi untuk menyelesaikan transaksi!");
            }
        }
    </script>
</body>
</html>
