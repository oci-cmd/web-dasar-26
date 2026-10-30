<!-- views/auth/login.php - Antarmuka Login Enterprise -->
<div class="card" style="max-width: 480px; margin: 40px auto; padding: 32px; border-radius: 10px; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
    <h2 style="color: #0f2c59; margin-bottom: 6px; text-align: center;">🔐 Login Portal Enterprise</h2>
    <p style="color: #666; font-size: 14px; text-align: center; margin-bottom: 24px;">
        Silakan otentikasi identitas Anda untuk mengakses modul SPK Rekanan &amp; Audit Trail.
    </p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error" style="margin-bottom: 20px;">
            ⚠️ <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=auth&action=login">
        <div style="margin-bottom: 16px;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px;">Username:</label>
            <input type="text" name="username" required autofocus placeholder="Masukkan username..." 
                style="width: 100%; padding: 10px 14px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px;">Password:</label>
            <input type="password" name="password" required placeholder="Masukkan password..." 
                style="width: 100%; padding: 10px 14px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;">
        </div>

        <button type="submit" style="width: 100%; padding: 12px; background: #0f2c59; color: #fff; border: none; border-radius: 6px; font-weight: bold; font-size: 15px; cursor: pointer; transition: background 0.2s;">
            Masuk ke Sistem Enterprise
        </button>
    </form>

    <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #eee; font-size: 12px; color: #777;">
        <strong>Kredensial Default Percobaan:</strong>
        <ul style="margin: 6px 0 0 18px; line-height: 1.6;">
            <li>Admin: <code>admin</code> / password: <code>admin123</code></li>
            <li>Manager: <code>manager</code> / password: <code>manager123</code></li>
            <li>Staff: <code>staff</code> / password: <code>staff123</code></li>
        </ul>
    </div>
</div>
