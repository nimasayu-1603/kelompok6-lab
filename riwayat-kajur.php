<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>InventraLab - Semua Laporan</title>
    <link rel="stylesheet" href="style.css">
    <script>
        if (sessionStorage.getItem('isLoggedIn') !== 'true') window.location.href = 'login.html';
        if (sessionStorage.getItem('userRole') !== 'Kajur') window.location.href = 'login.html';
    </script>
    <style>
        .filter-bar { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px; }
        .filter-bar button { padding:8px 14px; border-radius:99px; border:1px solid var(--line); background:var(--white); font-size:12px; font-weight:700; cursor:pointer; color:var(--muted); }
        .filter-bar button.active { background:var(--blue); color:#fff; border-color:var(--blue); }
    </style>
</head>
<body>
    <div id="appScreen" style="display:flex;">
        <header class="topbar">
            <div class="brand"><div class="brand-logo">IL</div><div class="brand-text">InventraLab</div></div>
            <div class="user-info"><button onclick="sessionStorage.clear(); window.location.href='login.html';" class="btn-logout">LR</button></div>
        </header>

        <nav class="nav-bar">
            <a href="index-kajur.html"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg><span>Beranda</span></a>
            <a href="riwayat-kajur.html" class="active"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg><span>Semua Laporan</span></a>
        </nav>

        <main>
            <div class="section-head"><h2>Daftar Semua Laporan</h2></div>

            <div class="filter-bar" id="filterBar">
                <button data-filter="all" class="active">Semua</button>
                <button data-filter="Menunggu">Menunggu</button>
                <button data-filter="Selesai">Selesai</button>
            </div>

            <div id="laporanContainer" class="history-list" style="gap:16px;"></div>
        </main>
    </div>

    <script>
        let allData = JSON.parse(localStorage.getItem('inventraLabData')) || [];
        let currentFilter = 'all';

        function renderLaporan() {
            let data = allData;
            if (currentFilter !== 'all') {
                data = data.filter(d => d.status === currentFilter);
            }

            const container = document.getElementById('laporanContainer');
            if (data.length === 0) {
                container.innerHTML = '<div style="text-align:center; padding:20px; color:var(--muted);">Tidak ada laporan.</div>';
                return;
            }

            let html = '';
            data.forEach(item => {
                let badge = item.status === 'Selesai' ? 'badge-good' : 'badge-warning';
                html += `
                    <div class="history-item" style="display:flex; flex-direction:column; align-items:flex-start; gap:8px;">
                        <div style="width:100%; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <strong>${item.kode}</strong>
                                <div style="font-size:12px; color:var(--muted);">Pelapor: ${item.nama}</div>
                            </div>
                            <span class="badge ${badge}">${item.status}</span>
                        </div>
                        <div style="background:var(--canvas); padding:10px; border-radius:8px; font-size:13px; width:100%; border:1px solid var(--line);">
                            <b>Kondisi:</b> ${item.kondisi} | <b>Lab:</b> ${item.lab} | <b>Tanggal:</b> ${item.tanggal}<br>
                            <b>Catatan:</b> ${item.catatan || '-'}
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        document.querySelectorAll('#filterBar button').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('#filterBar button').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentFilter = btn.dataset.filter;
                renderLaporan();
            });
        });

        renderLaporan();
    </script>
</body>
</html>
