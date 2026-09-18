<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pembayaran Pendaftaran (QRIS)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .payment-details {
            border: 2px dashed #0d6efd;
            padding: 1.5rem;
            border-radius: .5rem;
            background-color: #f8f9fa;
        }

        .countdown {
            font-size: 1.25rem;
            font-weight: bold;
            color: #dc3545;
        }

        .qris-img {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .qris-img:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Selesaikan Pembayaran Anda</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="payment-details text-center mb-4">
                            <h5 class="mb-3">Detail Pendaftaran</h5>
                            <hr>
                            <p><strong>Program:</strong></p>
                            <p class="lead">{{ $pendaftaran->program->nama }}</p>
                            <p><strong>Total Pembayaran:</strong></p>
                            <h2 class="fw-bolder">Rp {{ number_format($pendaftaran->subtotal, 0, ',', '.') }}</h2>

                            <!-- QRIS IMAGE -->
                            <div class="my-4">
                                <img src="{{ asset('asset/qris/madarin_qris.jpg') }}" alt="QRIS"
                                    class="img-fluid shadow-sm qris-img" style="max-width: 400px; cursor: pointer;"
                                    onclick="showQrisModal(this.src)">
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="qrisModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content bg-transparent border-0 shadow-none">
                                        <div class="modal-body text-center p-0">
                                            <img id="qrisModalImg" src="" alt="QRIS"
                                                class="img-fluid rounded shadow">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($sudahUpload)
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Bukti Pembayaran Terkirim!
                                </div>

                                <div class="mt-4 text-center">
                                    <div class="mt-4 text-center">
                                        @php
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
                            @else
                                <div class="alert alert-warning">
                                    <i class="bi bi-clock-fill"></i>
                                    Batas waktu pembayaran: <span id="countdown" class="countdown">10:00</span>
                                </div>


                                <p class="text-muted small">Silakan scan QRIS di atas menggunakan aplikasi e-wallet atau
                                    mobile banking Anda.</p>
                        </div>

                        <!-- UPLOAD BUKTI -->
                        <div class="upload-section mt-4">
                            <h5 class="text-center mb-3">Unggah Bukti Pembayaran</h5>
                            <p class="text-center text-muted small">Format JPG, PNG, PDF. Maks 2MB.</p>

                            <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $pendaftaran->id }}">
                                <input type="hidden" name="type" value="offline">

                                <div class="input-group">
                                    <input type="file" class="form-control" name="bukti_pembayaran" required>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-upload"></i> Kirim Bukti
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="mt-4 text-center">
                            {{-- <a href="{{ url('/') }}" class="btn btn-outline-secondary mb-2">
                                <i class="bi bi-house-door-fill"></i> Kembali ke Beranda
                            </a> --}}
                            <div class="mt-4 text-center">
                                @php
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

    <!-- Modal Zoom QRIS -->
    <div class="modal fade" id="qrisModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="qrisModalImg" src="" alt="QRIS" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showQrisModal(src) {
            const modalImg = document.getElementById('qrisModalImg');
            modalImg.src = src;
            const modal = new bootstrap.Modal(document.getElementById('qrisModal'));
            modal.show();
        }
    </script>

    <script>
        const countdownEl = document.getElementById('countdown');
        const uploadForm = document.getElementById('uploadForm');

        const EXPIRES_AT = Number(@json($expiresAtTs));
        const SERVER_NOW = Number(@json($nowTs));
        const drift = Date.now() - SERVER_NOW;

        function tick() {
            const now = Date.now() - drift;
            let leftMs = EXPIRES_AT - now;

            if (leftMs <= 0) {
                countdownEl.textContent = '00:00';
                if (uploadForm)[...uploadForm.elements].forEach(el => el.disabled = true);

                Swal.fire({
                    icon: 'error',
                    title: 'Waktu Habis!',
                    text: 'Batas waktu pembayaran sudah berakhir. Silakan daftar lagi.',
                }).then(() => {
                    window.location.href = @json(route('public.program.offline.show', $pendaftaran->program->slug));
                });
                return;
            }

            const totalSec = Math.floor(leftMs / 1000);
            const mm = String(Math.floor(totalSec / 60)).padStart(2, '0');
            const ss = String(totalSec % 60).padStart(2, '0');
            countdownEl.textContent = `${mm}:${ss}`;
            requestAnimationFrame(tick);
        }
        tick();
    </script>
    @endif

    <!-- SweetAlert untuk pesan sukses/error -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SCRIPT BARU UNTUK MENAMPILKAN POP-UP SUKSES DENGAN TOMBOL SALIN --}}
    @if (session('success_message') && session('trx_id'))
        <script>
            function copySwalId(text, buttonElement) {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    const copyTextSpan = buttonElement.querySelector('span');
                    const icon = buttonElement.querySelector('i');

                    if (copyTextSpan) copyTextSpan.textContent = 'Tersalin!';
                    icon.classList.remove('bi-clipboard');
                    icon.classList.add('bi-check-lg');
                    buttonElement.disabled = true;
                } catch (err) {
                    console.error('Gagal menyalin teks: ', err);
                }
                document.body.removeChild(textArea);
            }

            const trxId = "{{ session('trx_id') }}";
            const successMessage = "{{ session('success_message') }}";

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

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: alertHtml,
                showConfirmButton: true,
                confirmButtonText: 'Tutup'
            });
        </script>
    @endif

    {{-- Error --}}
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `{!! nl2br(e(session('error'))) !!}`,
                showConfirmButton: true,
                confirmButtonText: 'Tutup'
            });
        </script>
    @endif


</body>

</html>
