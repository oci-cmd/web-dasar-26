<!-- views/audit/index.php - Tampilan Papan Jejak Rekam Aktivitas & Forensik -->
<div class="card">
    <div style="margin-bottom: 18px;">
        <h2 style="color: #0f2c59;">🛡️ Activity Audit Trail & Security Forensic Log</h2>
        <p style="font-size: 13px; color: #666;">Log ini mencatat seluruh peristiwa krusial sistem secara transparan dan bersifat Append-Only.</p>
    </div>

    <table style="width: 100%; border-collapse: collapse; font-size: 12.5px;">
        <thead>
            <tr style="background-color: #2c3e50; color: #fff; text-align: left;">
                <th style="padding: 8px;">ID Log</th>
                <th style="padding: 8px;">Waktu Kejadian</th>
                <th style="padding: 8px;">Pengguna</th>
                <th style="padding: 8px;">Modul</th>
                <th style="padding: 8px;">Aksi Peristiwa</th>
                <th style="padding: 8px;">Detail Transaksi</th>
                <th style="padding: 8px;">Alamat IP</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($logs)): ?>
                <tr><td colspan="7" style="text-align: center; padding: 15px; color: #999;">Belum ada catatan log aktivitas.</td></tr>
            <?php else: ?>
                <?php foreach ($logs as $l): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 8px; font-weight: bold;">#<?= (int)$l['id'] ?></td>
                        <td style="padding: 8px; color: #555;"><?= htmlspecialchars($l['created_at']) ?></td>
                        <td style="padding: 8px; font-weight: bold; color: #2980b9;"><?= htmlspecialchars($l['username']) ?></td>
                        <td style="padding: 8px;"><span style="background: #ecf0f1; padding: 2px 6px; border-radius: 3px;"><?= htmlspecialchars($l['module']) ?></span></td>
                        <td style="padding: 8px; font-weight: bold;"><?= htmlspecialchars($l['action']) ?></td>
                        <td style="padding: 8px;"><?= htmlspecialchars($l['details']) ?></td>
                        <td style="padding: 8px; font-family: monospace;"><?= htmlspecialchars($l['ip_address']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
