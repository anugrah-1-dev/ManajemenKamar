    @extends('adminlte::page')

    @section('title', 'Manajemen Kamar')

    @section('content_header')
        <h1 class="text-center font-weight-bold">Manajemen Kamar</h1>
    @stop

    @section('content')
        @php
            use App\Helpers\RoomDummy as RD;
        @endphp

        @push('css')
            <link rel="stylesheet" href="{{ asset('css/room.css') }}">
        @endpush

    @section('meta')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection


    <div class="main-container">
        <div class="dashboard-card">
            <div class="card-header-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Dashboard Kamar</h3>
                    <div class="card-tools">
                        <span class="badge badge-success">Total Kamar: {{ $rooms->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="mt-3 ms-3">
                        <x-adminlte-button label="Atur Kapasitas & Kategori" theme="primary" icon="fas fa-edit"
                            data-toggle="modal" data-target="#aturKapasitasKategori" />
                    </div>


                    <div class="col-12 col-md-9 col-lg-6">
                        <x-adminlte-input name="search" placeholder="Cari kamar..." class="search-box">
                            <x-slot name="appendSlot">
                                <x-adminlte-button theme="outline-primary" icon="fas fa-search" />
                            </x-slot>
                        </x-adminlte-input>
                    </div>

                    <form method="POST" action="{{ route('admin.rooms.update-by-kategori') }}">
                        @csrf

                        <x-adminlte-modal id="aturKapasitasKategori" title="Atur Kapasitas Kategori Kamar"
                            theme="primary" icon="fas fa-edit" size="md">

                            <x-adminlte-select name="kategori" label="Kategori Kamar" required>
                                <option value="vvip">VVIP</option>
                                <option value="vip">VIP</option>
                                <option value="barack">Barack</option>
                            </x-adminlte-select>

                            <x-adminlte-input name="kapasitas" label="Kapasitas Baru" type="number" min="1"
                                required />

                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="success" label="Update" icon="fas fa-save" type="submit" />
                            </x-slot>

                        </x-adminlte-modal>
                    </form>




                </div>
            </div>



            <div class="legend-container">
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--success-color);"></div>
                    <span>Kosong</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--warning-color);"></div>
                    <span>Sebagian Terisi</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: var(--danger-color);"></div>
                    <span>Penuh</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background-color: #6c757d;"></div>
                    <span>Tidak Aktif / Dalam Perbaikan</span>
                </div>
            </div>


            {{-- ================= VVIP SECTION ================= --}}
            <div class="room-section">
                <h3 class="section-title">Kamar VVIP</h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putri</div>
                            <div class="room-grid">
                                @foreach (RD::filter($rooms, 'A', 19, 23) as $kamar)
                                    @if ($kamar->nomor_kamar != 'A-12A')
                                        @php
                                            $penghuniAktif = $penghuniAktifPerRoom[$kamar->id] ?? 0;
                                        @endphp

                                        <div class="room-card {{ RD::getStatusClass($kamar, $penghuniAktif) }}"
                                            data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                            data-kamar="{{ $kamar->nomor_kamar }}" data-gender="{{ $kamar->gender }}"
                                            data-kategori="{{ $kamar->kategori }}"
                                            data-kapasitas="{{ $kamar->kapasitas }}"
                                            data-penghuni="{{ $penghuniAktif }}" onclick="openEditModal(this)">

                                            <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                            <span
                                                class="room-status">{{ RD::getStatusText($kamar, $penghuniAktif) }}</span>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putra</div>
                            <div class="room-grid">
                                @foreach (RD::filter($rooms, 'A', 24, 28) as $kamar)
                                    @php
                                        $penghuniAktif = $penghuniAktifPerRoom[$kamar->id] ?? 0;
                                    @endphp

                                    <div class="room-card {{ RD::getStatusClass($kamar, $penghuniAktif) }}"
                                        data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                        data-kamar="{{ $kamar->nomor_kamar }}" data-gender="{{ $kamar->gender }}"
                                        data-kategori="{{ $kamar->kategori }}"
                                        data-kapasitas="{{ $kamar->kapasitas }}" data-penghuni="{{ $penghuniAktif }}"
                                        onclick="openEditModal(this)">

                                        <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                        <span
                                            class="room-status">{{ RD::getStatusText($kamar, $penghuniAktif) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= VIP SECTION ================= --}}
            <div class="room-section">
                <h3 class="section-title">Kamar VIP</h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putri</div>
                            <div class="room-grid">
                                @php
                                    $vipPutri = collect()
                                        ->merge(RD::filter($rooms, 'A', 1, 18))
                                        ->merge(RD::filter($rooms, 'B', 1, 25))
                                        ->merge(RD::filter($rooms, 'C', 1, 25))
                                        ->reject(function ($kamar) {
                                            return $kamar->nomor_kamar === 'A-12A' ||
                                                strtoupper($kamar->kategori) !== 'VIP';
                                        });
                                @endphp

                                @foreach ($vipPutri->unique('nomor_kamar') as $kamar)
                                    <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                        data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                        data-kamar="{{ $kamar->nomor_kamar }}" data-gender="{{ $kamar->gender }}"
                                        data-kategori="{{ $kamar->kategori }}"
                                        data-kapasitas="{{ $kamar->kapasitas }}"
                                        data-penghuni="{{ $kamar->penghuni }}" onclick="openEditModal(this)">
                                        <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                        <span class="room-status">{{ RD::getStatusText($kamar) }}</span>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putra</div>
                            <div class="room-grid">
                                @php
                                    $vipPutra = collect()
                                        ->merge(
                                            RD::filter($rooms, 'A', 29, 46, 'putra')->reject(function ($k) {
                                                return $k->nomor_kamar === 'A-35' ||
                                                    ($k->nomor_kamar >= 'A-24' && $k->nomor_kamar <= 'A-28') ||
                                                    strtoupper($k->kategori) !== 'VIP';
                                            }),
                                        )
                                        ->merge(
                                            RD::filter($rooms, 'B', 26, 50, 'putra')->reject(
                                                fn($k) => strtoupper($k->kategori) !== 'VIP',
                                            ),
                                        )
                                        ->merge(
                                            RD::filter($rooms, 'C', 26, 50, 'putra')->reject(
                                                fn($k) => strtoupper($k->kategori) !== 'VIP',
                                            ),
                                        );
                                @endphp

                                @foreach ($vipPutra->unique('nomor_kamar') as $kamar)
                                    <div class="room-card {{ RD::getStatusClass($kamar) }}"
                                        data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                        data-kamar="{{ $kamar->nomor_kamar }}" data-gender="{{ $kamar->gender }}"
                                        data-kategori="{{ $kamar->kategori }}"
                                        data-kapasitas="{{ $kamar->kapasitas }}"
                                        data-penghuni="{{ $kamar->penghuni }}" onclick="openEditModal(this)">
                                        <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                        <span class="room-status">{{ RD::getStatusText($kamar) }}</span>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= BARACK SECTION ================= --}}
            <div class="room-section">
                <h3 class="section-title">Kamar Barack</h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putri</div>
                            <div class="room-grid">
                                @php $kamarPutriBarack = $rooms->firstWhere('nomor_kamar', 'A-12A'); @endphp
                                @if ($kamarPutriBarack)
                                    <div class="room-card {{ RD::getStatusClass($kamarPutriBarack) }}"
                                        data-id="{{ $kamarPutriBarack->id }}"
                                        data-nama="{{ $kamarPutriBarack->nomor_kamar }}"
                                        data-kamar="{{ $kamarPutriBarack->nomor_kamar }}"
                                        data-gender="{{ $kamarPutriBarack->gender }}"
                                        data-kategori="{{ $kamarPutriBarack->kategori }}"
                                        data-kapasitas="{{ $kamarPutriBarack->kapasitas }}"
                                        data-penghuni="{{ $kamarPutriBarack->penghuni }}"
                                        onclick="openEditModal(this)">

                                        <span class="room-number">{{ $kamarPutriBarack->nomor_kamar }}</span>
                                        <span class="room-status">{{ RD::getStatusText($kamarPutriBarack) }}</span>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putra</div>
                            <div class="room-grid">
                                @php $kamarPutraBarack = $rooms->firstWhere('nomor_kamar', 'A-35'); @endphp
                                @if ($kamarPutraBarack)
                                    <div class="room-card {{ RD::getStatusClass($kamarPutraBarack) }}"
                                        data-id="{{ $kamarPutraBarack->id }}"
                                        data-nama="{{ $kamarPutraBarack->nomor_kamar }}"
                                        data-kamar="{{ $kamarPutraBarack->nomor_kamar }}"
                                        data-gender="{{ $kamarPutraBarack->gender }}"
                                        data-kategori="{{ $kamarPutraBarack->kategori }}"
                                        data-kapasitas="{{ $kamarPutraBarack->kapasitas }}"
                                        data-penghuni="{{ $kamarPutraBarack->penghuni }}"
                                        onclick="openEditModal(this)">
                                        <span class="room-number">{{ $kamarPutraBarack->nomor_kamar }}</span>
                                        <span class="room-status">{{ RD::getStatusText($kamarPutraBarack) }}</span>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Edit Room -->
    <div class="modal fade" id="roomModal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomModalLabel">Edit Kamar</h5>
                </div>
                <div class="modal-body">
                    <form id="roomEditForm">
                        <input type="hidden" id="modalRoomId" name="id">

                        <div class="mb-3">
                            <label for="modalRoomNama" class="form-label">Nomor Kamar</label>
                            <input type="text" class="form-control" id="modalRoomNama" name="nomor_kamar"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label for="modalRoomGender" class="form-label">Gender</label>
                            <select class="form-select" id="modalRoomGender" name="gender">
                                <option value="putra">PUTRA</option>
                                <option value="putri">PUTRI</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="modalRoomKategori" class="form-label">Kategori</label>
                            <select class="form-select" id="modalRoomKategori" name="kategori">
                                <option value="vvip">VVIP</option>
                                <option value="vip">VIP</option>
                                <option value="barack">BARACK</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="modalRoomStatus" class="form-label">Status Kamar</label>
                            <select class="form-select" id="modalRoomStatus" name="status">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="modalRoomKapasitas" class="form-label">Kapasitas</label>
                            <input type="number" class="form-control" id="modalRoomKapasitas" name="kapasitas"
                                min="1">
                        </div>

                        <div class="mb-3">
                            <label for="modalRoomPenghuni" class="form-label">Penghuni</label>
                            <input type="number" class="form-control" id="modalRoomPenghuni" name="penghuni"
                                min="0" readonly>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Penghuni Kamar</label>
                            <ul id="listPenghuni" class="list-group">

                            </ul>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="saveRoomChanges()">Simpan
                        Perubahan</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Pindah Peserta -->
    <div class="modal fade" id="modalPindahPeserta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pindahkan Peserta</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div id="pesertaListPindah">
                        <!-- Daftar peserta akan dimuat di sini via JS -->
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Jika kamu ternyata pakai Bootstrap 4 -->
                    <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                </div>
            </div>
        </div>
    </div>




    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS (include Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (count($penghuniExpired) > 0)
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Ada Penghuni Melebihi Durasi',
                html: `
                <ul style="text-align: left;">
                    @foreach ($penghuniExpired as $p)
                        <li>
                            <strong>{{ $p['nama'] }}</strong> - Kamar <strong>{{ $p['nama_kamar'] }}</strong><br>
                            Durasi: {{ $p['durasi'] }} (Expired: {{ $p['expired_at'] }})<br>
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $p['no_hp'])) }}" target="_blank">Hubungi via WA</a>
                        </li><br>
                    @endforeach
                </ul>
            `,
                confirmButtonText: 'OK',
                width: 600
            });
        </script>
    @endif


    {{-- Interaksi JS --}}
    <script>
        document.querySelectorAll('.room-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.room-card').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');

                const roomNumber = this.getAttribute('data-kamar');
                console.log('Kamar dipilih:', roomNumber);

                // 🔥 Tambahkan ini agar modal terbuka
                openEditModal(this);
            });
        });


        // Search functionality
        const searchInput = document.querySelector('input[name="search"]');
        const searchButton = searchInput.nextElementSibling.querySelector('button');

        searchButton.addEventListener('click', function() {
            const searchTerm = searchInput.value.toLowerCase();
            const rooms = document.querySelectorAll('.room-card');

            rooms.forEach(room => {
                const roomNumber = room.getAttribute('data-kamar').toLowerCase();
                if (roomNumber.includes(searchTerm)) {
                    room.style.display = 'flex';
                    room.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    room.classList.add('selected');
                    setTimeout(() => room.classList.remove('selected'), 2000);
                } else {
                    room.style.display = 'none';
                }
            });
        });

        // Press Enter to search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchButton.click();
            }
        });
    </script>

    <script>
        const durasiToDays = {
            perhari: 0.1,
            satu_minggu: 7,
            dua_minggu: 14,
            satu_bulan: 30,
            dua_bulan: 60,
            tiga_bulan: 90,
            enam_bulan: 180,
            satu_tahun: 365
        };

        function openEditModal(el) {
            const id = el.dataset.id;
            $('#modalRoomId').val(id);
            $('#modalRoomNama').val(el.dataset.nama);
            $('#modalRoomGender').val(el.dataset.gender);
            $('#modalRoomKategori').val(el.dataset.kategori);
            $('#modalRoomKapasitas').val(el.dataset.kapasitas);
            $('#modalRoomPenghuni').val(el.dataset.penghuni);
            $('#modalRoomStatus').val(el.dataset.status);

            $('#listPenghuni').html('<li class="list-group-item text-muted">Memuat data...</li>');

            $.get(`/admin/rooms/${id}/penghuni`, function(data) {
                $('#listPenghuni').empty();

                if (!data || data.length === 0) {
                    $('#listPenghuni').append('<li class="list-group-item text-muted">Belum ada penghuni.</li>');
                    return;
                }

                data.forEach(function(p) {
                    // Kalau status bukan diterima → langsung skip
                    if (p.status !== 'diterima') {
                        $('#listPenghuni').append(`
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>${$('<div>').text(p.nama_lengkap).html()}</strong><br>
                    <small class="text-muted">Durasi: ${p.durasi_paket}</small><br>
                    <span class="badge bg-secondary">Belum diterima</span>
                </div>
            </li>
        `);
                        return;
                    }

                    const durasiHari = durasiToDays[p.durasi_paket] || 0;
                    const startDate = p.period && p.period.date ? new Date(p.period.date) : new Date(p
                        .updated_at);
                    const endDate = new Date(startDate);
                    endDate.setDate(endDate.getDate() + durasiHari);

                    const now = new Date();
                    const timeDiff = endDate - now;

                    let countdownText = '';
                    let kontakWA = '';
                    let kickButton = '';

                    if (timeDiff > 0) {
                        const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeDiff / (1000 * 60 * 60)) % 24);
                        const minutes = Math.floor((timeDiff / (1000 * 60)) % 60);
                        countdownText =
                            `<span class="badge bg-success">Sisa: ${days}h ${hours}j ${minutes}m</span>`;
                    } else {
                        countdownText = `<span class="badge bg-danger">Sudah berakhir</span>`;
                        if (p.no_hp) {
                            const cleanedNoHP = p.no_hp.replace(/^0/, '62').replace(/\D/g, '');
                            kontakWA =
                                `<br><a href="https://wa.me/${cleanedNoHP}" target="_blank" class="text-success">Hubungi via WA</a>`;
                        }
                        kickButton =
                            `<button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="kickPenghuni('${p.trx_id}', event)">Keluarkan</button>`;
                    }

                    const formattedDate = startDate.toLocaleString('id-ID', {
                        timeZone: 'Asia/Jakarta',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    

                    $('#listPenghuni').append(`
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <strong>${$('<div>').text(p.nama_lengkap).html()}</strong><br>
                <small class="text-muted">Durasi: ${p.durasi_paket}</small><br>
                ${countdownText}
                ${kontakWA}
                ${kickButton}
            </div>
            <small class="text-muted">${formattedDate}</small>
        </li>
    `);
                });



            }).fail(function() {
                $('#listPenghuni').html('<li class="list-group-item text-danger">Gagal memuat data penghuni.</li>');
            });

            const modal = new bootstrap.Modal(document.getElementById('roomModal'));
            modal.show();
        }


        function kickPenghuni(trx_id, event) {
            if (event) event.preventDefault(); // cegah submit form

            Swal.fire({
                title: 'Yakin?',
                text: "Penghuni ini akan dikeluarkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, keluarkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Panggil AJAX kalau user klik 'Ya'
                    kickPenghuniAjax(trx_id);
                }
            });
        }

        function kickPenghuniAjax(trx_id) {
            $.ajax({
                url: `/admin/rooms/penghuni/${trx_id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Penghuni berhasil dikeluarkan.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // update UI
                        $('#listPenghuni').find(`[data-trx="${trx_id}"]`).remove();
                        if ($('#listPenghuni li').length === 0) {
                            $('#listPenghuni').html(
                                '<li class="list-group-item text-muted">Tidak ada penghuni</li>'
                            );
                        }
                        if (response.room && response.room.id) {
                            let roomCard = $(`#room-${response.room.id}`);
                            roomCard.find('.jumlah-penghuni').text(response.room.penghuni ?? 0);
                            roomCard.removeClass('room-empty room-partial room-full room-nonaktif')
                                .addClass(response.room.status_class || '');
                        }

                        // kasih jeda 1,5 detik sebelum reload
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    } else {
                        Swal.fire('Gagal', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error',
                        'Terjadi kesalahan saat mengeluarkan penghuni.\nStatus: ' + xhr.status,
                        'error'
                    );
                }
            });
        }



        function saveRoomChanges() {
            const id = $('#modalRoomId').val();
            const formData = $('#roomEditForm').serialize() + '&_method=PUT';

            $.ajax({
                url: `/admin/rooms/${id}`,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    const status = $('#modalRoomStatus').val();
                    const penghuni = parseInt($('#modalRoomPenghuni').val());

                    if (status === 'nonaktif' && penghuni > 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Kamar masih berisi penghuni!',
                            text: 'Silakan pindahkan peserta terlebih dahulu.',
                            confirmButtonText: 'Pindahkan Sekarang'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                bukaModalPindahPeserta(id);
                            }
                        });
                        return;
                    }

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Perubahan berhasil disimpan'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal menyimpan',
                            text: data.message || 'Terjadi kesalahan.'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menyimpan perubahan.'
                    });
                }
            });
        }

        // 🔄 Buka modal untuk memindahkan peserta
        function bukaModalPindahPeserta(roomId) {
            $.ajax({
                url: `/admin/rooms/${roomId}/peserta-detail`,
                type: 'GET',
                success: function(data) {
                    let html = '';

                    if (data.peserta.length > 0) {
                        data.peserta.forEach(p => {

                            const rooms = data.filtered_rooms[p.id] || [];
                            const options = rooms.map(r =>
                                `<option value="${r.id}">${r.nomor_kamar}</option>`
                            ).join('');

                            html += `
                        <div class="d-flex align-items-center justify-content-between border p-2 mb-2">
                            <div>
                                <strong>${p.nama_lengkap}</strong><br>
                                <small>${p.trx_id ?? '-'} | ${p.gender}</small>
                            </div>
                            <div>
                                <select class="form-select d-inline-block w-auto" id="targetRoom_${p.id}">
                                    <option value="">Pilih kamar tujuan</option>
                                    ${options}
                                </select>
                                <button class="btn btn-sm btn-primary ms-2 pindah-btn" data-id="${p.id}">
                                    Pindahkan
                                </button>
                            </div>
                        </div>
                    `;
                        });
                    } else {
                        html = '<p class="text-center">Tidak ada peserta di kamar ini.</p>';
                    }

                    $('#pesertaListPindah').html(html);

                    // 🧭 Tampilkan modal Bootstrap
                    const modal = new bootstrap.Modal(document.getElementById('modalPindahPeserta'));
                    modal.show();
                },
                error: function() {
                    Swal.fire('Error', 'Gagal mengambil data peserta.', 'error');
                }
            });
        }

        // 🔁 Event handler untuk tombol "Pindahkan"
        $(document).on('click', '.pindah-btn', function() {
            const pesertaId = $(this).data('id');
            const targetRoomId = $(`#targetRoom_${pesertaId}`).val();


            if (!targetRoomId) {
                Swal.fire('Peringatan', 'Silakan pilih kamar tujuan.', 'warning');
                return;
            }

            pindahPeserta(pesertaId, targetRoomId);
        });

        // 🔧 Fungsi untuk memindahkan peserta ke kamar baru
        function pindahPeserta(pesertaId, targetRoomId) {
            console.log('Memindahkan peserta ID:', pesertaId);

            $.ajax({
                url: `/admin/peserta/${pesertaId}/pindah-kamar`,
                type: 'POST',
                data: {
                    target_room_id: targetRoomId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire('Berhasil', 'Peserta berhasil dipindahkan.', 'success');
                        $(`#targetRoom_${pesertaId}`).closest('.d-flex').remove();
                    } else {
                        Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                    }

                },


                error: function() {
                    Swal.fire('Error', 'Gagal memproses perpindahan.', 'error');
                }
            });
        }
    </script>




@stop
