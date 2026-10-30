<!-- views/index.php - Tampilan Tabel Data dengan CSS Sederhana -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Data Pengguna - Latihan MVC</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Arial, sans-serif; margin: 30px; background-color: #f4f6f9; color: #333; }
        .card { background: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); max-width: 950px; margin: auto; }
        h2 { color: #0f2c59; margin-bottom: 5px; }
        p.desc { color: #666; font-size: 14px; margin-bottom: 20px; }
        .btn-add { display: inline-block; padding: 9px 16px; background-color: #0f2c59; color: #fff; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 13px; margin-bottom: 15px; }
        .btn-add:hover { background-color: #184c78; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        th, td { border: 1px solid #e0e0e0; padding: 10px 12px; text-align: left; }
        th { background-color: #0f2c59; color: #ffffff; font-weight: 600; }
        tr:nth-child(even) { background-color: #f9fbfd; }
        tr:hover { background-color: #f1f5f9; }
        .badge-role { background-color: #e8f4fd; color: #0f2c59; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .btn-edit { background: #f39c12; color: #fff; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold; margin-right: 5px; }
        .btn-delete { background: #e74c3c; color: #fff; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .btn-edit:hover { background: #d68910; }
        .btn-delete:hover { background: #c0392b; }
    </style>
</head>
<body>
<div class="card">
    <h2>👥 Manajemen Data Pengguna Sistem</h2>
    <p class="desc">Latihan Dasar MVC & OOP: Pengelolaan Data Pengguna / Operator (CRUD Lengkap Tanpa Login)</p>
    
    <a href="index.php?action=create" class="btn-add">➕ Tambah Pengguna Baru</a>
    
    <table>
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Peran / Role</th>
                <th>Email Resmi</th>
                <th style="width: 150px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr><td colspan="6" style="text-align: center; color: #999; padding: 20px;">Belum ada data pengguna.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach ($users as $u): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <!-- PENTING: htmlspecialchars() mencegah serangan XSS -->
                    <td><b><?= htmlspecialchars($u['username']) ?></b></td>
                    <td><?= htmlspecialchars($u['nama_lengkap']) ?></td>
                    <td><span class="badge-role"><?= htmlspecialchars($u['role']) ?></span></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td style="text-align: center;">
                        <a href="index.php?action=edit&id=<?= (int)$u['id'] ?>" class="btn-edit">✏️ Edit</a>
                        <a href="index.php?action=delete&id=<?= (int)$u['id'] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">🗑️ Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
