@extends('layouts.app') {{-- Pastikan Anda memiliki layout master ini --}}

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>Pembayaran Pendaftaran Camp</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{-- Bootstrap & Icons (biasanya sudah ada di layouts.app) --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

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
        <style>
            body {
                background-color: #f0f2f5;
                /* Warna latar belakang yang lebih lembut */
            }

            .payment-card {
                border: none;
                border-radius: 0.75rem;
            }

            .payment-details {
                border: 2px dashed #0d6efd;
                padding: 1.5rem;
                border-radius: .5rem;
                background-color: #e9f3ff;
                /* Latar biru muda untuk detail */
            }

            .list-group-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 1.25rem;
            }

            .list-group-item strong {
                color: #333;
            }

            .btn-copy {
                transition: all 0.2s ease-in-out;
            }

            .btn-copy:active {
                transform: scale(0.95);
            }
        </style>

    </head>

    <body>


        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">

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


                    <div class="card shadow-sm payment-card">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h4 class="mb-0"><i class="bi bi-credit-card-fill"></i> Selesaikan Pembayaran Anda</h4>
                        </div>
                        <div class="card-body p-4">
                            {{-- Detail Pendaftaran --}}
                            <div class="payment-details text-center mb-4">
                                <h5 class="mb-3">Detail Pendaftaran</h5>
                                {{-- <p class="mb-1"><strong>ID Transaksi:</strong></p> --}}
                                {{-- Diasumsikan $pendaftaran memiliki properti trx_id --}}
                                {{-- <div class="d-flex justify-content-center align-items-center gap-2">
                                    <h3 class="fw-bold text-primary mb-0">{{ $pendaftaran->trx_id }}</h3>
                                    <button class="btn btn-sm btn-outline-secondary btn-copy"
                                        onclick="copyToClipboard('{{ $pendaftaran->trx_id }}', this)"
                                        title="Salin ID Transaksi">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div> --}}

                                <hr>
                                <div class="row">
                                    <div class="col-6 text-start">
                                        <p class="mb-1"><strong>Program:</strong></p>
                                        {{-- Diasumsikan ada relasi ke program --}}
                                        <p class="lead">{{ $pendaftaran->program->nama }}</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="mb-1"><strong>Kamar Dipilih:</strong></p>

                                        @auth
                                            @if (auth()->user()->role == 'admin')
                                          
                                                <p class="lead">{{ $pendaftaran->kamar->nomor_kamar ?? '-' }}</p>
                                            @else

                                                <p class="lead">[Tersembunyi]</p>
                                            @endif
                                        @else

                                           <p class="lead">[Hubungi whatsapp untuk informasi lebih lanjut]</p>
                                        @endauth
                                    </div>

                                </div>
                                <div class="total-pembayaran">
                                    <strong>Total Pembayaran:</strong>
                                    @php
                                        // Debugging - bisa dihapus setelah fix
                                        $harga = $pendaftaran->programCamp->harga_satu_bulan;
                                        $durasi = $pendaftaran->durasi_paket;

                                        // Cara alternatif jika masih bermasalah
                                        $harga = match ($durasi) {
                                            'satu_minggu' => $pendaftaran->programCamp->harga_satu_minggu,
                                            'dua_minggu' => $pendaftaran->programCamp->harga_dua_minggu,
                                            'tiga_minggu' => $pendaftaran->programCamp->harga_tiga_minggu,
                                            'satu_bulan' => $pendaftaran->programCamp->harga_satu_bulan,
                                            'dua_bulan' => $pendaftaran->programCamp->harga_dua_bulan,
                                            'tiga_bulan' => $pendaftaran->programCamp->harga_tiga_bulan,
                                            'enam_bulan' => $pendaftaran->programCamp->harga_enam_bulan,
                                            'setahun' => $pendaftaran->programCamp->harga_setahun,
                                            'perhari' => $pendaftaran->programCamp->harga_perhari,
                                            default => $pendaftaran->programCamp->harga_perhari,
                                        };
                                    @endphp

                                    Rp {{ number_format($harga, 0, ',', '.') }}
                                </div>
                                </h2>
                            </div>
                            {{-- Instruksi Pembayaran --}}
                            <div class="instructions mb-4">
                                <h5 class="text-center mb-3">Instruksi Pembayaran</h5>
                                <p class="text-center">Silakan transfer ke rekening berikut:</p>

                                @if ($pendaftaran->bank)
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div>
                                                <i class="bi bi-bank"></i>
                                                <strong>{{ $pendaftaran->bank->name }}:</strong>
                                                {{ $pendaftaran->bank->number }} (a.n. {{ $pendaftaran->bank->owner }})
                                            </div>
                                            <button class="btn btn-sm btn-outline-secondary btn-copy"
                                                onclick="copyToClipboard('{{ $pendaftaran->bank->number }}', this)"
                                                title="Salin Nomor Rekening">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </li>
                                    </ul>
                                @else
                                    <div class="text-center text-danger">
                                        <em>Informasi bank tidak tersedia.</em>
                                    </div>
                                @endif
                            </div>


                            <hr>

                            {{-- Form Unggah Bukti --}}
                            <div class="upload-section mt-4">
                                <h5 class="text-center mb-3">Unggah Bukti Pembayaran</h5>
                                <p class="text-center text-muted small">Setelah transfer, unggah bukti Anda di sini
                                    (JPG, PNG, PDF. Maks 2MB).</p>

                                <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    {{-- Hidden input: ID pendaftaran camp --}}
                                    <input type="hidden" name="id" value="{{ $pendaftaran->id }}">

                                    {{-- Hidden input: Tipe program --}}
                                    <input type="hidden" name="type" value="camp">

                                    {{-- Label dan input dalam satu baris --}}
                                    <label for="bukti_pembayaran" class="form-label mb-1">Upload Bukti
                                        Pembayaran</label>
                                    <div class="input-group">
                                        <input type="file"
                                            class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                                            name="bukti_pembayaran" id="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf"
                                            required>
                                        <button class="btn btn-primary" type="submit">
                                            <i class="bi bi-upload"></i> Kirim Bukti
                                        </button>
                                    </div>
                                    @error('bukti_pembayaran')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </form>




                                @if ($pendaftaran->bukti_pembayaran)
                                    <div class="text-center mt-3">
                                        <a href="{{ asset('storage/' . $pendaftaran->bukti_pembayaran) }}"
                                            class="btn btn-success btn-sm" target="_blank">
                                            <i class="bi bi-eye"></i> Lihat Bukti Pembayaran
                                        </a>
                                    </div>
                                @endif


                            </div>

                            {{-- Tombol Aksi Tambahan --}}
                            <div class="mt-4 text-center">
                                @php
                                    $harga = getHargaDurasi($pendaftaran);
                                    $waText =
                                        "Halo, saya ingin konfirmasi pembayaran untuk ID Transaksi: {$pendaftaran->trx_id} atas nama [NAMA ANDA] dengan total Rp " .
                                        number_format($harga, 0, ',', '.');
                                @endphp
                                <div class="mt-4 text-center">
                                    {{-- PERUBAHAN: Mengambil nomor dari koleksi $contactServices --}}
                                    @php
                                        // Ambil kontak pertama dari koleksi, atau gunakan nomor cadangan jika tidak ada
                                        $waNumber = $contactServices->isNotEmpty()
                                            ? $contactServices->first()->nomor
                                            : '6281234567890';
                                    @endphp
                                    <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo, saya ingin konfirmasi pembayaran untuk ID Transaksi: ' . $pendaftaran->trx_id . ' dengan total Rp ' . number_format($pendaftaran->program->harga, 0, ',', '.')) }}"
                                        class="btn btn-success mb-2" target="_blank"><i class="bi bi-whatsapp"></i>
                                        Konfirmasi via WhatsApp</a>
                                    <a href="{{ url('/') }}" class="btn btn-outline-secondary mb-2"><i
                                            class="bi bi-house-door-fill"></i> Kembali ke Beranda</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function copyToClipboard(text, buttonElement) {
                navigator.clipboard.writeText(text).then(function() {
                    // Sukses menyalin
                    const originalIcon = buttonElement.innerHTML;
                    buttonElement.innerHTML = '<i class="bi bi-check-lg"></i>';
                    buttonElement.classList.add('btn-success');
                    buttonElement.classList.remove('btn-outline-secondary');

                    setTimeout(() => {
                        buttonElement.innerHTML = originalIcon;
                        buttonElement.classList.remove('btn-success');
                        buttonElement.classList.add('btn-outline-secondary');
                    }, 1500); // Kembalikan ke ikon semula setelah 1.5 detik
                }, function(err) {
                    // Gagal menyalin
                    alert('Gagal menyalin nomor rekening.');
                });
            }
        </script>
    </body>

    </html>
@endsection
