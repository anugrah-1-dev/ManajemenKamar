<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $program->nama }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- jQuery UI Autocomplete Stylesheet -->

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="text-center mb-4">
                    <h1 class="fw-bold">{{ $program->nama }}</h1>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                @if ($program->thumbnail)
                                    <div class="text-center mb-3">

                                        <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                            class="img-fluid rounded" alt="{{ $program->nama }}">
                                    </div>
                                @endif

                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-light">Harga</th>
                                        <td>Rp {{ number_format($program->harga, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Jadwal</th>
                                        <td>{{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M Y') }} -

                                            {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M Y') }}</td>

                                    </tr>
                                    <tr>
                                        <th class="bg-light">Kuota</th>
                                        <td>{{ $program->kuota }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Fasilitas</th>
                                        <td>
                                            @php
                                                $features = $program->features_program;
                                                if (is_string($features)) {
                                                    $decoded = json_decode($features, true);

                                                    $features =
                                                        json_last_error() === JSON_ERROR_NONE && is_array($decoded)
                                                            ? $decoded
                                                            : explode("\n", $features);
                                                }
                                            @endphp

                                            @if (!empty($features) && is_array($features))
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($features as $fitur)
                                                        <li>{{ \App\Helpers\FeatureHelper::getFeatureIcon($fitur) }}
                                                            {{ trim($fitur) }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <em>Tidak ada fasilitas tersedia.</em>
                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status</th>
                                        <td>
                                            @if ($program->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-primary shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Formulir Pendaftaran</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">Silakan lengkapi data diri Anda untuk mendaftar program ini.
                                </p>
                                <div class="card-body">

                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    @php

                                        $activePeriods = $periods->where('is_active', 1);
                                    @endphp

                                    <form method="POST"
                                        action="{{ route('public.program.offline.daftar', $program->slug) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-person-fill"></i> Nama
                                            </label>
                                            <input type="text" name="nama_lengkap" class="form-control"
                                                value="{{ old('nama_lengkap') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row g-2">
                                                <!-- Kolom Tempat Lahir -->
                                                <div class="col-6">
                                                    <label class="form-label d-block">
                                                        <i class="bi bi-geo-alt-fill"></i> Tempat Lahir
                                                    </label>
                                                    <input type="text" name="tempat_lahir" class="form-control"
                                                        value="{{ old('tempat_lahir') }}"
                                                        placeholder="Contoh: Surabaya" required>
                                                </div>

                                                <!-- Kolom Tanggal Lahir -->
                                                <div class="col-6">
                                                    <label class="form-label d-block">
                                                        <i class="bi bi-calendar-event-fill"></i> Tanggal Lahir
                                                    </label>
                                                    <input type="date" name="tanggal_lahir" class="form-control"
                                                        value="{{ old('tanggal_lahir') }}" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-gender-ambiguous"></i>
                                                Gender</label>
                                            <select name="gender" class="form-select" required>
                                                <option value="" disabled selected>-- Pilih Gender --</option>
                                                <option value="Laki-laki"
                                                    {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                                </option>
                                                <option value="Perempuan"
                                                    {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-telephone-fill"></i> No.
                                                HP</label>
                                            <input type="text" name="no_hp" class="form-control"
                                                value="{{ old('no_hp') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Kota
                                                asal</label>
                                            <input type="text" name="asal_kota" class="form-control"
                                                value="{{ old('asal_kota') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email') }}" required>
                                        </div>


                                        {{-- ====================================================== --}}
                                        {{-- PERUBAHAN DIMULAI: Tambah Ukuran Seragam --}}
                                        @if (in_array(strtolower($program->program_bahasa), ['nhc', 'inggris', 'mandarin', 'jerman']))
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-tag"></i> Ukuran Seragam
                                                </label>
                                                <select name="ukuran_seragam" class="form-select" required>
                                                    <option value="">Pilih Ukuran Seragam</option>
                                                    <option value="S"
                                                        {{ old('ukuran_seragam') == 'S' ? 'selected' : '' }}>S</option>
                                                    <option value="M"
                                                        {{ old('ukuran_seragam') == 'M' ? 'selected' : '' }}>M</option>
                                                    <option value="L"
                                                        {{ old('ukuran_seragam') == 'L' ? 'selected' : '' }}>L</option>
                                                    <option value="XL"
                                                        {{ old('ukuran_seragam') == 'XL' ? 'selected' : '' }}>XL
                                                    </option>
                                                    <option value="XXL"
                                                        {{ old('ukuran_seragam') == 'XXL' ? 'selected' : '' }}>XXL
                                                    </option>
                                                </select>
                                            </div>
                                        @endif

                                        {{-- <div class="mb-3">
                                            <label class="form-label">
                                                <i class="bi bi-house-fill"></i> Akomodasi (Camp Reguler) - Optional
                                            </label>
                                            <select name="akomodasi" class="form-select" id="campSelect">
                                                <option value="" data-harga="0">Pilih Akomodasi (Opsional)
                                                </option>

                                                <option value="reguler" data-harga="180000">Reguler (Rp 180.000)
                                                </option>
                                                   </select>
                                        </div> --}}
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-person-lines-fill"></i> No. HP
                                                Wali</label>
                                            <input type="text" name="no_wali" class="form-control"
                                                value="{{ old('no_wali') }}">
                                        </div>

                                        @if (strtolower($program->program_bahasa) === 'arab')
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-house-fill"></i> Akomodasi (Camp Reguler) -
                                                    Optional
                                                </label>
                                                <select name="akomodasi" class="form-select" id="campSelect">
                                                    <option value="" data-harga="0">Pilih Akomodasi (Opsional)
                                                    </option>
                                                    <option value="reguler" data-harga="180000">Reguler (Rp 180.000)
                                                    </option>
                                                </select>
                                            </div>
                                        @endif


                                        {{-- Camp VIP dari database --}}
                                        {{-- @foreach ($camps as $camp)
                                                    @if ($camp->kategori === 'VIP')
                                                        <option value="camp-{{ $camp->id }}"
                                                            data-harga="{{ $camp->harga }}">
                                                            {{ $camp->nama }} (VIP) - Rp
                                                            {{ number_format($camp->harga, 0, ',', '.') }}
                                                        </option>
                                                    @endif
                                                @endforeach --}}


                                        {{-- Tempat tampil harga
                                        <div id="akomodasi-harga" class="mt-2 fw-bold text-success"></div>
 --}}



                                        {{-- <div class="duration-options-container" id="durasiContainer"
                                            style="display:none;">
                                            @php
                                                $durasiOptions = [
                                                    'perhari' => [
                                                        'label' => 'Per Day',
                                                        'harga' => $camp->harga_perhari ?? 0,
                                                    ],
                                                    'satu_minggu' => [
                                                        'label' => '1 Week',
                                                        'harga' => $camp->harga_satu_minggu ?? 0,
                                                    ],
                                                    'dua_minggu' => [
                                                        'label' => '2 Weeks',
                                                        'harga' => $camp->harga_dua_minggu ?? 0,
                                                    ],
                                                    'satu_bulan' => [
                                                        'label' => '1 Month',
                                                        'harga' => $camp->harga_satu_bulan ?? 0,
                                                    ],
                                                    'dua_bulan' => [
                                                        'label' => '2 Months',
                                                        'harga' => $camp->harga_dua_bulan ?? 0,
                                                    ],
                                                    'tiga_bulan' => [
                                                        'label' => '3 Months',
                                                        'harga' => $camp->harga_tiga_bulan ?? 0,
                                                    ],
                                                    'enam_bulan' => [
                                                        'label' => '6 Months',
                                                        'harga' => $camp->harga_enam_bulan ?? 0,
                                                    ],
                                                    'satu_tahun' => [
                                                        'label' => '1 Year',
                                                        'harga' => $camp->harga_satu_tahun ?? 0,
                                                    ],
                                                ];
                                            @endphp
                                            <select name="durasi" class="form-select" id="durasiSelect">
                                                <option value="">Pilih Durasi</option>
                                                @foreach ($durasiOptions as $key => $option)
                                                    <option value="{{ $key }}"
                                                        data-harga="{{ $option['harga'] }}">
                                                        {{ $option['label'] }} -
                                                        Rp.{{ number_format($option['harga'], 0, ',', '.') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                        {{-- <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const campSelect = document.getElementById("campSelect");
                                                const durasiContainer = document.getElementById("durasiContainer");

                                                campSelect.addEventListener("change", function() {
                                                    if (this.value) {
                                                        durasiContainer.style.display = "block"; // tampilkan jika ada camp dipilih
                                                    } else {
                                                        durasiContainer.style.display = "none"; // sembunyikan jika kosong
                                                    }
                                                });
                                            });
                                        </script> --}}






                                        <br>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-wallet2"></i> Metode Pembayaran
                                            </label>
                                            <div class="d-flex flex-wrap gap-3">

                                                {{-- Tunai --}}
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="payment_type" id="pay_tunai" value="tunai"
                                                        {{ old('payment_type') == 'tunai' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="pay_tunai">Bayar Tunai
                                                        (Cash)</label>
                                                </div>

                                                {{-- Transfer --}}
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="payment_type" id="pay_transfer" value="transfer"
                                                        {{ old('payment_type') == 'transfer' ? 'checked' : '' }}
                                                        required>
                                                    <label class="form-check-label" for="pay_transfer">Transfer
                                                        Bank</label>
                                                </div>
                                                <!-- Skema pembayaran (hanya muncul untuk non-tunai & program NHC) -->
                                                <div class="mb-3" id="skemaContainer" style="display: none;">
                                                    <div class="card border-primary shadow-sm">
                                                        <div class="card-header bg-primary text-white fw-bold">
                                                            <i class="bi bi-card-checklist"></i> Pilih Skema Pembayaran
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="d-flex flex-column gap-3" id="paymentOptions">
                                                                <!-- Full Payment -->
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="payment_method" id="pay_full"
                                                                        value="full" checked>
                                                                    <label class="form-check-label fw-bold"
                                                                        for="pay_full">
                                                                        💰 Full Payment (<span id="fullAmount"></span>)
                                                                    </label>
                                                                </div>
                                                                <!-- DP -->
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="payment_method" id="pay_dp"
                                                                        value="dp" data-dp="500000">
                                                                    <label class="form-check-label" for="pay_dp">
                                                                        💳 Bayar DP Rp <span
                                                                            class="fw-bold">500.000</span> —
                                                                        Sisa <span id="sisaDP"></span>
                                                                    </label>
                                                                    <small class="d-block mt-1 poppins-text"
                                                                        style="font-size: 0.85em;">
                                                                        Pelunasan dilakukan di office Bieplus
                                                                    </small>
                                                                </div>


                                                                <style>
                                                                    /* Tambahan CSS */
                                                                    .poppins-text {
                                                                        font-family: 'Poppins', sans-serif;
                                                                    }
                                                                </style>
                                                                <!-- Hidden input untuk tenor cicilan -->
                                                                {{-- <input type="hidden" name="installment_months"
                                                                    id="installment_months"> --}}

                                                                <!-- Cicilan 2 Bulan -->
                                                                {{-- <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="payment_method" id="pay_2x"
                                                                        value="cicilan" data-months="2">
                                                                    <label class="form-check-label" for="pay_2x">
                                                                        📆 Cicilan 2x Perbulan — DP <span
                                                                            class="fw-bold" id="dp2"></span>,
                                                                        Pelunasan <span id="sisa2"></span>
                                                                    </label>
                                                                </div> --}}

                                                                <!-- Cicilan 6 Bulan -->
                                                                {{-- <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="payment_method" id="pay_6x"
                                                                        value="cicilan" data-months="6">
                                                                    <label class="form-check-label" for="pay_6x">
                                                                        🗓️ Cicilan 6x Perbulan — DP <span
                                                                            class="fw-bold" id="dp6"></span>,
                                                                        Per bulan <span id="cicil6"></span>
                                                                    </label>
                                                                </div> --}}

                                                                <!-- Cicilan 10 Bulan -->
                                                                {{-- <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="payment_method" id="pay_10x"
                                                                        value="cicilan" data-months="10">
                                                                    <label class="form-check-label" for="pay_10x">
                                                                        📅 Cicilan 10x Perbulan — DP <span
                                                                            class="fw-bold" id="dp10"></span>,
                                                                        Per bulan <span id="cicil10"></span>
                                                                    </label>
                                                                </div> --}}



                                                            </div>

                                                            <div id="noteCicilan" class="form-text mt-3 text-muted"
                                                                style="display: none;">
                                                                Jika memilih cicilan, Anda wajib membayar DP terlebih
                                                                dahulu.
                                                                Sisa akan dibayar sesuai jumlah bulan yang dipilih.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        const totalHarga = {{ $program->harga }}; // harga program dari backend
                                                        const radios = document.querySelectorAll('input[name="payment_method"]');
                                                        const totalPreview = document.getElementById("totalPreview");
                                                        const dpRadio = document.getElementById("pay_dp");
                                                        const sisaDPSpan = document.getElementById("sisaDP");

                                                        // Inisialisasi sisa DP di label
                                                        if (dpRadio && sisaDPSpan) {
                                                            const dpAmount = 500000; // FIXED
                                                            const sisa = totalHarga - dpAmount;
                                                            sisaDPSpan.textContent = "Rp " + sisa.toLocaleString("id-ID");
                                                        }

                                                        // Event listener ketika radio berubah
                                                        radios.forEach(radio => {
                                                            radio.addEventListener("change", function() {
                                                                if (this.value === "full") {
                                                                    totalPreview.textContent = "Rp " + totalHarga.toLocaleString("id-ID");

                                                                } else if (this.value === "cicilan") {
                                                                    const cicilanDP = totalHarga / 2; // cicilan tetap setengah
                                                                    totalPreview.textContent = "DP Rp " + cicilanDP.toLocaleString("id-ID");

                                                                } else if (this.value === "dp") {
                                                                    const dpAmount = 500000; // FIXED
                                                                    totalPreview.textContent = "DP Rp " + dpAmount.toLocaleString("id-ID");
                                                                }

                                                            });
                                                        });
                                                    });
                                                </script>



                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        function toggleSkema() {
                                                            const selectedChannel = document.querySelector('input[name="payment_type"]:checked');
                                                            const skema = document.getElementById('skemaContainer');
                                                            const note = document.getElementById('noteCicilan');
                                                            // Kondisi: tampilkan hanya jika non-tunai dan program = NHC
                                                            const isNonTunai = selectedChannel && (selectedChannel.value === 'transfer' || selectedChannel
                                                                .value === 'qris');
                                                            // Tampilkan skema hanya jika program adalah NHC — gunakan data dari blade
                                                            const isNHC = "{{ strtolower($program->program_bahasa) }}" === 'nhc';
                                                            if (isNonTunai && isNHC) {
                                                                skema.style.display = 'block';
                                                            } else {
                                                                skema.style.display = 'none';
                                                                note.style.display = 'none';
                                                            }
                                                        }

                                                        document.querySelectorAll('input[name="payment_type"]').forEach(r => r.addEventListener('change',
                                                            toggleSkema));
                                                        document.getElementById('payment_method')?.addEventListener('change', function() {
                                                            document.getElementById('noteCicilan').style.display = this.value === 'cicilan' ? 'block' :
                                                                'none';
                                                        });

                                                        toggleSkema(); // initial
                                                    });
                                                </script>

                                                {{-- cicil --}}
                                                <script>
                                                    document.addEventListener("DOMContentLoaded", function() {
                                                        const hargaProgram = {{ $program->harga ?? 0 }}; // harga dari backend
                                                        const pajak = 0.00; // contoh 5% per bulan

                                                        // Hitung Full Payment
                                                        document.getElementById("fullAmount").innerText = formatRupiah(hargaProgram);

                                                        // Hitung DP & cicilan
                                                        function hitungCicilan(bulan, dpElement, sisaElement) {
                                                            const dp = hargaProgram / 2;
                                                            let sisa = hargaProgram - dp;
                                                            let bunga = sisa * pajak * bulan; // total bunga
                                                            sisa += bunga;
                                                            const perBulan = sisa / bulan;

                                                            document.getElementById(dpElement).innerText = formatRupiah(dp);
                                                            if (sisaElement.includes("cicil")) {
                                                                document.getElementById(sisaElement).innerText = formatRupiah(perBulan) + " x" + bulan;
                                                            } else {
                                                                document.getElementById(sisaElement).innerText = formatRupiah(sisa);
                                                            }
                                                        }

                                                        hitungCicilan(2, "dp2", "sisa2");
                                                        // hitungCicilan(6, "dp6", "cicil6");
                                                        // hitungCicilan(10, "dp10", "cicil10");

                                                        function formatRupiah(angka) {
                                                            return "Rp" + angka.toLocaleString("id-ID");
                                                        }

                                                        // // Tampilkan note cicilan kalau pilih cicilan
                                                        // document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                                                        //     radio.addEventListener("change", function() {
                                                        //         const note = document.getElementById("noteCicilan");
                                                        //         if (this.value !== "full") {
                                                        //             note.style.display = "block";
                                                        //         } else {
                                                        //             note.style.display = "none";
                                                        //         }
                                                        //     });
                                                        // });

                                                        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                                                            radio.addEventListener('change', function() {
                                                                const note = document.getElementById('noteCicilan');
                                                                if (this.value === 'cicilan') {
                                                                    document.getElementById('installment_months').value = this.dataset.months;
                                                                    note.style.display = 'block';
                                                                } else {
                                                                    document.getElementById('installment_months').value = '';
                                                                    note.style.display = 'none';
                                                                }
                                                            });
                                                        });


                                                    });
                                                </script>


                                                {{-- Qris muncul hanya jika bahasa == mandarin --}}
                                                @if (strtolower($program->program_bahasa) === 'mandarin')
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="payment_type" id="pay_qris" value="qris"
                                                            {{ old('payment_type') == 'qris' ? 'checked' : '' }}
                                                            required>
                                                        <label class="form-check-label" for="pay_qris">QRIS</label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="mb-3" id="bankDropdown" style="display: none;">
                                            <label class="form-label fw-bold"><i class="bi bi-bank"></i> Pilih Bank
                                                Tujuan</label>
                                            <select name="bank_id" class="form-select"
                                                {{ old('payment_type') == 'transfer' ? 'required' : '' }}>
                                                <option value="">-- Pilih Bank --</option>
                                                @if (isset($banks) && $banks->isNotEmpty())
                                                    @foreach ($banks as $bank)
                                                        <option value="{{ $bank->id }}"
                                                            {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                                            {{ $bank->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-bus-front-fill"></i>
                                                Transportasi
                                                (Optional)</label>
                                            <select name="transport_id" class="form-select" id="transportSelect">
                                                <option value="" data-harga="0">Pilih Transportasi </option>
                                                @foreach ($transports as $transport)
                                                    <option value="{{ $transport->id }}"
                                                        data-harga="{{ $transport->price }}">
                                                        {{ $transport->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Preview total --}}
                                        <div
                                            class="d-flex align-items-center border rounded p-3 bg-light mt-3 shadow-sm">
                                            <strong class="me-2">Total:</strong>
                                            <span id="totalPreview" class="fw-bold text-success">
                                                Rp{{ number_format($program->harga, 0, ',', '.') }}
                                            </span>

                                            <a href="javascript:void(0)" id="btnLihatTotal"
                                                class="ms-auto btn btn-sm btn-outline-primary rounded-pill px-3">
                                                Lihat Detail
                                            </a>
                                        </div>

                                        {{-- Modal struk --}}
                                        <div class="modal fade" id="modalTotal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                <div class="modal-content rounded-3 shadow-lg">
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title fw-bold">Rincian Pembayaran</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <span>Harga Program</span>
                                                            <span id="hargaProgram">
                                                                Rp{{ number_format($program->harga, 0, ',', '.') }}
                                                            </span>
                                                        </div>

                                                        <div class="text-end mt-1" id="noteTotal"></div>

                                                        <div class="d-flex justify-content-between mb-2">
                                                            <span>Transportasi</span>
                                                            <span id="hargaTransport">Rp0</span>
                                                        </div>

                                                        @if (strtolower($program->program_bahasa) === 'arab')
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span>Akomodasi Camp (Reguler)</span>
                                                                <span id="hargaCamp">Rp0</span>
                                                            </div>
                                                        @endif

                                                        <hr>
                                                        <div
                                                            class="d-flex justify-content-between fw-bold fs-5 text-primary">
                                                            <span>Total</span>
                                                            <span id="totalModal">
                                                                Rp{{ number_format($program->harga, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                let basePrice = {{ $program->harga }};
                                                let selectTransport = document.getElementById("transportSelect");
                                                let selectCamp = document.getElementById("campSelect");
                                                let btnLihatTotal = document.getElementById("btnLihatTotal");

                                                let hargaProgram = document.getElementById("hargaProgram");
                                                let hargaTransport = document.getElementById("hargaTransport");
                                                let hargaCamp = document.getElementById("hargaCamp");
                                                let totalPreview = document.getElementById("totalPreview");
                                                let totalModal = document.getElementById("totalModal");

                                                let noteTotal = document.getElementById("noteTotal") ?? null;

                                                let paymentRadios = document.querySelectorAll('input[name="payment_method"]');
                                                let currentPayment = "full";

                                                let total = basePrice;

                                                function updateTotal() {
                                                    let transportPrice = selectTransport?.selectedOptions[0]?.dataset.harga ?
                                                        parseInt(selectTransport.selectedOptions[0].dataset.harga) : 0;

                                                    let campPrice = selectCamp?.selectedOptions[0]?.dataset.harga ?
                                                        parseInt(selectCamp.selectedOptions[0].dataset.harga) : 0;

                                                    total = basePrice + transportPrice + campPrice;

                                                    // update preview total (default: harga full)
                                                    totalPreview.textContent = "Rp" + total.toLocaleString('id-ID');
                                                    totalPreview.classList.remove("text-warning");
                                                    totalPreview.classList.add("text-success");

                                                    // update detail modal
                                                    hargaProgram.textContent = "Rp" + basePrice.toLocaleString('id-ID');
                                                    hargaTransport.textContent = "Rp" + transportPrice.toLocaleString('id-ID');
                                                    if (hargaCamp) {
                                                        hargaCamp.textContent = "Rp" + campPrice.toLocaleString('id-ID');
                                                    }

                                                    updateTotalModal();
                                                }

                                                function updateTotalModal() {
                                                    let transportPrice = selectTransport?.selectedOptions[0]?.dataset.harga ?
                                                        parseInt(selectTransport.selectedOptions[0].dataset.harga) : 0;

                                                    let campPrice = selectCamp?.selectedOptions[0]?.dataset.harga ?
                                                        parseInt(selectCamp.selectedOptions[0].dataset.harga) : 0;

                                                    if (currentPayment === "full") {
                                                        hargaProgram.classList.remove("text-decoration-line-through");
                                                        hargaProgram.textContent = "Rp" + basePrice.toLocaleString('id-ID');

                                                        totalModal.textContent = "Rp" + (basePrice + transportPrice + campPrice).toLocaleString(
                                                            'id-ID');
                                                        totalPreview.textContent = "Rp" + (basePrice + transportPrice + campPrice).toLocaleString(
                                                            'id-ID');
                                                        totalPreview.classList.remove("text-warning");
                                                        totalPreview.classList.add("text-success");
                                                        if (noteTotal) noteTotal.innerHTML = "";
                                                    } else if (currentPayment === "cicilan") {
                                                        // ✅ Cicilan (DP setengah harga program + biaya tambahan full)
                                                        let dpProgram = basePrice / 2;
                                                        let dp = dpProgram + transportPrice + campPrice;
                                                        let sisa = (basePrice - dpProgram);

                                                        hargaProgram.classList.add("text-decoration-line-through");
                                                        hargaProgram.textContent = "Rp" + basePrice.toLocaleString('id-ID');

                                                        totalModal.textContent = "Rp" + dp.toLocaleString('id-ID');
                                                        totalPreview.textContent = "dp: Rp" + dp.toLocaleString('id-ID');
                                                        totalPreview.classList.remove("text-success");
                                                        totalPreview.classList.add("text-warning");

                                                        if (noteTotal) {
                                                            noteTotal.innerHTML = `
                                                                <div class="fw-bold text-success">
                                                                    Bayar sekarang: Rp${dp.toLocaleString('id-ID')}
                                                                </div>
                                                                <div class="text-muted">
                                                                    Sisa pembayaran: Rp${sisa.toLocaleString('id-ID')}
                                                                </div>
                                                            `;
                                                        }
                                                    } else if (currentPayment === "dp") {
                                                        // ✅ Skema DP fix Rp500.000 + transport & camp tetap dibayar penuh
                                                        let dpProgram = 500000; // FIXED
                                                        let dp = dpProgram + transportPrice + campPrice;
                                                        let sisa = (basePrice - dpProgram);

                                                        hargaProgram.classList.add("text-decoration-line-through");
                                                        hargaProgram.textContent = "Rp" + basePrice.toLocaleString('id-ID');

                                                        totalModal.textContent = "Rp" + dp.toLocaleString('id-ID');
                                                        totalPreview.textContent = "dp: Rp" + dp.toLocaleString('id-ID');
                                                        totalPreview.classList.remove("text-success");
                                                        totalPreview.classList.add("text-warning");

                                                        if (noteTotal) {
                                                            noteTotal.innerHTML = `
                                                                <div class="fw-bold text-success">
                                                                    Bayar sekarang: Rp${dp.toLocaleString('id-ID')}
                                                                </div>
                                                                <div class="text-muted">
                                                                    Sisa pembayaran: Rp${sisa.toLocaleString('id-ID')}
                                                                </div>
                                                            `;
                                                        }
                                                    }
                                                }


                                                if (selectTransport) selectTransport.addEventListener("change", updateTotal);
                                                if (selectCamp) selectCamp.addEventListener("change", updateTotal);

                                                paymentRadios.forEach(radio => {
                                                    radio.addEventListener("change", function() {
                                                        currentPayment = this.value;
                                                        updateTotalModal();
                                                    });
                                                });

                                                btnLihatTotal.addEventListener("click", function() {
                                                    new bootstrap.Modal(document.getElementById('modalTotal')).show();
                                                });

                                                updateTotal(); // initial load
                                            });
                                        </script>
                                        <br>

                                        <script>
                                            $(document).ready(function() {
                                                toggleBankDropdown();

                                                $('input[name="payment_type"]').change(function() {
                                                    toggleBankDropdown();
                                                });

                                                function toggleBankDropdown() {
                                                    if ($('input[name="payment_type"]:checked').val() === 'transfer') {
                                                        $('#bankDropdown').slideDown();
                                                        $('select[name="bank_id"]').attr('required', true);
                                                    } else {
                                                        $('#bankDropdown').slideUp();
                                                        $('select[name="bank_id"]').removeAttr('required');
                                                    }
                                                }
                                            });
                                        </script>


                                        <div class="mb-3">
                                            <label class="form-label">
                                                <i class="bi bi-calendar-check-fill"></i> Periode
                                            </label>

                                            @php
                                                $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                                            @endphp

                                            @if ($program->program_bahasa === 'nhc')
                                                <select name="period_nhc_id" class="form-select" required>
                                                    <option value="">Pilih Periode</option>
                                                    @forelse ($activePeriodsNHC as $period)
                                                        @php
                                                            $isToday =
                                                                $today >= $period->start_date->toDateString() &&
                                                                $today <= $period->end_date->toDateString();
                                                        @endphp
                                                        <option value="{{ $period->id }}"
                                                            {{ old('period_nhc_id') == $period->id ? 'selected' : ($isToday ? 'selected' : '') }}>
                                                            {{ $period->start_date->translatedFormat('d M Y') }}
                                                            -
                                                            {{ $period->end_date->translatedFormat('d M Y') }}
                                                            {{ $isToday ? '(Aktif Hari Ini)' : '' }}
                                                        </option>
                                                    @empty
                                                    @endforelse
                                                </select>

                                                @if ($activePeriodsNHC->isEmpty())
                                                    <div class="form-text text-danger">
                                                        Tidak ada periode pendaftaran NHC yang aktif saat ini.
                                                    </div>
                                                @endif
                                            @else
                                                <select name="period_id" class="form-select" required>
                                                    <option value="">Pilih Periode</option>
                                                    @forelse ($activePeriods as $period)
                                                        @php
                                                            $periodDate = \Carbon\Carbon::parse(
                                                                $period->date,
                                                            )->toDateString();
                                                            $isToday = $periodDate === $today;
                                                        @endphp
                                                        <option value="{{ $period->id }}"
                                                            {{ old('period_id') == $period->id ? 'selected' : ($isToday ? 'selected' : '') }}>
                                                            {{ \Carbon\Carbon::parse($period->date)->translatedFormat('d M Y') }}
                                                            {{ $isToday ? '(Aktif Hari Ini)' : '' }}
                                                        </option>
                                                    @empty
                                                    @endforelse
                                                </select>

                                                @if ($activePeriods->isEmpty())
                                                    <div class="form-text text-danger">
                                                        Tidak ada periode pendaftaran yang aktif saat ini.
                                                    </div>
                                                @endif
                                            @endif
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100"
                                            @if (
                                                ($program->program_bahasa === 'nhc' && $activePeriodsNHC->isEmpty()) ||
                                                    ($program->program_bahasa !== 'nhc' && $periods->isEmpty()) ||
                                                    !isset($banks) ||
                                                    $banks->isEmpty()) disabled @endif>

                                            <i class="bi bi-send-fill"></i>

                                            @if (
                                                ($program->program_bahasa === 'nhc' && $activePeriodsNHC->isNotEmpty()) ||
                                                    ($program->program_bahasa !== 'nhc' && $periods->isNotEmpty()))
                                                Daftar Sekarang
                                            @else
                                                Pendaftaran Ditutup
                                            @endif
                                        </button>

                                        <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 mt-2"><i
                                                class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery dan jQuery UI (untuk autocomplete) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Script Autocomplete -->
    <script>
        $(function() {
            $.getJSON('/indonesia-indonesian.json', function(data) {
                let kotaList = [];

                // Gabungkan semua kota/kab dari semua provinsi jadi satu array
                for (let provinsi in data) {
                    kotaList = kotaList.concat(data[provinsi]);
                }

                // Inisialisasi autocomplete
                $('[name="asal_kota"]').autocomplete({
                    source: kotaList,
                    minLength: 2
                });
            });
        });
    </script>



    {{-- <script>
document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        icon: 'warning',
        title: 'PERHATIAN',
        html: 'Formulir pendaftaran ini <b>dikhususkan untuk pendaftaran PROGRAM</b>.<br>Apabila ingin mendaftar camp, maka <b>kembalilah ke HALAMAN UTAMA</b>.',
        confirmButtonText: 'Mengerti',
        confirmButtonColor: '#d33'
    });
});
</script> --}}


</body>

</html>
