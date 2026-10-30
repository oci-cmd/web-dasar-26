<!-- views/supplier/index.php - Tampilan Data Rekanan & Hasil Perankingan SAW -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
        <div>
            <h2 style="color: #0f2c59;">📊 Evaluasi Kinerja Rekanan & Peringkat Rekomendasi (SPK SAW)</h2>
            <p style="font-size: 13px; color: #666;">Matriks Pembobotan: Kualitas (35%), Harga (25% - Cost), Pengiriman (25%), Layanan (15%)</p>
        </div>
        <?php if (in_array($_SESSION['user_role'], ['admin', 'manager'])): ?>
            <a href="index.php?controller=supplier&action=create" style="background: #0f2c59; color: #fff; padding: 8px 14px; text-decoration: none; border-radius: 5px; font-size: 13px; font-weight: bold;">➕ Daftarkan Rekanan</a>
        <?php endif; ?>
    </div>

    <table style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
        <thead>
            <tr style="background-color: #0f2c59; color: #fff; text-align: left;">
                <th style="padding: 10px;">Rank</th>
                <th style="padding: 10px;">Kode & Perusahaan</th>
                <th style="padding: 10px;">Kategori</th>
                <th style="padding: 10px;">Kualitas</th>
                <th style="padding: 10px;">Harga</th>
                <th style="padding: 10px;">Pengiriman</th>
                <th style="padding: 10px;">Layanan</th>
                <th style="padding: 10px;">Skor SAW (Vi)</th>
                <th style="padding: 10px;">Status Rekomendasi</th>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <th style="padding: 10px; text-align: center;">Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($suppliers)): ?>
                <tr><td colspan="10" style="text-align: center; padding: 20px; color: #999;">Belum ada data supplier yang terdaftar.</td></tr>
            <?php else: ?>
                <?php foreach ($suppliers as $idx => $s): ?>
                    <tr style="border-bottom: 1px solid #ddd; background: <?= ($idx % 2 === 0) ? '#ffffff' : '#f9fbfd' ?>;">
                        <td style="padding: 10px; font-weight: bold; color: #0f2c59;">#<?= $idx + 1 ?></td>
                        <td style="padding: 10px;">
                            <b><?= htmlspecialchars($s['kode_supplier']) ?></b><br>
                            <span style="color: #444;"><?= htmlspecialchars($s['nama_perusahaan']) ?></span>
                        </td>
                        <td style="padding: 10px;"><?= htmlspecialchars($s['kategori_produk']) ?></td>
                        <td style="padding: 10px;"><?= number_format($s['kriteria_kualitas'], 1) ?></td>
                        <td style="padding: 10px;">Rp <?= number_format($s['kriteria_harga'], 1) ?></td>
                        <td style="padding: 10px;"><?= number_format($s['kriteria_pengiriman'], 1) ?></td>
                        <td style="padding: 10px;"><?= number_format($s['kriteria_layanan'], 1) ?></td>
                        <td style="padding: 10px; font-weight: bold; color: #27ae60;"><?= number_format($s['saw_score'], 4) ?></td>
                        <td style="padding: 10px;">
                            <span style="padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; background: <?= ($s['saw_score'] >= 0.85) ? '#d4edda; color: #155724' : (($s['saw_score'] >= 0.70) ? '#fff3cd; color: #856404' : '#f8d7da; color: #721c24') ?>;">
                                <?= htmlspecialchars($s['saw_grade']) ?>
                            </span>
                        </td>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <td style="padding: 10px; text-align: center;">
                                <a href="index.php?controller=supplier&action=delete&id=<?= (int)$s['id'] ?>" onclick="return confirm('Konfirmasi: Hapus data rekanan ini?')" style="color: #e74c3c; text-decoration: none; font-weight: bold;">🗑️ Hapus</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
