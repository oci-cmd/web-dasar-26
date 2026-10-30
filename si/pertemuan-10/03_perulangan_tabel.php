<?php
// Lembar P10.3: Perulangan For Loop dalam Tabel Angsuran Finansial
$pinjamanPokok = 6000000;
$tenorBulan = 6;
$cicilanPerBulan = $pinjamanPokok / $tenorBulan;
?>
<!DOCTYPE html>
<html lang="id">
<head><title>Simulasi Angsuran Finansial</title></head>
<body>
    <h3>Jadwal Angsuran Pinjaman Modal Usaha</h3>
    <table border="1" cellpadding="6" cellspacing="0">
        <tr bgcolor="#F2F4F8"><th>Bulan Ke</th><th>Nominal Angsuran</th><th>Sisa Pokok</th></tr>
        <?php for ($i = 1; $i <= $tenorBulan; $i++): 
            $sisaPokok = $pinjamanPokok - ($i * $cicilanPerBulan); ?>
            <tr>
                <td align="center"><?= $i ?></td>
                <td>Rp <?= number_format($cicilanPerBulan, 0, ',', '.') ?></td>
                <td>Rp <?= number_format($sisaPokok, 0, ',', '.') ?></td>
            </tr>
        <?php endfor; ?>
    </table>
</body>
</html>
