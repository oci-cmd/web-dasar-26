<!-- views/edit.php - Formulir Ubah Data Pengguna -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Pengguna</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Arial, sans-serif; margin: 30px; background-color: #f4f6f9; color: #333; }
        .card { max-width: 500px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
        h3 { color: #f39c12; margin-bottom: 18px; border-bottom: 2px solid #f39c12; padding-bottom: 8px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 6px; font-size: 13.5px; }
        input, select { width: 100%; padding: 9px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 13.5px; }
        .btn-update { background: #f39c12; color: white; border: none; padding: 10px 18px; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 13.5px; }
        .btn-update:hover { background: #d68910; }
        .btn-cancel { color: #7f8c8d; text-decoration: none; margin-left: 12px; font-size: 13.5px; }
    </style>
</head>
<body>
<div class="card">
    <h3>✏️ Edit Data Pengguna</h3>
    <form method="POST" action="index.php?action=edit&id=<?= (int)$user['id'] ?>">
        <div class="form-group">
            <label>Username Pengguna</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>
        </div>
        <div class="form-group">
            <label>Peran / Role</label>
            <select name="role" required>
                <option value="Administrator" <?= ($user['role'] === 'Administrator') ? 'selected' : '' ?>>Administrator</option>
                <option value="Operator Staf" <?= ($user['role'] === 'Operator Staf') ? 'selected' : '' ?>>Operator Staf</option>
                <option value="Manajer Operasional" <?= ($user['role'] === 'Manajer Operasional') ? 'selected' : '' ?>>Manajer Operasional</option>
                <option value="Supervisor" <?= ($user['role'] === 'Supervisor') ? 'selected' : '' ?>>Supervisor</option>
            </select>
        </div>
        <div class="form-group">
            <label>Email Resmi</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <button type="submit" class="btn-update">🔄 Simpan Perubahan</button>
        <a href="index.php" class="btn-cancel">Batal</a>
    </form>
</div>
</body>
</html>
