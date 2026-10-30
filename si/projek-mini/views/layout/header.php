<!-- views/layout/header.php - Tata Letak Antarmuka Master Enterprise -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise ERP & DSS Portal - S1 Sistem Informasi</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f6f9; color: #333; }
        .navbar { background-color: #0f2c59; color: #fff; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .navbar-brand { font-size: 18px; font-weight: bold; letter-spacing: 0.5px; }
        .navbar-nav a { color: #d8e2dc; text-decoration: none; margin-left: 18px; font-size: 14px; font-weight: 500; }
        .navbar-nav a:hover { color: #ffffff; text-decoration: underline; }
        .container { max-width: 1200px; margin: 25px auto; padding: 0 20px; }
        .badge-role { background-color: #e67e22; color: #fff; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .alert { padding: 12px 18px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .card { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); padding: 22px; margin-bottom: 25px; }
    </style>
</head>
<body>
<div class="navbar">
    <div class="navbar-brand">🏢 STMIK IKMI CIREBON :: Enterprise Information System</div>
    <div class="navbar-nav">
        <?php if (isset($_SESSION['user_id'])): ?>
            <span>👤 <?= htmlspecialchars($_SESSION['nama_lengkap']) ?> <span class="badge-role"><?= strtoupper($_SESSION['user_role']) ?></span></span>
            <a href="index.php?controller=supplier&action=index">📊 Data Rekanan & SPK</a>
            <?php if (in_array($_SESSION['user_role'], ['admin', 'manager'])): ?>
                <a href="index.php?controller=supplier&action=create">➕ Tambah Rekanan</a>
            <?php endif; ?>
            <a href="index.php?controller=audit&action=index">🛡️ Audit Trail Log</a>
            <a href="index.php?controller=auth&action=logout" style="color: #ff9999;">🚪 Logout</a>
        <?php else: ?>
            <a href="index.php?controller=auth&action=login">🔑 Login Portal</a>
        <?php endif; ?>
    </div>
</div>
<div class="container">
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success">✅ <?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>
