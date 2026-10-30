<?php error_reporting(0);
// Lembar P15.1: Ethical Security Sandbox & Deteksi Dini Payload Eksploitasi
$alert = ''; $tested_input = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tested_input = $_POST['payload'] ?? '';
    $detected = [];
    if (preg_match("/('|\"|--|;|OR|AND|UNION|SELECT)/i", $tested_input)) { $detected[] = "Pola Injeksi SQL (A03:2021-Injection)"; }
    if (preg_match("/(<script|javascript:|onerror=|onload=|<iframe)/i", $tested_input)) { $detected[] = "Pola Cross-Site Scripting (A03:XSS)"; }
    if (preg_match("/(\.\.\/|\.\.\\)/i", $tested_input)) { $detected[] = "Pola Path Traversal (A01:Broken Access Control)"; }
    if (!empty($detected)) {
        $alert = "<div style='background:#f8d7da;color:#842029;padding:8px;border-left:4px solid #dc3545;margin:8px 0;'><b>[PERINGATAN SIBER]</b> Payload Terdeteksi:<br>• " . implode("<br>• ", $detected) . "</div>";
    } else { $alert = "<div style='background:#d1e7dd;color:#0f5132;padding:8px;border-left:4px solid #198754;margin:8px 0;'><b>[BERSIH]</b> Input aman, tidak terdeteksi signature serangan umum.</div>"; }
}
?>
<!DOCTYPE html><html><head><title>P15.1 - Ethical Web Sandbox</title></head>
<body style="font-family:Arial,sans-serif;background:#f4f6f9;padding:15px;margin:0;">
<div style="max-width:520px;background:#fff;border:1px solid #ccd0d5;padding:15px;border-radius:6px;margin:auto;">
  <h3 style="color:#0d3b66;margin:0 0 6px;border-bottom:2px solid #0d3b66;padding-bottom:5px;">P15.1: Ethical Web Testing Sandbox</h3>
  <p style="font-size:12px;color:#555;margin:0 0 10px;">Pengujian Etis Pola Kerentanan Web (OWASP Top 10) pada Lingkungan Terisolasi.</p>
  <form method="POST" style="font-size:13px;">
    <label>Uji Payload Karakter Eksploitasi:</label><br>
    <input type="text" name="payload" value="<?= htmlspecialchars($tested_input) ?>" placeholder="Contoh: ' OR '1'='1 atau <script>alert(1)</script>" required style="width:100%;padding:6px;margin:5px 0 8px;box-sizing:border-box;"><br>
    <button type="submit" style="background:#0d3b66;color:#fff;border:none;padding:7px 14px;border-radius:4px;cursor:pointer;">Analisis Payload Sandbox</button>
  </form>
  <?= $alert ?>
  <div style="background:#f8f9fa;border:1px solid #e9ecef;padding:8px;margin-top:10px;font-size:11.5px;color:#495057;">
    <b>Pedoman Etis Security Testing:</b><br>
    1. Hanya lakukan pengujian pada sandbox localhost berizin resmi (Rules of Engagement).<br>
    2. Dilarang melakukan eksploitasi pada sistem produksi tanpa izin tertulis (UU ITE).
  </div></div></body></html>
