@extends('layouts.app')

@section('title', 'Antrian Pasien')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Antrian Pasien</h1>
</div>

<div id="alertBox"></div>

{{-- Tab Poli --}}
<ul class="nav nav-pills mb-3" id="poliTab">
    @foreach(['Poli Umum', 'Poli Gigi', 'Poli KIA'] as $poli)
    <li class="nav-item">
        <a class="nav-link {{ $loop->first ? 'active' : '' }}"
           href="#"
           onclick="gantiPoli('{{ $poli }}', this); return false;">
            {{ $poli }}
        </a>
    </li>
    @endforeach
</ul>

<div class="row">

    {{-- KOLOM KIRI: Pilih Pasien --}}
    <div class="col-lg-5 mb-4">
        <div class="card shadow" style="border-radius:12px;">
            <div class="card-body p-4">
                <h6 class="font-weight-bold text-primary mb-3">Pilih Pasien</h6>

                <div class="input-group mb-3">
                    <input type="text" class="form-control bg-light border-0"
                         id="searchPasien" placeholder="Search"
                         oninput="filterPasien()">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>

                <div id="listPasien" style="max-height:320px; overflow-y:auto;">
                    @forelse($pasienList as $pasien)
                    <div class="pasien-item d-flex align-items-center p-2 mb-2 rounded"
                         style="cursor:pointer; border:1px solid #e3e6f0; transition:background .2s;"
                         onclick="pilihPasien('{{ addslashes($pasien->nama_pasien) }}', '{{ $pasien->nik_pasien }}', this)"
                         data-nama="{{ strtolower($pasien->nama_pasien) }}"
                         data-nik="{{ strtolower($pasien->nik_pasien) }}">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mr-3"
                             style="width:36px;height:36px;flex-shrink:0;">
                            <i class="fas fa-user text-white" style="font-size:14px;"></i>
                        </div>
                        <div>
                            <div class="font-weight-bold text-gray-800" style="font-size:0.9em;">{{ $pasien->nama_pasien }}</div>
                            <div class="text-muted" style="font-size:0.8em;">NIK: {{ $pasien->nik_pasien }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-users mb-2"></i>
                        <p class="mb-0">Belum ada data pasien</p>
                    </div>
                    @endforelse
                </div>

                <hr>

                <div id="selectedInfo" class="mb-3 d-none">
                    <div class="alert alert-info py-2 mb-2">
                        <i class="fas fa-user-check mr-1"></i>
                        <span id="selectedNama"></span>
                    </div>
                    <textarea id="inputKeluhan" class="form-control mb-2" rows="2"
                        placeholder="Keluhan (opsional)"></textarea>
                </div>

                <button id="btnDaftarkan"
                        onclick="tambahAntrian()"
                        class="btn btn-outline-secondary btn-block"
                        style="border-radius:8px;" disabled>
                    <i class="fas fa-plus mr-1"></i> Tambahkan ke Antrian
                </button>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: Kontrol Antrian --}}
    <div class="col-lg-7 mb-4">
        <div class="card shadow" style="border-radius:12px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="font-weight-bold text-primary mb-0">Kontrol Antrian</h6>
                    <i class="fas fa-ellipsis-v text-gray-400"></i>
                </div>

                {{-- Statistik --}}
                <div class="row text-center mb-3">
                    <div class="col-4">
                        <div class="border rounded p-2">
                            <div class="font-weight-bold text-gray-800" style="font-size:1.4em;" id="statTotal">0</div>
                            <div class="text-muted" style="font-size:0.75em;">Total Hari ini</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded p-2">
                            <div class="font-weight-bold text-warning" style="font-size:1.4em;" id="statMenunggu">0</div>
                            <div class="text-muted" style="font-size:0.75em;">Menunggu</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded p-2">
                            <div class="font-weight-bold text-success" style="font-size:1.4em;" id="statSelesai">0</div>
                            <div class="text-muted" style="font-size:0.75em;">Selesai</div>
                        </div>
                    </div>
                </div>

                {{-- Sedang Dipanggil --}}
                <div class="text-center rounded p-3 mb-3"
                     style="background:#eef2ff; border:1px solid #c7d2fe;">
                    <div class="text-primary font-weight-bold mb-1">Sedang Dipanggil</div>
                    <div style="height:3px;background:#6366f1;border-radius:2px;margin:0 auto 8px;width:40px;"></div>
                    <div id="sedangDipanggil" class="text-muted small">Belum ada antrian aktif</div>
                </div>

                {{-- Tombol Kontrol --}}
                <div class="row mb-3">
                    <div class="col-6 mb-2">
                        <button onclick="panggilBerikutnya()"
                                class="btn btn-outline-primary btn-block" style="border-radius:8px;">
                            <i class="fas fa-step-forward mr-1"></i> Panggil Berikutnya
                        </button>
                    </div>
                    <div class="col-6 mb-2">
                        <button onclick="selesai()"
                                class="btn btn-outline-success btn-block" style="border-radius:8px;">
                            <i class="fas fa-check mr-1"></i> Selesai
                        </button>
                    </div>
                    <div class="col-6 mb-2">
                        <button onclick="panggilUlang()"
                                class="btn btn-outline-secondary btn-block" style="border-radius:8px;">
                            <i class="fas fa-redo mr-1"></i> Panggil Ulang
                        </button>
                    </div>
                    <div class="col-6 mb-2">
                        <button onclick="lewati()"
                                class="btn btn-outline-warning btn-block" style="border-radius:8px;">
                            <i class="fas fa-forward mr-1"></i> Lewati
                        </button>
                    </div>
                </div>

                {{-- Daftar Antrian --}}
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-list text-primary mr-2"></i>
                    <span class="font-weight-bold text-gray-700">Daftar Antrian</span>
                </div>
                <div id="daftarAntrian" style="max-height:220px; overflow-y:auto;">
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p class="mb-0">Memuat data...</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    let poliAktif   = 'Poli Umum';
    let selectedNik  = null;
    let selectedNama = null;

    // Ganti poli aktif
    function gantiPoli(poli, el) {
        poliAktif = poli;
        document.querySelectorAll('#poliTab .nav-link').forEach(a => a.classList.remove('active'));
        el.classList.add('active');
        loadData();
    }

    // Load data antrian via AJAX
    function loadData() {
        fetch(`/antrian/data?poli=${encodeURIComponent(poliAktif)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            // Statistik
            document.getElementById('statTotal').textContent    = data.totalHariIni;
            document.getElementById('statMenunggu').textContent = data.menunggu;
            document.getElementById('statSelesai').textContent  = data.selesai;

            // Sedang dipanggil
            const box = document.getElementById('sedangDipanggil');
            if (data.sedangDipanggil) {
                box.innerHTML = `
                    <div style="font-size:2.8em; font-weight:800; color:#4e73df; line-height:1;">
                        ${String(data.sedangDipanggil.nomor_antrian).padStart(3,'0')}
                    </div>
                    <div style="font-size:1.05em; font-weight:600; color:#333; margin-top:6px;">
                        ${data.sedangDipanggil.nama_pasien}
                    </div>
                `;
            } else {
                box.innerHTML = '<span class="text-muted small">Belum ada antrian aktif</span>';
            }

            // Daftar antrian
            const list = document.getElementById('daftarAntrian');
            if (data.antrian.length === 0) {
                list.innerHTML = `<div class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <p class="mb-0">Belum ada pasien dalam antrian</p>
                </div>`;
            } else {
                list.innerHTML = data.antrian.map((p, i) => `
                    <div class="d-flex align-items-center p-2 mb-1 rounded ${p.status === 'dipanggil' ? 'bg-primary text-white' : 'bg-light'}"
                         style="font-size:0.88em;">
                        <span class="font-weight-bold mr-3">
                            ${String(p.nomor_antrian).padStart(3,'0')}
                        </span>
                        <span class="flex-grow-1">${p.nama_pasien}</span>
                        <span class="${p.status === 'dipanggil' ? 'text-white-50' : 'text-muted'}">
                            ${p.status}
                        </span>
                    </div>
                `).join('');
            }
        });
    }

    // Pilih pasien dari list
    function pilihPasien(nama, nik, el) {
        selectedNama = nama;
        selectedNik  = nik;

        document.querySelectorAll('.pasien-item').forEach(e => e.style.background = '');
        el.style.background = '#eef2ff';

        document.getElementById('selectedNama').textContent = nama + ' — ' + nik;
        document.getElementById('selectedInfo').classList.remove('d-none');

        const btn = document.getElementById('btnDaftarkan');
        btn.disabled = false;
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-primary');
    }

   // Filter pasien
   function filterPasien() {
    const val = document.getElementById('searchPasien').value.toLowerCase().trim();
    document.querySelectorAll('.pasien-item').forEach(el => {
        const nama = el.getAttribute('data-nama') || '';
        const nik  = el.getAttribute('data-nik') || '';
        if (nama.includes(val) || nik.includes(val)) {
            el.classList.remove('pasien-hidden');
        } else {
            el.classList.add('pasien-hidden');
        }
    });
}

    // Helper CSRF
    function getCsrf() {
        return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    }

    // Helper alert
    function showAlert(msg, type = 'success') {
        document.getElementById('alertBox').innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show">
                ${msg}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>`;
        setTimeout(() => document.getElementById('alertBox').innerHTML = '', 4000);
    }

    // Helper POST
    function postJson(url, body) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrf(),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(body)
        }).then(r => r.json());
    }

    // Tambah ke antrian
    function tambahAntrian() {
        if (!selectedNik) return;
        postJson('/antrian/tambah', {
            poli: poliAktif,
            nama_pasien: selectedNama,
            nik_pasien: selectedNik,
            keluhan: document.getElementById('inputKeluhan').value
        }).then(data => {
            showAlert(data.message);
            loadData();
        }).catch(() => showAlert('Gagal menambahkan pasien.', 'danger'));
    }

    // Panggil berikutnya
    function panggilBerikutnya() {
        postJson('/antrian/panggil-berikutnya', { poli: poliAktif })
        .then(data => { showAlert(data.message); loadData(); })
        .catch(() => showAlert('Gagal memanggil antrian.', 'danger'));
    }

    // Selesai
    function selesai() {
        postJson('/antrian/selesai', { poli: poliAktif })
        .then(data => { showAlert(data.message); loadData(); })
        .catch(() => showAlert('Gagal.', 'danger'));
    }

    // Panggil ulang
    function panggilUlang() {
        postJson('/antrian/panggil-ulang', { poli: poliAktif })
        .then(data => { showAlert(data.message); loadData(); })
        .catch(() => showAlert('Gagal.', 'danger'));
    }

    // Lewati
    function lewati() {
        postJson('/antrian/lewati', { poli: poliAktif })
        .then(data => { showAlert(data.message); loadData(); })
        .catch(() => showAlert('Gagal.', 'danger'));
    }

    // Load pertama kali & auto-refresh tiap 10 detik
   loadData();
    setInterval(loadData, 10000);
</script>
<style>
    .pasien-hidden { display: none !important; }
</style>
@endpush