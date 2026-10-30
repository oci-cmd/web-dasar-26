<!-- views/supplier/create.php - Formulir Pendaftaran Rekanan Baru -->
<div class="card" style="max-width: 700px; margin: 20px auto;">
    <h2 style="color: #0f2c59; margin-bottom: 6px;">➕ Pendaftaran Rekanan / Supplier Baru</h2>
    <p style="color: #666; font-size: 14px; margin-bottom: 20px;">
        Masukkan atribut rekanan dan nilai kriteria pendukung keputusan (SPK SAW).
    </p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=supplier&action=create">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Kode Supplier:</label>
                <input type="text" name="kode_supplier" required placeholder="Contoh: SUP-004" 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Nama Perusahaan Rekanan:</label>
                <input type="text" name="nama_perusahaan" required placeholder="Nama PT / CV Rekanan..." 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Kategori Produk / Jasa:</label>
            <input type="text" name="kategori_produk" required placeholder="Contoh: Logam Baja, Komponen Otomasi, dll..." 
                style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <h3 style="font-size: 14px; color: #0f2c59; border-bottom: 1px solid #eee; padding-bottom: 6px; margin: 20px 0 12px;">
            📊 Parameter Kriteria Evaluasi SPK SAW (Skala 1 - 100)
        </h3>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Kualitas Produk (Benefit):</label>
                <input type="number" step="0.01" min="1" max="100" name="kriteria_kualitas" required value="85" 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Efisiensi Harga (Cost):</label>
                <input type="number" step="0.01" min="1" max="100" name="kriteria_harga" required value="75" 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Ketepatan Waktu Kirim (Benefit):</label>
                <input type="number" step="0.01" min="1" max="100" name="kriteria_pengiriman" required value="90" 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Layanan / Responsivitas (Benefit):</label>
                <input type="number" step="0.01" min="1" max="100" name="kriteria_layanan" required value="80" 
                    style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Status Rekanan Awal:</label>
            <select name="status_rekanan" style="width: 100%; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="Evaluasi">Evaluasi</option>
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
            </select>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" style="padding: 10px 20px; background: #0f2c59; color: #fff; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">
                💾 Daftarkan Rekanan
            </button>
            <a href="index.php?controller=supplier&action=index" style="display: inline-block; padding: 10px 18px; background: #e0e0e0; color: #333; text-decoration: none; border-radius: 4px; font-weight: 600;">
                Batal
            </a>
        </div>
    </form>
</div>
