<?php error_reporting(0);
// Lembar P14.2: Pertahanan Ganda Input/Output (PDO Prepared Statement & Anti-XSS)
$pdo = new PDO('sqlite::memory:'); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("CREATE TABLE incident_report (id INTEGER PRIMARY KEY, ticket TEXT, severity TEXT, desc TEXT);");
$pdo->exec("INSERT INTO incident_report VALUES (1, 'TCK-101', 'High', 'Percobaan Brute Force port 443')");
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $t = trim($_POST['ticket'] ?? ''); $s = trim($_POST['sev'] ?? 'Medium'); $d = trim($_POST['desc'] ?? '');
    if ($t !== '' && $d !== '') {
        $stmt = $pdo->prepare("INSERT INTO incident_report (ticket, severity, desc) VALUES (:t, :s, :d)");
        $stmt->execute([':t' => $t, ':s' => $s, ':d' => $d]); // Parameter Binding Anti-SQLi
        $msg = "<span style='color:#0f5132;font-weight:bold;'>Insiden Berhasil Dicatat Secara Aman!</span>";
    }
}
$rows = $pdo->query("SELECT * FROM incident_report ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><head><title>P14.2 - Secure Data Defense</title></head>
<body style="font-family:Arial,sans-serif;background:#f4f6f9;padding:15px;margin:0;">
<div style="max-width:580px;background:#fff;border:1px solid #ccd0d5;padding:15px;border-radius:6px;margin:auto;">
  <h3 style="color:#0d3b66;margin:0 0 6px;border-bottom:2px solid #0d3b66;padding-bottom:5px;">P14.2: Secure Data Defense (SQLi & XSS)</h3>
  <p style="font-size:12px;color:#555;margin:0 0 10px;">Simulasi Laporan Insiden Siber: Prepared Statements PDO & Anti-XSS.</p>
  <?= $msg ?>
  <form method="POST" style="font-size:13px;margin-bottom:12px;">
    <input type="text" name="ticket" placeholder="ID Tiket (cth: TCK-102)" required style="width:30%;padding:5px;">
    <select name="sev" style="padding:5px;"><option>Low</option><option>Medium</option><option>High</option></select>
    <input type="text" name="desc" placeholder="Deskripsi Insiden (Test payload XSS)" required style="width:40%;padding:5px;">
    <button type="submit" style="background:#0d3b66;color:#fff;border:none;padding:6px 12px;cursor:pointer;">Simpan</button></form>
  <table border="1" cellpadding="5" cellspacing="0" style="width:100%;border-collapse:collapse;font-size:12px;">
    <tr style="background:#eaf2f8;"><th>Tiket</th><th>Tingkat</th><th>Deskripsi Insiden (htmlspecialchars)</th></tr>
    <?php foreach($rows as $r): ?><tr><td><?= htmlspecialchars($r['ticket']) ?></td><td><?= htmlspecialchars($r['severity']) ?></td><td><?= htmlspecialchars($r['desc']) ?></td></tr><?php endforeach; ?></table></div></body></html>
