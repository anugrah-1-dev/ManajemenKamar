<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $program->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- jQuery UI Autocomplete Stylesheet -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
</head>

<body class="bg-light">
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- Program Title -->
                <div class="text-center mb-4">
                    <h1 class="fw-bold">{{ $program->nama }}</h1>
                </div>

                <div class="row g-4">
                    <!-- Program Info -->
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th scope="row" class="bg-light">Harga</th>
                                        <td>Rp {{ number_format($program->harga, 0, ',', '.') }}</td>
                                    </tr>
                                    @if (isset($program->jadwal_mulai))
                                        <tr>
                                            <th scope="row" class="bg-light">Jadwal</th>
                                            <td>
                                                {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M Y') }} -
                                                {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th scope="row" class="bg-light">Fasilitas</th>
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
                                        <th scope="row" class="bg-light">Status</th>
                                        <td>
                                            @if ($program->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light">Thumbnail</th>
                                        <td>
                                            @if ($program->thumbnail)
                                                <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                                    class="img-fluid rounded" alt="{{ $program->nama }}">
                                            @else
                                                <em>Tidak ada thumbnail.</em>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Registration Form -->
                    <div class="col-12 col-md-6">
                        <div class="card border-primary shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Formulir Pendaftaran</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">Silakan lengkapi data diri Anda untuk mendaftar program ini.
                                </p>

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @php
                                    $activePeriods = $periods->where('is_active', 1);
                                @endphp


                                <form method="POST"
                                    action="{{ route('public.program.online.daftar', $program->slug) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-person-fill"></i> Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" class="form-control"
                                            value="{{ old('nama_lengkap') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>

                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-telephone-fill"></i> No. HP</label>
                                        <input type="text" name="no_hp" class="form-control"
                                            value="{{ old('no_hp') }}" required>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Asal Kota</label>
                                        <input type="text" name="asal_kota" class="form-control"
                                            value="{{ old('asal_kota') }}">
                                    </div>
                                    {{--
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="bi bi-house-fill"></i> Akomodasi (Camp Reguler) - Optional
                                        </label>
                                        <select name="akomodasi" class="form-select" id="campSelect">
                                            <option value="" data-harga="0">Pilih Akomodasi (Opsional)
                                            </option>
                                            <option value="reguler" data-harga="180000">Reguler (Rp 180.000)
                                            </option> --}}

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
                                    {{-- </select>
                                    </div> --}}

                                    <div class="d-flex align-items-center border rounded p-3 bg-light mt-3 shadow-sm">
                                        <strong class="me-2">Total:</strong>
                                        <span id="totalPreview" class="fw-bold text-success">
                                            Rp{{ number_format($program->harga, 0, ',', '.') }}
                                        </span>

                                        <a href="javascript:void(0)" id="btnLihatTotal"
                                            class="ms-auto btn btn-sm btn-outline-primary rounded-pill px-3">
                                            Lihat Detail
                                        </a>
                                    </div>

                                    <!-- Modal Rincian -->
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
                                        // Event show modal
                                        document.getElementById('btnLihatTotal').addEventListener('click', function() {
                                            new bootstrap.Modal(document.getElementById('modalTotal')).show();
                                        });
                                    </script>


                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            let basePrice = {{ $program->harga }};
                                            let selectCamp = document.getElementById("campSelect");
                                            let btnLihatTotal = document.getElementById("btnLihatTotal");

                                            let hargaProgram = document.getElementById("hargaProgram");
                                            let hargaCamp = document.getElementById("hargaCamp");
                                            let totalPreview = document.getElementById("totalPreview");
                                            let totalModal = document.getElementById("totalModal");

                                            function updateTotal() {
                                                let campPrice = selectCamp?.selectedOptions[0]?.dataset.harga ?
                                                    parseInt(selectCamp.selectedOptions[0].dataset.harga) :
                                                    0;

                                                let total = basePrice + campPrice;

                                                // update preview total
                                                if (totalPreview) totalPreview.textContent = "Rp" + total.toLocaleString('id-ID');

                                                // update detail modal
                                                hargaProgram.textContent = "Rp" + basePrice.toLocaleString('id-ID');
                                                hargaCamp.textContent = "Rp" + campPrice.toLocaleString('id-ID');
                                                totalModal.textContent = "Rp" + total.toLocaleString('id-ID');
                                            }

                                            if (selectCamp) selectCamp.addEventListener("change", updateTotal);

                                            if (btnLihatTotal) {
                                                btnLihatTotal.addEventListener("click", function() {
                                                    updateTotal();
                                                    new bootstrap.Modal(document.getElementById('modalTotal')).show();
                                                });
                                            }
                                        });
                                    </script>

                                    <br>


                                    {{-- Metode Pembayaran --}}
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-wallet2"></i> Metode Pembayaran
                                        </label>
                                        <div class="d-flex flex-wrap gap-3">

                                            {{-- Tunai --}}
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="payment_type"
                                                    id="pay_tunai" value="tunai"
                                                    {{ old('payment_type') == 'tunai' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="pay_tunai">Bayar Tunai
                                                    (Cash)</label>
                                            </div>

                                            {{-- Transfer --}}
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="payment_type"
                                                    id="pay_transfer" value="transfer"
                                                    {{ old('payment_type') == 'transfer' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="pay_transfer">Transfer
                                                    Bank</label>
                                            </div>

                                            {{-- Qris kalau bahasa Mandarin --}}
                                            @if (strtolower($program->program_bahasa) === 'mandarin')
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="payment_type" id="pay_qris" value="qris"
                                                        {{ old('payment_type') == 'qris' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="pay_qris">QRIS</label>
                                                </div>
                                            @endif

                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-bank"></i> Bank untuk
                                            Pembayaran</label>
                                        <select name="bank_id" class="form-select"
                                            @if (old('payment_type') === 'transfer') required @endif>

                                            <option value="">Pilih Bank</option>
                                            @if (isset($banks) && $banks->isNotEmpty())
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->id }}"
                                                        {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                                        {{ $bank->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled>Tidak ada pilihan bank tersedia
                                                </option>
                                            @endif
                                        </select>

                                        @if (!isset($banks) || $banks->isEmpty())
                                            <div class="form-text text-danger">Pilihan bank tidak tersedia. Hubungi
                                                admin.</div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-calendar-check-fill"></i>
                                            Periode</label>
                                        <select name="period_id" class="form-select" required>
                                            <option value="">Pilih Periode</option>

                                            @php
                                                $today = \Carbon\Carbon::now('Asia/Jakarta')->toDateString();
                                            @endphp

                                            @forelse ($activePeriods as $period)
                                                @php
                                                    $periodDate = \Carbon\Carbon::parse($period->date)->toDateString();
                                                    $isToday = $periodDate === $today;
                                                @endphp
                                                <option value="{{ $period->id }}" {{ $isToday ? 'selected' : '' }}>
                                                    Periode:
                                                    {{ \Carbon\Carbon::parse($period->date)->translatedFormat('d M Y') }}
                                                    {{ $isToday ? '(Aktif Hari Ini)' : '' }}
                                                </option>
                                            @empty
                                                {{-- Kosong --}}
                                            @endforelse
                                        </select>

                                        @if ($activePeriods->isEmpty())
                                            <div class="form-text text-danger">Tidak ada periode pendaftaran yang
                                                aktif saat ini.</div>
                                        @endif
                                    </div>


                                    {{-- PERUBAHAN: Tombol pendaftaran dengan kondisi disabled --}}
                                    <button type="submit" class="btn btn-primary w-100"
                                        @if ($activePeriods->isEmpty() || !isset($banks) || $banks->isEmpty()) disabled @endif>
                                        <i class="bi bi-send-fill"></i>
                                        @if ($activePeriods->isNotEmpty() && isset($banks) && $banks->isNotEmpty())
                                            Daftar Sekarang
                                        @else
                                            Pendaftaran Ditutup
                                        @endif
                                    </button>
                                </form>
                                <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 mt-3">
                                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery & jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Autocomplete Kota -->
    <script>
        $(function() {
            $.getJSON('/indonesia-indonesian.json', function(data) {
                let kotaList = [];

                for (let provinsi in data) {
                    kotaList = kotaList.concat(data[provinsi]);
                }

                $('[name="asal_kota"]').autocomplete({
                    source: kotaList,
                    minLength: 2
                });
            });
        });
    </script>

    {{-- pilihan bank --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const paymentRadios = document.querySelectorAll('input[name="payment_type"]');
            const bankField = document.querySelector('select[name="bank_id"]').closest('.mb-3');

            // Fungsi untuk toggle tampilan bank
            function toggleBankField() {
                const selected = document.querySelector('input[name="payment_type"]:checked');
                if (selected && selected.value === 'transfer') {
                    bankField.style.display = '';
                } else {
                    bankField.style.display = 'none';
                    bankField.querySelector('select').value = ''; // reset pilihan
                }
            }

            // Saat load pertama
            toggleBankField();

            // Saat radio berubah
            paymentRadios.forEach(radio => {
                radio.addEventListener('change', toggleBankField);
            });
        });
    </script>

</body>


</html>
