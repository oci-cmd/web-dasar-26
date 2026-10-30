<!-- views/create.php - Formulir Tambah Pengguna Baru -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengguna Baru</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Arial, sans-serif; margin: 30px; background-color: #f4f6f9; color: #333; }
        .card { max-width: 500px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
        h3 { color: #0f2c59; margin-bottom: 18px; border-bottom: 2px solid #0f2c59; padding-bottom: 8px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 6px; font-size: 13.5px; }
        input, select { width: 100%; padding: 9px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 13.5px; }
        input:focus, select:focus { border-color: #0f2c59; outline: none; }
        .btn-save { background: #0f2c59; color: white; border: none; padding: 10px 18px; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 13.5px; }
        .btn-save:hover { background: #184c78; }
        .btn-cancel { color: #7f8c8d; text-decoration: none; margin-left: 12px; font-size: 13.5px; }
    </style>
</head>
<body>
<div class="card">
    <h3>➕ Tambah Pengguna Baru</h3>
    <form method="POST" action="index.php?action=create">
        <div class="form-group">
            <label>Username Pengguna</label>
            <input type="text" name="username" placeholder="Contoh: user02" required>
        </div>
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" placeholder="Contoh: Budi Santoso" required>
        </div>
        <div class="form-group">
            <label>Peran / Role</label>
            <select name="role" required>
                <option value="Administrator">Administrator</option>
                <option value="Operator Staf">Operator Staf</option>
                <option value="Manajer Operasional">Manajer Operasional</option>
                <option value="Supervisor">Supervisor</option>
            </select>
        </div>
        <div class="form-group">
            <label>Email Resmi</label>
            <input type="email" name="email" placeholder="Contoh: budi@perusahaan.com" required>
        </div>
        <button type="submit" class="btn-save">💾 Simpan Pengguna</button>
        <a href="index.php" class="btn-cancel">Batal</a>
    </form>
</div>
</body>
</html>
