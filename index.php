<?php
/**
 * Main Portal & Dashboard Menu
 * Portal Praktikum Pemrograman Web Dasar — STMIK IKMI Cirebon
 * Domain: webdasar26.designme.my.id
 */

require_once __DIR__ . '/config/database.php';

$env = AppDatabase::getEnv();
$diag = AppDatabase::getDiagnostics();

$manifestFile = __DIR__ . '/manifest.json';
$manifest = file_exists($manifestFile) ? json_decode(file_get_contents($manifestFile), true) : ['ka' => [], 'si' => [], 'projects' => []];

$totalKa = 0;
foreach ($manifest['ka'] as $pList) $totalKa += count($pList);

$totalSi = 0;
foreach ($manifest['si'] as $pList) $totalSi += count($pList);

$totalModul = $totalKa + $totalSi;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($env['APP_NAME']) ?> — <?= htmlspecialchars($env['APP_CAMPUS']) ?></title>
    <meta name="description" content="Portal Terpadu Modul Praktikum Pemrograman Web Dasar Semester Ganjil 2026/2027 Program Studi Komputerisasi Akuntansi dan Sistem Informasi STMIK IKMI Cirebon.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/prism.css">
</head>
<body class="dark-theme">

    <!-- Header Portal -->
    <header class="app-header">
        <div class="header-container">
            <a href="index.php" class="brand-wrapper">
                <div class="brand-logo">🌐</div>
                <div class="brand-text">
                    <h1><?= htmlspecialchars($env['APP_NAME']) ?></h1>
                    <p><?= htmlspecialchars($env['APP_CAMPUS']) ?> • Semester <?= htmlspecialchars($env['ACADEMIC_YEAR']) ?></p>
                </div>
            </a>

            <div class="header-actions">
                <button type="button" class="btn btn-secondary btn-sm" id="openDocsModalBtn" title="Unduh Modul PDF & Panduan VS Code">
                    <span>📚 Modul & Dokumen</span>
                </button>

                <button type="button" class="btn btn-secondary btn-sm" id="openDownloadsModalBtn" title="Unduh Paket Source Code ZIP">
                    <span>📦 Download Projek (.zip)</span>
                </button>

                <a href="setup_database.php" class="btn btn-secondary btn-sm" title="Setup & Status Basis Data">
                    <span>⚙️ Setup Database</span>
                    <?php if ($diag['server_connected']): ?>
                        <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#10b981;"></span>
                    <?php else: ?>
                        <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#ef4444;"></span>
                    <?php endif; ?>
                </a>

                <button type="button" class="theme-toggle" id="themeToggleBtn" title="Ganti Mode Tampilan (Dark/Light)">
                    ☀️
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Banner -->
    <section class="hero-section">
        <div class="hero-banner">
            <div class="hero-tagline">
                <span>🚀 REPOSITORI PRAKTIKUM WEB PHP RESMI</span>
            </div>
            <h2 class="hero-title">
                Eksplorasi Modul Praktikum & Arsitektur Enterprise MVC
            </h2>
            <p class="hero-desc">
                Portal terstruktur yang mengompilasi seluruh modul live coding praktikum Pemrograman Web Dasar dari Pertemuan 9 hingga 15 untuk Prodi <strong>Komputerisasi Akuntansi (KA)</strong> dan <strong>Sistem Informasi (SI)</strong>, dilengkapi dengan 2 Mini Project MVC &amp; OOP siap uji.
            </p>

            <!-- Metrics Pills -->
            <div class="metrics-row">
                <div class="metric-pill">
                    <div class="metric-icon">📑</div>
                    <div class="metric-data">
                        <strong><?= $totalModul ?> Modul</strong>
                        <span>Total Live Coding (P9–P15)</span>
                    </div>
                </div>

                <div class="metric-pill">
                    <div class="metric-icon">🏢</div>
                    <div class="metric-data">
                        <strong>2 Program Studi</strong>
                        <span>KA (<?= $totalKa ?>) &amp; SI (<?= $totalSi ?>)</span>
                    </div>
                </div>

                <div class="metric-pill">
                    <div class="metric-icon">🚀</div>
                    <div class="metric-data">
                        <strong>2 Mini Projek</strong>
                        <span>Enterprise MVC &amp; OOP</span>
                    </div>
                </div>

                <div class="metric-pill">
                    <div class="metric-icon">🐘</div>
                    <div class="metric-data">
                        <strong>PHP <?= PHP_VERSION ?></strong>
                        <span>Runtime Environment</span>
                    </div>
                </div>

                <div class="metric-pill">
                    <div class="metric-icon">🗄️</div>
                    <div class="metric-data">
                        <strong><?= $diag['server_connected'] ? 'MySQL Online' : 'MySQL Offline' ?></strong>
                        <span><?= $diag['server_connected'] ? 'Port ' . $diag['port'] : '<a href="setup_database.php" style="color:var(--accent-rose);text-decoration:none;">Aktifkan</a>' ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <main class="main-content">

        <!-- Control Bar: Tabs & Search -->
        <div class="control-bar">
            <!-- Prodi Tabs -->
            <div class="tab-nav">
                <button type="button" class="tab-btn active" data-tab="ka">
                    <span>💳</span> Komputerisasi Akuntansi (KA)
                </button>
                <button type="button" class="tab-btn" data-tab="si">
                    <span>📊</span> Sistem Informasi (SI)
                </button>
                <button type="button" class="tab-btn" data-tab="projects">
                    <span>🌟</span> Mini Projek MVC Showcase
                </button>
            </div>

            <!-- Search & Filters -->
            <div class="filter-controls">
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="moduleSearchInput" placeholder="Cari modul, materi, atau nama file...">
                </div>
                <span class="section-badge" id="searchCountBadge"><?= $totalKa ?> modul ditampilkan</span>
            </div>
        </div>

        <!-- Filter Chips Per Pertemuan -->
        <div class="pertemuan-chips">
            <button type="button" class="chip active" data-pertemuan="all">Semua Pertemuan</button>
            <button type="button" class="chip" data-pertemuan="pertemuan-09">P9 (Sintaks &amp; Variabel)</button>
            <button type="button" class="chip" data-pertemuan="pertemuan-10">P10 (Percabangan &amp; Array)</button>
            <button type="button" class="chip" data-pertemuan="pertemuan-11">P11 (Form GET &amp; POST)</button>
            <button type="button" class="chip" data-pertemuan="pertemuan-12">P12 (Cookie &amp; MySQL)</button>
            <button type="button" class="chip" data-pertemuan="pertemuan-13">P13 (CRUD Database)</button>
            <button type="button" class="chip" data-pertemuan="pertemuan-14">P14 (Session &amp; Keamanan)</button>
            <button type="button" class="chip" data-pertemuan="pertemuan-15">P15 (Mini SIA &amp; Forensik)</button>
        </div>

        <!-- TAB 1: PRODI KOMPUTERISASI AKUNTANSI (KA) -->
        <div class="tab-panel" id="tab-ka" style="display: block;">
            <!-- Featured Mini Project KA Banner -->
            <div class="project-banner-card" style="margin-bottom: 24px;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:10px;">
                    <div>
                        <span class="project-badge">PROJEK AKHIR SEMESTER • KOMPUTERISASI AKUNTANSI</span>
                        <h3 style="font-size: 1.35rem; font-weight: 800; margin: 8px 0 6px 0;">
                            <?= htmlspecialchars($manifest['projects']['ka_mini']['title']) ?>
                        </h3>
                        <p style="color: var(--text-muted); max-width: 820px; margin-bottom: 16px; font-size: 0.95rem;">
                            <?= htmlspecialchars($manifest['projects']['ka_mini']['description']) ?>
                        </p>
                    </div>
                </div>

                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="ka/projek-mini/index.php" target="_blank" class="btn btn-primary btn-sm">
                        🚀 Buka Aplikasi Web KA
                    </a>
                    <a href="docs/Praktikum Mini Projek - KA.pdf" target="_blank" class="btn btn-secondary btn-sm">
                        📄 Unduh Modul PDF
                    </a>
                    <a href="downloads/mini_project_ka.zip" download class="btn btn-secondary btn-sm">
                        📦 Unduh Source Code (.zip)
                    </a>
                    <a href="docs/Menjalankan Projek PHP di VS Code.docx" download class="btn btn-secondary btn-sm">
                        📖 Panduan VS Code
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="document.querySelector('.tab-btn[data-tab=\'projects\']').click();">
                        🌟 Tinjau 8 Kode Berkas MVC
                    </button>
                </div>
            </div>
            <?php foreach ($manifest['ka'] as $pKey => $modules): 
                $pNum = (int)str_replace('pertemuan-', '', $pKey);
            ?>
                <section class="pertemuan-section" data-pertemuan="<?= $pKey ?>">
                    <div class="section-heading">
                        <h2>
                            <span>Pertemuan <?= $pNum ?> — Komputerisasi Akuntansi</span>
                        </h2>
                        <span class="section-badge"><?= count($modules) ?> Lembar Praktikum</span>
                    </div>

                    <div class="module-grid">
                        <?php foreach ($modules as $mod): 
                            $tagClass = '';
                            if (str_contains(strtolower($mod['tag']), 'mysql')) $tagClass = 'mysql';
                            elseif (str_contains(strtolower($mod['tag']), 'keamanan') || str_contains(strtolower($mod['tag']), 'audit')) $tagClass = 'security';
                        ?>
                            <div class="module-card" data-pertemuan="<?= $pKey ?>">
                                <div>
                                    <div class="module-card-header">
                                        <span class="card-tag <?= $tagClass ?>"><?= htmlspecialchars($mod['tag']) ?></span>
                                        <span class="card-lines"><?= $mod['lines'] ?> baris</span>
                                    </div>
                                    <h3 class="module-title"><?= htmlspecialchars($mod['title'] ?? $mod['file_name']) ?></h3>
                                    <span class="module-file"><?= htmlspecialchars($mod['file_name']) ?></span>
                                    <p class="module-desc"><?= htmlspecialchars($mod['desc'] ?? $mod['info']) ?></p>
                                </div>

                                <div class="card-actions">
                                    <a href="viewer.php?file=<?= urlencode($mod['rel_path']) ?>" class="btn btn-primary btn-sm">
                                        ⚡ Jalankan Modul
                                    </a>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="openCodeModal('<?= htmlspecialchars($mod['rel_path']) ?>', '<?= htmlspecialchars($mod['file_name']) ?>')">
                                        💻 Kode
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>

        <!-- TAB 2: PRODI SISTEM INFORMASI (SI) -->
        <div class="tab-panel" id="tab-si" style="display: none;">
            <!-- Featured Mini Project SI Banner -->
            <div class="project-banner-card" style="border-color: rgba(59, 130, 246, 0.4); margin-bottom: 24px;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:10px;">
                    <div>
                        <span class="project-badge" style="background: var(--primary);">PROJEK AKHIR SEMESTER • S1 SISTEM INFORMASI</span>
                        <h3 style="font-size: 1.35rem; font-weight: 800; margin: 8px 0 6px 0;">
                            <?= htmlspecialchars($manifest['projects']['si_mini']['title']) ?>
                        </h3>
                        <p style="color: var(--text-muted); max-width: 820px; margin-bottom: 16px; font-size: 0.95rem;">
                            <?= htmlspecialchars($manifest['projects']['si_mini']['description']) ?>
                        </p>
                    </div>
                </div>

                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="si/projek-mini/index.php" target="_blank" class="btn btn-primary btn-sm">
                        🚀 Buka Aplikasi Web SI
                    </a>
                    <a href="docs/Praktikum Mini Projek - SI.pdf" target="_blank" class="btn btn-secondary btn-sm">
                        📄 Unduh Modul PDF
                    </a>
                    <a href="downloads/mini_project_si.zip" download class="btn btn-secondary btn-sm">
                        📦 Unduh Source Code (.zip)
                    </a>
                    <a href="docs/Menjalankan Projek PHP di VS Code.docx" download class="btn btn-secondary btn-sm">
                        📖 Panduan VS Code
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="document.querySelector('.tab-btn[data-tab=\'projects\']').click();">
                        🌟 Tinjau 14 Kode Berkas MVC
                    </button>
                    <span style="display:inline-flex;align-items:center;padding:0 8px;font-size:0.85rem;color:var(--accent-amber);">
                        🔑 Login: <strong>&nbsp;admin / admin123</strong>
                    </span>
                </div>
            </div>
            <?php foreach ($manifest['si'] as $pKey => $modules): 
                $pNum = (int)str_replace('pertemuan-', '', $pKey);
            ?>
                <section class="pertemuan-section" data-pertemuan="<?= $pKey ?>">
                    <div class="section-heading">
                        <h2>
                            <span>Pertemuan <?= $pNum ?> — Sistem Informasi</span>
                        </h2>
                        <span class="section-badge"><?= count($modules) ?> Lembar Praktikum</span>
                    </div>

                    <div class="module-grid">
                        <?php foreach ($modules as $mod): 
                            $tagClass = '';
                            if (str_contains(strtolower($mod['tag']), 'mysql') || str_contains(strtolower($mod['tag']), 'pdo')) $tagClass = 'mysql';
                            elseif (str_contains(strtolower($mod['tag']), 'keamanan') || str_contains(strtolower($mod['tag']), 'defense') || str_contains(strtolower($mod['tag']), 'ethical')) $tagClass = 'security';
                        ?>
                            <div class="module-card" data-pertemuan="<?= $pKey ?>">
                                <div>
                                    <div class="module-card-header">
                                        <span class="card-tag <?= $tagClass ?>"><?= htmlspecialchars($mod['tag']) ?></span>
                                        <span class="card-lines"><?= $mod['lines'] ?> baris</span>
                                    </div>
                                    <h3 class="module-title"><?= htmlspecialchars($mod['title'] ?? $mod['file_name']) ?></h3>
                                    <span class="module-file"><?= htmlspecialchars($mod['file_name']) ?></span>
                                    <p class="module-desc"><?= htmlspecialchars($mod['desc'] ?? $mod['info']) ?></p>
                                </div>

                                <div class="card-actions">
                                    <a href="viewer.php?file=<?= urlencode($mod['rel_path']) ?>" class="btn btn-primary btn-sm">
                                        ⚡ Jalankan Modul
                                    </a>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="openCodeModal('<?= htmlspecialchars($mod['rel_path']) ?>', '<?= htmlspecialchars($mod['file_name']) ?>')">
                                        💻 Kode
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>

        <!-- TAB 3: MINI PROJEK MVC SHOWCASE -->
        <div class="tab-panel" id="tab-projects" style="display: none;">
            
            <!-- KA Mini Project -->
            <div class="project-banner-card">
                <span class="project-badge">KOMPUTERISASI AKUNTANSI • PRAKTIKUM MINI PROJEK</span>
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 8px;">
                    <?= htmlspecialchars($manifest['projects']['ka_mini']['title']) ?>
                </h3>
                <p style="color: var(--text-muted); max-width: 800px; margin-bottom: 20px;">
                    <?= htmlspecialchars($manifest['projects']['ka_mini']['description']) ?>
                </p>

                <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 24px;">
                    <a href="ka/projek-mini/index.php" target="_blank" class="btn btn-primary">
                        🚀 Buka Aplikasi Web KA Mini Projek (Full Window)
                    </a>
                    <a href="docs/Praktikum Mini Projek - KA.pdf" target="_blank" class="btn btn-secondary">
                        📄 Unduh Modul PDF
                    </a>
                    <a href="downloads/mini_project_ka.zip" download class="btn btn-secondary">
                        📦 Unduh Source Code (.zip)
                    </a>
                    <a href="docs/Menjalankan Projek PHP di VS Code.docx" download class="btn btn-secondary">
                        📖 Panduan VS Code
                    </a>
                    <a href="viewer.php?file=<?= urlencode($manifest['projects']['ka_mini']['entry']) ?>" class="btn btn-secondary">
                        ⚡ Jalankan di Runner Sandbox
                    </a>
                </div>

                <h4 style="font-size: 0.95rem; margin-bottom: 12px; color: var(--text-main);">Komponen &amp; File MVC Terstruktur (8 File):</h4>
                <div class="module-grid" style="margin-bottom: 0;">
                    <?php foreach ($manifest['projects']['ka_mini']['files'] as $f): ?>
                        <div class="module-card">
                            <div>
                                <div class="module-card-header">
                                    <span class="card-tag mvc"><?= htmlspecialchars($f['tag']) ?></span>
                                    <span class="card-lines"><?= $f['lines'] ?> baris</span>
                                </div>
                                <span class="module-file"><?= htmlspecialchars($f['file_name']) ?></span>
                                <p class="module-desc"><?= htmlspecialchars($f['info']) ?></p>
                            </div>
                            <div class="card-actions">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="openCodeModal('<?= htmlspecialchars($f['rel_path']) ?>', '<?= htmlspecialchars($f['file_name']) ?>')">
                                    💻 Lihat Kode Berkas
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- SI Mini Project -->
            <div class="project-banner-card" style="border-color: rgba(59, 130, 246, 0.4); margin-top: 36px;">
                <span class="project-badge" style="background: var(--primary);">SISTEM INFORMASI • PRAKTIKUM MINI PROJEK</span>
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 8px;">
                    <?= htmlspecialchars($manifest['projects']['si_mini']['title']) ?>
                </h3>
                <p style="color: var(--text-muted); max-width: 800px; margin-bottom: 20px;">
                    <?= htmlspecialchars($manifest['projects']['si_mini']['description']) ?>
                </p>

                <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 24px;">
                    <a href="si/projek-mini/index.php" target="_blank" class="btn btn-primary">
                        🚀 Buka Aplikasi Web SI Enterprise MVC (Full Window)
                    </a>
                    <a href="docs/Praktikum Mini Projek - SI.pdf" target="_blank" class="btn btn-secondary">
                        📄 Unduh Modul PDF
                    </a>
                    <a href="downloads/mini_project_si.zip" download class="btn btn-secondary">
                        📦 Unduh Source Code (.zip)
                    </a>
                    <a href="docs/Menjalankan Projek PHP di VS Code.docx" download class="btn btn-secondary">
                        📖 Panduan VS Code
                    </a>
                    <a href="viewer.php?file=<?= urlencode($manifest['projects']['si_mini']['entry']) ?>" class="btn btn-secondary">
                        ⚡ Jalankan di Runner Sandbox
                    </a>
                    <span style="display:inline-flex;align-items:center;padding:0 12px;font-size:0.85rem;color:var(--accent-amber);">
                        🔑 Kredensial Login: <strong>&nbsp;admin / admin123</strong>
                    </span>
                </div>

                <h4 style="font-size: 0.95rem; margin-bottom: 12px; color: var(--text-main);">Komponen &amp; File MVC Enterprise (<?= count($manifest['projects']['si_mini']['files']) ?> File):</h4>
                <div class="module-grid" style="margin-bottom: 0;">
                    <?php foreach ($manifest['projects']['si_mini']['files'] as $f): ?>
                        <div class="module-card">
                            <div>
                                <div class="module-card-header">
                                    <span class="card-tag mvc"><?= htmlspecialchars($f['tag']) ?></span>
                                    <span class="card-lines"><?= $f['lines'] ?> baris</span>
                                </div>
                                <span class="module-file"><?= htmlspecialchars($f['file_name']) ?></span>
                                <p class="module-desc"><?= htmlspecialchars($f['info']) ?></p>
                            </div>
                            <div class="card-actions">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="openCodeModal('<?= htmlspecialchars($f['rel_path']) ?>', '<?= htmlspecialchars($f['file_name']) ?>')">
                                    💻 Lihat Kode Berkas
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

    </main>

    <!-- Modal Source Code Viewer -->
    <div class="modal-overlay" id="codeViewerModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modalCodeTitle">Source Code</h3>
                <div class="modal-actions">
                    <button class="btn btn-secondary btn-sm" id="copyCodeBtn">📋 Salin Kode</button>
                    <button class="btn btn-secondary btn-sm" id="modalCloseBtn">✕ Tutup</button>
                </div>
            </div>
            <div class="modal-body">
                <pre><code class="language-php" id="modalCodeContent">// Memuat kode...</code></pre>
            </div>
        </div>
    </div>

    <!-- Modal Pusat Dokumen & Modul PDF -->
    <div class="modal-overlay" id="docsModal">
        <div class="modal-box" style="max-width: 680px;">
            <div class="modal-header">
                <h3>📚 Repositori Modul Praktikum &amp; Dokumen Panduan</h3>
                <div class="modal-actions">
                    <button class="btn btn-secondary btn-sm" id="docsModalCloseBtn">✕ Tutup</button>
                </div>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <p style="color: var(--text-muted); margin-bottom: 16px; font-size: 0.9rem;">
                    Unduh berkas modul resmi PDF, panduan eksekusi di VS Code, dan paket source code (.zip) untuk perkuliahan Pemrograman Web Dasar:
                </p>
                
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <!-- Dokumen 1: SI PDF -->
                    <div style="background:var(--card-bg); border:1px solid var(--border-color); border-radius:8px; padding:14px; display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div style="flex:1; min-width:260px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:1.2rem;">📕</span>
                                <strong style="color:var(--text-main);">Modul Praktikum Mini Project - Sistem Informasi</strong>
                                <span class="card-tag" style="background:#ef4444; color:#fff;">PDF (608 KB)</span>
                            </div>
                            <p style="margin:4px 0 0 0; font-size:0.85rem; color:var(--text-muted);">
                                Pedoman Enterprise MVC, SPK Simple Additive Weighting, Audit Trail, &amp; Keamanan Web.
                            </p>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <a href="docs/Praktikum Mini Projek - SI.pdf" target="_blank" class="btn btn-primary btn-sm">Buka / Unduh PDF</a>
                        </div>
                    </div>

                    <!-- Dokumen 2: KA PDF -->
                    <div style="background:var(--card-bg); border:1px solid var(--border-color); border-radius:8px; padding:14px; display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div style="flex:1; min-width:260px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:1.2rem;">📘</span>
                                <strong style="color:var(--text-main);">Modul Praktikum Mini Project - Komputerisasi Akuntansi</strong>
                                <span class="card-tag" style="background:#3b82f6; color:#fff;">PDF (659 KB)</span>
                            </div>
                            <p style="margin:4px 0 0 0; font-size:0.85rem; color:var(--text-muted);">
                                Pedoman MVC Native OOP 1 Tabel Sederhana (Manajemen Operator Sistem &amp; Kasir).
                            </p>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <a href="docs/Praktikum Mini Projek - KA.pdf" target="_blank" class="btn btn-primary btn-sm">Buka / Unduh PDF</a>
                        </div>
                    </div>

                    <!-- Dokumen 3: DOCX Panduan VS Code -->
                    <div style="background:var(--card-bg); border:1px solid var(--border-color); border-radius:8px; padding:14px; display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div style="flex:1; min-width:260px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:1.2rem;">💻</span>
                                <strong style="color:var(--text-main);">Catatan Teknis Menjalankan Projek PHP di VS Code</strong>
                                <span class="card-tag" style="background:#10b981; color:#fff;">DOCX (39 KB)</span>
                            </div>
                            <p style="margin:4px 0 0 0; font-size:0.85rem; color:var(--text-muted);">
                                Panduan teknis ringkas eksekusi terminal, PHP built-in server (php -S), &amp; ekstensi.
                            </p>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <a href="docs/Menjalankan Projek PHP di VS Code.docx" download class="btn btn-secondary btn-sm">Unduh DOCX</a>
                        </div>
                    </div>

                    <!-- Download ZIP Source Code -->
                    <div style="background:var(--card-bg); border:1px solid var(--border-color); border-radius:8px; padding:14px; display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div style="flex:1; min-width:260px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-size:1.2rem;">📦</span>
                                <strong style="color:var(--text-main);">Paket Source Code Lengkap (.ZIP)</strong>
                                <span class="card-tag mvc">SOURCE CODE</span>
                            </div>
                            <p style="margin:4px 0 0 0; font-size:0.85rem; color:var(--text-muted);">
                                Seluruh berkas kode sumber MVC SI (14 file) dan KA (8 file) siap pakai di VS Code.
                            </p>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <a href="downloads/mini_project_si.zip" download class="btn btn-primary btn-sm">ZIP SI (16 KB)</a>
                            <a href="downloads/mini_project_ka.zip" download class="btn btn-secondary btn-sm">ZIP KA (7.3 KB)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="app-footer">
        <p>
            &copy; 2026/2027 <strong>STMIK IKMI Cirebon</strong> • Program Studi Komputerisasi Akuntansi (D3/S1) &amp; Sistem Informasi (S1).
        </p>
        <p style="margin-top: 4px; font-size: 0.8rem; color: var(--text-dim);">
            Domain Target: <code style="color:var(--primary);"><?= htmlspecialchars($env['APP_DOMAIN']) ?></code> • Dirancang dengan PHP Murni, CSS Vanilla Modern, &amp; Arsitektur MVC.
        </p>
    </footer>

    <!-- Scripts -->
    <script src="assets/js/prism.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
