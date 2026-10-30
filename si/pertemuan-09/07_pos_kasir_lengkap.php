<?php
// Langkah 7 (P9.7): Point of Sale (POS) Kasir Lengkap & Validasi Stok Gudang
$noTransaksi  = "POS-NUSA-8821";
$namaProduk   = "Monitor LED 24 Inch IPS Frameless";
$hargaSatuan  = 1650000;
$stokGudang   = 8;
$persenPajak  = 0.11; // PPN 11%
$diskonMember = 0.05; // 5%
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>P9.7 - POS Kasir Interaktif Full Stack</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #e2e8f0; margin: 25px; }
        .pos-card { max-width: 480px; margin: auto; background: white; padding: 22px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h3 { color: #0d3b66; margin-top: 0; border-bottom: 2px solid #0d3b66; padding-bottom: 6px; }
        .form-row { margin: 12px 0; }
        label { font-size: 13px; font-weight: bold; color: #475569; display: block; margin-bottom: 4px; }
        input[type="number"] { width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 5px; box-sizing: border-box; }
        .summary-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 6px; font-size: 13px; }
        .summary-box div { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .total-row { font-size: 16px; font-weight: bold; color: #0d3b66; border-top: 1px dashed #cbd5e1; padding-top: 6px; }
        .btn-checkout { width: 100%; background: #0d3b66; color: white; padding: 10px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 12px; }
        .error-msg { color: #dc2626; font-size: 12px; display: none; margin-top: 3px; }
    </style>
</head>
<body>
    <div class="pos-card">
        <h3>KASIR RETAIL NUSAMART (<?= $noTransaksi ?>)</h3>
        <p>Barang: <strong><?= $namaProduk ?></strong><br>Harga: Rp <?= number_format($hargaSatuan, 0, ',', '.') ?> (Stok: <?= $stokGudang ?> Unit)</p>
        <div class="form-row">
            <label>Kuantitas Beli:</label>
            <input type="number" id="inputQty" value="1" min="1" max="<?= $stokGudang ?>" oninput="revisiKasir()">
            <div id="errorStok" class="error-msg">Perhatian: Kuantitas melebihi stok yang tersedia!</div>
        </div>
        <div class="form-row">
            <input type="checkbox" id="chkMember" onchange="revisiKasir()">
            <label for="chkMember" style="display:inline; font-weight:normal;">Aktifkan Diskon Member VIP (5%)</label>
        </div>
        <div class="summary-box">
            <div><span>Subtotal:</span><span id="lblSubtotal">Rp <?= number_format($hargaSatuan, 0, ',', '.') ?></span></div>
            <div><span>Potongan Diskon:</span><span id="lblDiskon">Rp 0</span></div>
            <div><span>PPN (11%):</span><span id="lblPajak">Rp <?= number_format($hargaSatuan * $persenPajak, 0, ',', '.') ?></span></div>
            <div class="total-row"><span>Total Akhir:</span><span id="lblTotal">Rp <?= number_format($hargaSatuan * (1 + $persenPajak), 0, ',', '.') ?></span></div>
        </div>
        <button class="btn-checkout" onclick="prosesSelesai()">SELESAIKAN TRANSAKSI</button>
    </div>
    <script>
        const HARGA = <?= $hargaSatuan ?>, STOK = <?= $stokGudang ?>, PPN = <?= $persenPajak ?>, DISKON_MEMBER = <?= $diskonMember ?>;
        function revisiKasir() {
            let qty = parseInt(document.getElementById('inputQty').value) || 0;
            const err = document.getElementById('errorStok');
            if (qty > STOK) { err.style.display = 'block'; qty = STOK; document.getElementById('inputQty').value = STOK; }
            else { err.style.display = 'none'; }
            let subtotal = qty * HARGA;
            let diskon = document.getElementById('chkMember').checked ? (subtotal * DISKON_MEMBER) : 0;
            let pajak = (subtotal - diskon) * PPN;
            let total = (subtotal - diskon) + pajak;
            document.getElementById('lblSubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('lblDiskon').textContent = 'Rp ' + diskon.toLocaleString('id-ID');
            document.getElementById('lblPajak').textContent = 'Rp ' + pajak.toLocaleString('id-ID');
            document.getElementById('lblTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        function prosesSelesai() { alert('Transaksi Kasir Sukses Disimpan ke Server!\n' + document.getElementById('lblTotal').textContent); }
    </script>
</body>
</html>
