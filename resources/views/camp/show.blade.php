@extends('layouts.app')

@section('title', $program->nama)

@section('content')
    <link rel="stylesheet" href="{{ asset('css/camp.css') }}">
    <!-- SweetAlert untuk pesan sukses/error -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SCRIPT BARU UNTUK MENAMPILKAN POP-UP SUKSES DENGAN TOMBOL SALIN --}}
    @if (session('success_message') && session('trx_id'))
        <script>
            // Fungsi ini khusus untuk tombol salin di dalam SweetAlert
            function copySwalId(text, buttonElement) {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    const copyTextSpan = buttonElement.querySelector('span');
                    const icon = buttonElement.querySelector('i');

                    if (copyTextSpan) copyTextSpan.textContent = ' Tersalin!';
                    icon.classList.remove('bi-clipboard');
                    icon.classList.add('bi-check-lg');
                    buttonElement.disabled = true; // Nonaktifkan tombol setelah disalin
                } catch (err) {
                    console.error('Gagal menyalin teks: ', err);
                }
                document.body.removeChild(textArea);
            }

            const trxId = "{{ session('trx_id') }}";
            const successMessage = "{{ session('success_message') }}";

            // Membuat konten HTML untuk SweetAlert
            const alertHtml = `
                                                                                                        <div class="text-start">
                                                                                                            <p>${successMessage}</p>
                                                                                                            <div class="mt-3">
                                                                                                                <strong>ID Transaksi Anda:</strong>
                                                                                                                <div class="input-group mt-1">
                                                                                                                    <input type="text" class="form-control bg-light" value="${trxId}" readonly>
                                                                                                                    <button class="btn btn-outline-secondary" onclick="copySwalId('${trxId}', this)">
                                                                                                                        <i class="bi bi-clipboard"></i>
                                                                                                                        <span class="copy-text"> Salin</span>
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                                <small class="form-text text-muted">Silakan simpan ID ini untuk referensi Anda.</small>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    `;

            // Menampilkan SweetAlert
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: alertHtml,
                showConfirmButton: true,
                confirmButtonText: 'Tutup'
            });
        </script>
    @endif



    <!-- Wave dari Atas ke Bawah -->
    <div class="wave-top" style="width:100%; line-height:0;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 60" preserveAspectRatio="none"
            style="width:100%; height:250px; display:block;">
            <defs>
                <linearGradient id="waveGradientTop" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" style="stop-color:#0b2470; stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#163d9b; stop-opacity:1" />
                </linearGradient>
            </defs>
            <!-- Ombak dari atas ke bawah -->
            <path d="M0 0 V20 Q 30 60, 60 30 T 120 40 V0 Z" fill="url(#waveGradientTop)" />
        </svg>
    </div>


    <div class="container my-4 my-lg-5 px-3 px-lg-4">
        <!-- Header Section -->
        <div class="text-center mb-4 mb-lg-5">
            <h1 class="display-4 fw-bold text-dark mb-3">{{ $program->nama }}</h1>


            <p class="lead text-muted mb-3">Pilih Durasi programmu dan isi formulir pendaftaran Camp Yang kamu pilih</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#videoModal">
                Lihat Tutorial Pendaftaran Camp BIE+
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title text-center w-100" id="videoModalLabel">
                            Tutorial Pendaftaran Camp BIE+
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex justify-content-center">
                        <div class="sosmed-card-video" style="max-width: 560px; width: 100%;">
                            <iframe width="100%" height="315" src="https://youtu.be/sIAlnVkQTuc?si=xa4elMNoA2Uwgj7t"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <!-- Image and Description Section -->
        <div class="container">
            <!-- Gambar / Carousel di atas -->
            @php
                $thumbnails = $program->thumbnail_urls->toArray();

                // Desktop: 3 per slide, Mobile: 1 per slide (pakai conditional chunk)
                if (request()->header('User-Agent') && preg_match('/Mobile|Android|iP(hone|od|ad)/i', request()->header('User-Agent'))) {
                    $chunks = array_chunk($thumbnails, 1); // Mobile → 1 per slide
                } else {
                    $chunks = array_chunk($thumbnails, 3); // Desktop → 3 per slide
                }
            @endphp

            <div class="rounded-3 overflow-hidden shadow-sm mb-4" style="padding: 8px;">
                @if (count($program->thumbnail_urls) > 1)
                    <div id="campCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000"
                        data-bs-wrap="true">

                        {{-- Gambar --}}
                        <div class="carousel-inner">
                            @foreach ($chunks as $index => $group)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                                        @foreach ($group as $url)
                                            <div class="thumb-wrapper">
                                                <img src="{{ $url }}" class="img-fluid thumb-img" alt="thumbnail">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Indikator --}}
                        <div class="carousel-indicators mt-3 d-flex justify-content-center gap-2">
                            @foreach ($chunks as $index => $group)
                                <button type="button" data-bs-target="#campCarousel" data-bs-slide-to="{{ $index }}"
                                    class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $index + 1 }}">
                                </button>
                            @endforeach
                        </div>

                    </div>

                    <style>
                        /* Default desktop */
                        /* Default desktop */
                        .thumb-wrapper {
                            flex: 1 1 calc(33.333% - 20px);
                            /* 3 gambar per baris, ada jarak */
                            max-width: 400px;
                            /* batas maksimal */
                            aspect-ratio: 1 / 1;
                            /* supaya tetap kotak */
                            overflow: hidden;
                            border-radius: 8px;
                        }


                        .thumb-img {
                            width: 100%;
                            height: 100%;
                            object-fit: cover;
                            display: block;
                        }

                        /* Indikator */
                        #campCarousel .carousel-indicators {
                            position: static !important;
                            margin-top: 20px;
                        }

                        #campCarousel .carousel-indicators button {
                            width: 16px;
                            height: 16px;
                            border-radius: 50%;
                            border: none;
                            background-color: rgba(255, 165, 0, 0.6);
                            transition: background-color 0.3s;
                        }

                        #campCarousel .carousel-indicators button.active {
                            background-color: orange !important;
                        }

                        #campCarousel .carousel-indicators button:hover {
                            background-color: #ffb347 !important;
                        }

                        /* Mobile responsive */
                        @media (max-width: 768px) {
                            .thumb-wrapper {
                                width: 100%;
                                height: 300px;
                                /* fixed height agar semua slide rapi */
                            }

                            .thumb-img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                /* pastikan gambar penuh tanpa distorsi */
                            }
                        }
                    </style>
                @else
                    <img src="{{ $program->thumbnail_url }}" class="img-fluid w-100 card-img-top" alt="{{ $program->nama }}"
                        style="object-fit: cover; height: 350px;" loading="lazy">
                @endif
            </div>







            <!-- Fasilitas dan lokasi di bawah, kiri-kanan -->
            <div class="row g-3 g-lg-4">
                <!-- Fasilitas kiri -->
                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-3 p-lg-4">
                            <h3 class="fw-bold text-white text-center mb-3 fasilitas-title">Fasilitas</h3>

                            @php
                                $fasilitasList = json_decode($program->fasilitas, true);

                                // fallback kalau bukan JSON, pecah pakai koma
                                $items = is_array($fasilitasList)
                                    ? $fasilitasList
                                    : preg_split('/\s*,\s*/', (string) $program->fasilitas, -1, PREG_SPLIT_NO_EMPTY);

                                $iconmap = [
                                    'Pemanas Air' => '🛁',
                                    'Wifi' => '📶',
                                    'Pendingin Ruangan' => '❄️',
                                    'Tempat Tidur' => '🛏️',
                                    'Shower' => '🚿',
                                    'Area Umum Yang Luas' => '🛋️',
                                    'Tempat Sampah' => '🪣',
                                    'Lemari' => '🗄️',
                                    'Keset' => '⬜',
                                    'Kamera CCTV Untuk Keamanan anda' => '📹',
                                    'Keamanan 24 Jam' => '🛡️',
                                    'Double-Deck Bed' => '🛏️',
                                    'Kamar Terpisah Untuk Pria dan Wanita' => '🚻',
                                ];
                            @endphp

                            @if (!empty($items))
                                <div class="list-unstyled mb-4">
                                    @foreach ($items as $fasilitas)
                                        @php
                                            $icon = '✅';
                                            foreach ($iconmap as $keyword => $emoji) {
                                                if (stripos($fasilitas, $keyword) !== false) {
                                                    $icon = $emoji;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <div class="facility-item d-flex align-items-start mb-2">
                                            <span class="me-2">{{ $icon }}</span>
                                            <span>{{ trim($fasilitas) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Lokasi kanan -->
                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-3 p-lg-4">
                            <h3 class="fw-bold text-white text-center mb-3 bg-primary p-2 rounded">Lokasi</h3>

                            @php
                                $locations = [
                                    ['icon' => 'bi-tree-fill text-success', 'text' => '1.6km dari Taman Kota'],
                                    [
                                        'icon' => 'bi-bus-front-fill text-warning',
                                        'text' => '1.4km dari Terminal Pare',
                                    ],
                                    ['icon' => 'bi-shop text-primary', 'text' => '1.3km dari Pasar Induk Pare'],
                                    ['icon' => 'bi-hospital text-danger', 'text' => '700m dari Klinik'],
                                    [
                                        'icon' => 'bi-brightness-alt-high-fill text-warning',
                                        'text' => '150m dari Wisata Pasar Senja',
                                    ],
                                    ['icon' => 'bi-building text-success', 'text' => '60m dari Masjid'],
                                    ['icon' => 'bi-cup-straw text-danger', 'text' => '50m dari Warung Makan'],
                                ];
                            @endphp

                            <div class="list-unstyled">
                                @foreach ($locations as $loc)
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="bi {{ $loc['icon'] }} me-2"></i>
                                        <span>{{ $loc['text'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap & Font Awesome Icons -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        </div>

        <style>
            /* Judul dengan gradasi */
            .card-body h3 {
                background: linear-gradient(135deg, #003366, #3399ff);
                /* biru gelap → biru terang */
                color: #fff;
                padding: 10px;
                border-radius: 8px;
                font-size: 1.3rem;
                font-weight: 700;
                text-align: center;
            }

            /* Lokasi juga ikut sama */
            .card-body h3.lokasi-title {
                background: linear-gradient(135deg, #003366, #3399ff);
                /* biru gelap → biru terang */
            }


            .wave-top svg {
                width: 100%;
                height: 250px;
                /* besarkan tinggi ombak */
                display: block;
            }
        </style>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const btn = document.getElementById('showMoreBtn');
                if (btn) {
                    btn.addEventListener('click', function () {
                        document.querySelectorAll('.extra-facility').forEach(function (el) {
                            el.classList.remove('d-none');
                        });
                        btn.style.display = 'none';
                    });
                }
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const btn = document.getElementById('showMoreBtn');
                if (btn) {
                    btn.addEventListener('click', function () {
                        document.querySelectorAll('.extra-facility').forEach(function (el) {
                            el.classList.remove('d-none');
                        });
                        btn.style.display = 'none';
                    });
                }
            });
        </script>

        <style>
            #campCarousel .carousel-indicators button.active {
                background-color: orange !important;
            }

            #campCarousel .carousel-indicators button:hover {
                background-color: #ffb347 !important;
            }
        </style>

        <!-- Registration Form Section -->
        <div class="card border-0 shadow-sm mb-4 mb-lg-5">
            <div class="card-header bg-primary text-white py-3">
                <h3 class="fw-bold mb-0 text-center">Formulir Registrasi Camp BIEPLUS</h3>
            </div>
            <div class="card-body p-3 p-lg-4">

                <form id="pendaftaranForm" action="{{ route('camp.pendaftaran.store', $program->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="program_id" value="{{ $program->id }}">

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="no_hp" class="form-label fw-semibold">No HP</label>
                            <input type="text" name="no_hp" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="asal_kota" class="form-label fw-semibold">Alamat</label>
                            <input type="text" id="asal_kota" name="asal_kota" class="form-control form-control-lg"
                                required>



                        </div>

                        <div class="col-12 col-md-6">
                            <label for="gender" class="form-label fw-semibold">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-select form-select-lg" required>
                                <option value="">-- Pilih Jenis Kelamin--</option>
                                <option value="putra">Putra</option>
                                <option value="putri">Putri</option>
                            </select>
                        </div>

                        @php
                            $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString(); // format: '2025-07-27'
                        @endphp

                        <div class="col-12 col-md-6">
                            <label for="period_id" class="form-label fw-semibold">Select Period</label>
                            <select name="period_id" class="form-select form-select-lg" required>
                                <option value="">-- Select Period --</option>
                                @foreach ($periods as $period)
                                    @php
                                        $periodDate = \Carbon\Carbon::parse($period->date)->toDateString();
                                    @endphp

                                    {{-- hanya tampilkan period yang >= hari ini atau masih aktif --}}
                                    @if ($periodDate >= $today || $period->is_active == 1)
                                        <option value="{{ $period->id }}"
                                            {{ $periodDate == $today && $period->is_active == 1 ? 'selected' : '' }}>
                                            Periode:
                                            {{ \Carbon\Carbon::parse($period->date)->translatedFormat('d M Y') }}
                                            @if ($periodDate == $today)
                                                (Aktif Hari Ini)
                                            @elseif ($period->is_active == 1 && $periodDate < $today)
                                                (Aktif Tanggal Terlewat)
                                            @endif
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>



                        <div class="row">
                            <!-- JavaScript untuk menampilkan/sembunyikan form bank -->
                            <div class="col-12 col-md-6 mt-3">
                                <label for="payment_type" class="form-label fw-semibold">Jenis
                                    Pembayaran</label>
                                <select name="payment_type" id="payment_type" class="form-select form-select-lg" required>
                                    <option value="">-- Pilih Jenis Pembayaran --</option>
                                    <option value="tunai" {{ old('payment_type') == 'tunai' ? 'selected' : '' }}>
                                        Tunai</option>
                                    <option value="nontunai" {{ old('payment_type') == 'nontunai' ? 'selected' : '' }}>
                                        NonTunai
                                    </option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6 mt-3" id="bankForm" style="display: none;">
                                <label for="bank_id" class="form-label fw-semibold">Pilih Bank</label>
                                <select name="bank_id" id="bank_id" class="form-select form-select-lg">
                                    <option value="">-- Pilih Bank --</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                            {{ $bank->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6 mt-3 bukti-section" style="display:none;">
                                <label for="bukti_pembayaran" class="form-label fw-semibold">Upload Bukti
                                    Pembayaran</label>
                                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control"
                                    accept="image/*" />
                            </div>

                            <script>
                                document.getElementById('payment_type').addEventListener('change', function () {
                                    const bankForm = document.getElementById('bankForm');
                                    if (this.value === 'nontunai') {
                                        bankForm.style.display = 'block';
                                        document.getElementById('bank_id').setAttribute('required', 'required');
                                    } else {
                                        bankForm.style.display = 'none';
                                        document.getElementById('bank_id').removeAttribute('required');
                                        document.getElementById('bank_id').value = '';
                                    }
                                });

                                document.addEventListener('DOMContentLoaded', function () {
                                    document.getElementById('payment_type').dispatchEvent(new Event('change'));
                                });
                            </script>

                            <div class="col-12">
                                <label class="form-label fw-semibold d-block mb-2">Paket Durasi</label>
                                <div class="duration-options-container">
                                    @php
                                        $durasiOptions = [
                                            'perhari' => [
                                                'label' => 'Per Hari',
                                                'harga' => $program->harga_perhari,
                                            ],
                                            'satu_minggu' => [
                                                'label' => '1 Minggu',
                                                'harga' => $program->harga_satu_minggu,
                                            ],
                                            'dua_minggu' => [
                                                'label' => '2 Minggu',
                                                'harga' => $program->harga_dua_minggu,
                                            ],
                                            'tiga_minggu' => [
                                                'label' => '3 Minggu',
                                                'harga' => $program->harga_tiga_minggu,
                                            ],
                                            'satu_bulan' => [
                                                'label' => '1 Bulan',
                                                'harga' => $program->harga_satu_bulan,
                                            ],
                                            'dua_bulan' => [
                                                'label' => '2 Bulan',
                                                'harga' => $program->harga_dua_bulan,
                                            ],
                                            'tiga_bulan' => [
                                                'label' => '3 Bulan',
                                                'harga' => $program->harga_tiga_bulan,
                                            ],
                                          
                                        ];
                                    @endphp
                                    @foreach ($durasiOptions as $key => $option)
                                        @if ($option['harga'] > 0)
                                            <div class="duration-option">
                                                <input class="form-check-input d-none" type="radio" name="durasi_paket"
                                                    id="{{ $key }}" value="{{ $key }}" required>
                                                <label
                                                    class="d-flex flex-column justify-content-center align-items-center p-3 rounded border text-center"
                                                    for="{{ $key }}">
                                                    <span class="fw-semibold">{{ $option['label'] }}</span>
                                                    <small class="text-muted">Rp
                                                        {{ number_format($option['harga']) }}</small>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4 px-lg-5 py-3 fw-semibold">
                                <i class="fas fa-arrow-right me-2"></i> Proses Untuk Pemilihan Kamar
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery UI CDN -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(function () {
            $.getJSON('/indonesia-indonesian.json', function (data) {
                let kotaList = [];

                // Gabungkan semua kota/kab dari semua provinsi jadi satu array
                for (let provinsi in data) {
                    kotaList = kotaList.concat(data[provinsi]);
                }

                // Inisialisasi autocomplete
                $('#asal_kota').autocomplete({
                    source: kotaList,
                    minLength: 2
                });
            });
        });
    </script>
    @if($stokHabis)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const stok = {{ $program->stok }};
                const form = document.getElementById('pendaftaranForm');

                if (form) {
                    form.addEventListener('submit', function (e) {
                        if (stok === 0) {
                            e.preventDefault();
                            Swal.fire({
                                icon: 'warning',
                                title: 'Maaf!',
                                text: 'Camp ini sudah penuh! Silahkan hubungi admin untuk informasi lebih lanjut',
                            });
                        }
                    });
                }
            });
        </script>
    @endif

@endsection