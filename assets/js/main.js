/**
 * Portal Praktikum Pemrograman Web Dasar — Interactive Logic
 * STMIK IKMI Cirebon | webdasar26.designme.my.id
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Theme Management (Dark / Light)
    const themeBtn = document.getElementById('themeToggleBtn');
    const savedTheme = localStorage.getItem('theme_preference') || 'dark';

    function setTheme(theme) {
        if (theme === 'light') {
            document.body.classList.add('light-theme');
            document.body.classList.remove('dark-theme');
            if (themeBtn) themeBtn.textContent = '🌙';
        } else {
            document.body.classList.add('dark-theme');
            document.body.classList.remove('light-theme');
            if (themeBtn) themeBtn.textContent = '☀️';
        }
        localStorage.setItem('theme_preference', theme);
    }
    setTheme(savedTheme);

    if (themeBtn) {
        themeBtn.addEventListener('click', () => {
            const currentTheme = document.body.classList.contains('light-theme') ? 'light' : 'dark';
            setTheme(currentTheme === 'light' ? 'dark' : 'light');
        });
    }

    // 2. Tab Navigation (KA vs SI vs Mini Projek)
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetTab = btn.getAttribute('data-tab');
            tabButtons.forEach(b => b.classList.remove('active'));
            tabPanels.forEach(p => p.style.display = 'none');

            btn.classList.add('active');
            const activePanel = document.getElementById(`tab-${targetTab}`);
            if (activePanel) {
                activePanel.style.display = 'block';
            }
            // Trigger search filter refresh on active tab
            applyFilters();
        });
    });

    // 3. Search & Pertemuan Chip Filters
    const searchInput = document.getElementById('moduleSearchInput');
    const filterChips = document.querySelectorAll('.pertemuan-chips .chip');

    let activePertemuan = 'all';

    filterChips.forEach(chip => {
        chip.addEventListener('click', () => {
            filterChips.forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            activePertemuan = chip.getAttribute('data-pertemuan');
            applyFilters();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            applyFilters();
        });
    }

    function applyFilters() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const currentActiveTab = document.querySelector('.tab-btn.active')?.getAttribute('data-tab') || 'ka';
        const activeContainer = document.getElementById(`tab-${currentActiveTab}`);
        if (!activeContainer) return;

        const cards = activeContainer.querySelectorAll('.module-card');
        const sectionHeaders = activeContainer.querySelectorAll('.pertemuan-section');

        let visibleCount = 0;

        cards.forEach(card => {
            const cardPertemuan = card.getAttribute('data-pertemuan') || '';
            const cardTitle = (card.querySelector('.module-title')?.textContent || '').toLowerCase();
            const cardFile = (card.querySelector('.module-file')?.textContent || '').toLowerCase();
            const cardDesc = (card.querySelector('.module-desc')?.textContent || '').toLowerCase();
            const cardTag = (card.querySelector('.card-tag')?.textContent || '').toLowerCase();

            const matchesPertemuan = (activePertemuan === 'all' || cardPertemuan === activePertemuan);
            const matchesQuery = (!query || cardTitle.includes(query) || cardFile.includes(query) || cardDesc.includes(query) || cardTag.includes(query));

            if (matchesPertemuan && matchesQuery) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Hide section headers if all cards in that section are hidden
        sectionHeaders.forEach(section => {
            const sectionCards = section.querySelectorAll('.module-card');
            const hasVisible = Array.from(sectionCards).some(c => c.style.display !== 'none');
            section.style.display = hasVisible ? 'block' : 'none';
        });

        // Update stats badge
        const statsEl = document.getElementById('searchCountBadge');
        if (statsEl) {
            statsEl.textContent = `${visibleCount} modul ditemukan`;
        }
    }

    // 4. Modal Source Code Viewer
    const codeModal = document.getElementById('codeViewerModal');
    const modalTitle = document.getElementById('modalCodeTitle');
    const modalCode = document.getElementById('modalCodeContent');
    const modalCloseBtn = document.getElementById('modalCloseBtn');
    const copyCodeBtn = document.getElementById('copyCodeBtn');

    window.openCodeModal = function(filePath, displayName) {
        if (!codeModal) return;
        modalTitle.textContent = displayName || filePath;
        modalCode.textContent = '// Memuat source code...';
        codeModal.classList.add('active');

        fetch(`viewer.php?action=raw&file=${encodeURIComponent(filePath)}`)
            .then(res => {
                if (!res.ok) throw new Error('Gagal memuat file.');
                return res.text();
            })
            .then(code => {
                modalCode.textContent = code;
                if (window.Prism) {
                    Prism.highlightElement(modalCode);
                }
            })
            .catch(err => {
                modalCode.textContent = `// Galat: ${err.message}`;
            });
    };

    if (modalCloseBtn) {
        modalCloseBtn.addEventListener('click', () => {
            codeModal.classList.remove('active');
        });
    }

    if (codeModal) {
        codeModal.addEventListener('click', (e) => {
            if (e.target === codeModal) {
                codeModal.classList.remove('active');
            }
        });
    }

    if (copyCodeBtn) {
        copyCodeBtn.addEventListener('click', () => {
            if (!modalCode) return;
            navigator.clipboard.writeText(modalCode.textContent).then(() => {
                const originalText = copyCodeBtn.textContent;
                copyCodeBtn.textContent = '✅ Tersalin!';
                copyCodeBtn.style.background = '#10b981';
                setTimeout(() => {
                    copyCodeBtn.textContent = originalText;
                    copyCodeBtn.style.background = '';
                }, 2000);
            }).catch(() => {
                alert('Gagal menyalin kode ke clipboard.');
            });
        });
    }

    // 5. Modal Docs & Downloads Management
    const docsModal = document.getElementById('docsModal');
    const openDocsBtn = document.getElementById('openDocsModalBtn');
    const openDownloadsBtn = document.getElementById('openDownloadsModalBtn');
    const docsCloseBtn = document.getElementById('docsModalCloseBtn');

    if (openDocsBtn && docsModal) {
        openDocsBtn.addEventListener('click', () => {
            docsModal.classList.add('active');
        });
    }

    if (openDownloadsBtn && docsModal) {
        openDownloadsBtn.addEventListener('click', () => {
            docsModal.classList.add('active');
        });
    }

    if (docsCloseBtn && docsModal) {
        docsCloseBtn.addEventListener('click', () => {
            docsModal.classList.remove('active');
        });
    }

    if (docsModal) {
        docsModal.addEventListener('click', (e) => {
            if (e.target === docsModal) {
                docsModal.classList.remove('active');
            }
        });
    }

    // ESC key closes modals
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (codeModal && codeModal.classList.contains('active')) {
                codeModal.classList.remove('active');
            }
            if (docsModal && docsModal.classList.contains('active')) {
                docsModal.classList.remove('active');
            }
        }
    });
});
