<?php error_reporting(0); date_default_timezone_set('UTC');
// Lembar P15.2: Forensik Digital, Metadata Artefak, & Hashing SHA-256 Integritas
$log_file = sys_get_temp_dir() . '/security_audit_evidence.json';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim($_POST['event'] ?? 'Pemeriksaan Rutin');
    $meta = ['ts_utc' => date('Y-m-d\TH:i:s\Z'), 'ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1', 'agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', 0, 45), 'event' => $action];
    $meta['hash_sha256'] = hash('sha256', json_encode($meta)); // Digital Evidence Signature
    $logs = file_exists($log_file) ? json_decode(file_get_contents($log_file), true) : [];
    array_unshift($logs, $meta); file_put_contents($log_file, json_encode(array_slice($logs, 0, 4)));
}
$history = file_exists($log_file) ? json_decode(file_get_contents($log_file), true) : [];
?>
<!DOCTYPE html><html><head><title>P15.2 - Digital Evidence Logger</title></head>
<body style="font-family:Arial,sans-serif;background:#f4f6f9;padding:15px;margin:0;">
<div style="max-width:600px;background:#fff;border:1px solid #ccd0d5;padding:15px;border-radius:6px;margin:auto;">
  <h3 style="color:#0d3b66;margin:0 0 6px;border-bottom:2px solid #0d3b66;padding-bottom:5px;">P15.2: Perekaman Bukti Digital & Audit Forensik</h3>
  <p style="font-size:12px;color:#555;margin:0 0 10px;">Perekaman Metadata Artefak, Timestamp UTC, & Signature Hash SHA-256.</p>
  <form method="POST" style="margin-bottom:12px;font-size:13px;">
    <input type="text" name="event" placeholder="Nama Event (cth: Akses Ilegal Halaman Admin)" required style="width:70%;padding:6px;">
    <button type="submit" style="background:#0d3b66;color:#fff;border:none;padding:6px 12px;cursor:pointer;">Rekam Bukti</button></form>
  <table border="1" cellpadding="5" cellspacing="0" style="width:100%;border-collapse:collapse;font-size:11.5px;">
    <tr style="background:#eaf2f8;color:#0d3b66;"><th>Timestamp (UTC)</th><th>Alamat IP</th><th>Aktivitas Event</th><th>Signature SHA-256 (Integritas)</th></tr>
    <?php if (empty($history)): ?><tr><td colspan="4" align="center" style="color:#888;">Belum ada artefak terekam.</td></tr><?php else: ?>
    <?php foreach($history as $item): ?>
      <tr><td><?= htmlspecialchars($item['ts_utc']) ?></td><td><?= htmlspecialchars($item['ip']) ?></td>
      <td><b><?= htmlspecialchars($item['event']) ?></b></td>
      <td><code style="font-size:10px;color:#0969da;"><?= substr($item['hash_sha256'], 0, 16) ?>...</code></td></tr>
    <?php endforeach; endif; ?>
  </table></div></body></html>
<?php // End of P15.2: Artefak Digital dan Forensik Web Dasar ?>
