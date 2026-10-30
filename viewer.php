<?php
/**
 * Runner Sandbox & Source Code Inspector
 * Portal Praktikum Pemrograman Web Dasar - STMIK IKMI Cirebon
 * Domain: webdasar26.designme.my.id
 */

$file = $_GET['file'] ?? '';
$action = $_GET['action'] ?? 'run';

// Validasi Keamanan Path (Mencegah Directory Traversal)
$realBase = realpath(__DIR__);
$cleanFile = str_replace(['../', '..\\'], '', $file);
$targetPath = realpath(__DIR__ . '/' . $cleanFile);

if (!$targetPath || !str_starts_with($targetPath, $realBase) || !is_file($targetPath)) {
    http_response_code(404);
    die('<div style="font-family:sans-serif;padding:30px;text-align:center;color:#ef4444;"><h3>⚠️ File Tidak Ditemukan atau Akses Ditolak</h3><p><a href="index.php">Kembali ke Dashboard</a></p></div>');
}

// 1. API: Output Raw Source Code untuk Modal
if ($action === 'raw') {
    header('Content-Type: text/plain; charset=utf-8');
    echo file_get_contents($targetPath);
    exit;
}

// 2. Interactive Runner Shell (Frame + Navigation)
$fileName = basename($targetPath);
$fileRel = str_replace($realBase . '/', '', $targetPath);
$lineCount = count(file($targetPath));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Runner: <?= htmlspecialchars($fileName) ?> — webdasar26.designme.my.id</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/prism.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background: #090d16;
        }
        .runner-nav {
            height: 56px;
            background: #0f172a;
            border-bottom: 1px solid #1e293b;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            z-index: 10;
            flex-shrink: 0;
        }
        .runner-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .runner-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
        }
        .runner-meta .filename {
            color: #38bdf8;
            font-weight: 600;
        }
        .runner-meta .badge {
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
        }
        .runner-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .runner-frame {
            flex-grow: 1;
            width: 100%;
            height: calc(100% - 56px);
            border: none;
            background: #ffffff;
        }
    </style>
</head>
<body class="dark-theme">
    <div class="runner-nav">
        <div class="runner-left">
            <a href="index.php" class="btn btn-secondary btn-sm" style="font-weight: 700;">
                ← Dashboard
            </a>
            <div class="runner-meta">
                <span class="badge"><?= $lineCount ?> baris</span>
                <span class="filename"><?= htmlspecialchars($fileRel) ?></span>
            </div>
        </div>

        <div class="runner-actions">
            <button type="button" class="btn btn-secondary btn-sm" onclick="openCodeModal('<?= htmlspecialchars($fileRel) ?>', '<?= htmlspecialchars($fileName) ?>')">
                💻 Lihat Source Code
            </button>
            <a href="<?= htmlspecialchars($fileRel) ?>" target="_blank" class="btn btn-primary btn-sm" title="Buka di tab baru mandiri">
                ⚡ Standalone
            </a>
        </div>
    </div>

    <!-- Live Execution Sandbox Frame -->
    <iframe src="<?= htmlspecialchars($fileRel) ?>" class="runner-frame" id="liveRunnerFrame" title="Live Module Runner"></iframe>

    <!-- Modal Source Code Viewer -->
    <div class="modal-overlay" id="codeViewerModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalCodeTitle"><?= htmlspecialchars($fileName) ?></h3>
                <div class="modal-actions">
                    <button class="btn btn-secondary btn-sm" id="copyCodeBtn">📋 Salin Kode</button>
                    <button class="btn btn-secondary btn-sm" id="modalCloseBtn">✕ Tutup</button>
                </div>
            </div>
            <div class="modal-body">
                <pre><code class="language-php" id="modalCodeContent">// Memuat...</code></pre>
            </div>
        </div>
    </div>

    <script src="assets/js/prism.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
