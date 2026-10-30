<?php
$saldoAwal = 50000000;
$mutasi = [
    ['tgl' => '01/10', 'ket' => 'Penerimaan Piutang Usaha', 'jenis' => 'D', 'nominal' => 15000000],
    ['tgl' => '03/10', 'ket' => 'Pembelian ATK & Bahan Baku', 'jenis' => 'K', 'nominal' => 6500000],
    ['tgl' => '07/10', 'ket' => 'Pelunasan Faktur Penjualan', 'jenis' => 'D', 'nominal' => 22000000],
    ['tgl' => '10/10', 'ket' => 'Biaya Listrik & Air Pabrik', 'jenis' => 'K', 'nominal' => 3800000]
];
$totalDebit = 0; $totalKredit = 0;
foreach ($mutasi as $m) {
    if ($m['jenis'] === 'D') $totalDebit += $m['nominal'];
    else $totalKredit += $m['nominal'];
}
$saldoAkhir = $saldoAwal + $totalDebit - $totalKredit;
?>
<!DOCTYPE html><html><head><title>Buku Kas Finansial</title>
<style>
  body{font-family:sans-serif;padding:20px;background:#f1f5f9}
  .box{max-width:520px;background:#fff;padding:16px;border-radius:6px;box-shadow:0 1px 3px rgba(0,0,0,.1)}
  table{width:100%;border-collapse:collapse;margin:10px 0;font-size:13px}
  th,td{border:1px solid #cbd5e1;padding:6px;text-align:left}
  th{background:#e2e8f0}.d{color:#15803d;text-align:right}.k{color:#b91c1c;text-align:right}
  button{width:100%;padding:8px;background:#0f766e;color:#fff;border:none;border-radius:4px;cursor:pointer}
</style></head><body><div class="box">
  <h3>Buku Kas Operasional Industri</h3>
  <p>Saldo Awal Kas: <b>Rp <?= number_format($saldoAwal, 0, ',', '.') ?></b></p>
  <table>
    <tr><th>Tgl</th><th>Keterangan</th><th>Debet (Rp)</th><th>Kredit (Rp)</th></tr>
    <?php foreach ($mutasi as $row): ?>
      <tr>
        <td><?= $row['tgl'] ?></td><td><?= $row['ket'] ?></td>
        <td class="d"><?= $row['jenis'] === 'D' ? number_format($row['nominal'], 0, ',', '.') : '-' ?></td>
        <td class="k"><?= $row['jenis'] === 'K' ? number_format($row['nominal'], 0, ',', '.') : '-' ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
  <div style="background:#f8fafc;padding:8px;margin-bottom:10px;font-size:13px;">
    Total Masuk: Rp <?= number_format($totalDebit, 0, ',', '.') ?> | Keluar: Rp <?= number_format($totalKredit, 0, ',', '.') ?><br>
    <strong>Saldo Akhir Buku Kas: Rp <?= number_format($saldoAkhir, 0, ',', '.') ?></strong>
  </div>
  <button onclick="cetakLaporan()">Cetak Rekap Kas</button>
</div><script>
function cetakLaporan(){ alert('Mencetak rekapitulasi buku kas... Saldo Akhir: Rp <?= number_format($saldoAkhir, 0, ',', '.') ?>'); }
</script></body></html>
