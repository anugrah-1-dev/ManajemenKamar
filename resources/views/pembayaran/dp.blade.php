@extends('layouts.app')

@section('content')

    <style>
        /* 🎨 Global & Typography */
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #f0f4f8;
            --card-bg: #fff;
            --text-color: #2c3e50;
            --light-blue: #f8fbff;
            --border-dashed: #d0e4ff;
            --shadow-light: rgba(0, 0, 0, 0.08);
            --shadow-primary: rgba(13, 110, 253, 0.2);
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
        }

        .container {
            max-width: 800px;
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        h2 {
            font-weight: 700;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 2.5rem;
        }

        /* 📦 Card & Sections */
        .card {
            border-radius: 1.5rem;
            border: none;
            box-shadow: 0 12px 30px var(--shadow-light);
            background-color: var(--card-bg);
            overflow: hidden;
        }

        .card-header-styled {
            background-color: var(--primary-color);
            color: #fff;
            padding: 2.5rem 2rem;
            text-align: center;
            border-bottom: 5px solid #0a58ca;
        }

        .card-body {
            padding: 2.5rem;
        }

        /* 🌟 Detail Box */
        .detail-box {
            background: var(--light-blue);
            border: 2px dashed var(--border-dashed);
            border-radius: 1.25rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .detail-box h5 {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
        }

        /* 💳 Payment Instructions */
        .list-group-item {
            border-radius: 1rem !important;
            margin-bottom: 1rem;
            border: none;
            background: #fdfdfd;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .list-group-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .bank-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-right: 1.25rem;
        }

        /* 📎 File Upload Input */
        input[type="file"].form-control {
            padding: 1.25rem;
            border: 2px dashed #c5c9d2;
            background: #fdfdfd;
            border-radius: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="file"].form-control:hover,
        input[type="file"].form-control:focus {
            border-color: var(--primary-color);
            background: #f0f7ff;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #555;
        }

        /* 🚀 Buttons */
        .btn {
            border-radius: 50px;
            font-weight: 600;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            box-shadow: 0 5px 15px var(--shadow-primary);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #0b5ed7, #094db5);
            box-shadow: 0 8px 20px var(--shadow-primary);
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            background-color: #5a6268;
        }

        .btn-success {
            background: linear-gradient(135deg, #25d366, #1ebe5d);
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #1ebe5d, #189f4d);
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.4);
        }

        .copy-btn {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-radius: 50px;
            background-color: #e9ecef;
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .copy-btn:hover {
            background-color: var(--primary-color);
            color: #fff;
            transform: translateY(-2px);
        }

        .copy-btn i {
            margin-right: 0.5rem;
        }

        /* 📞 WhatsApp Section */
        .whatsapp-section {
            border-top: 1px dashed #e9ecef;
            padding-top: 2rem;
            margin-top: 2.5rem;
            text-align: center;
        }

        .whatsapp-section p {
            font-weight: 500;
            color: #777;
        }

        /* 📜 SweetAlert Customization */
        .swal2-popup {
            border-radius: 1.5rem !important;
            font-family: 'Poppins', sans-serif !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .swal2-title {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: var(--primary-color) !important;
        }

        .swal2-html-container {
            font-size: 1rem !important;
            text-align: left !important;
            color: #555 !important;
        }

        .swal2-confirm.swal2-styled {
            background-color: var(--primary-color) !important;
            border-radius: 50px !important;
            padding: 0.75rem 2rem !important;
            font-size: 1rem !important;
            transition: transform 0.2s ease;
        }

        .swal2-confirm.swal2-styled:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.4) !important;
        }
    </style>

    <div class="container">
        <div class="card shadow">
            <div class="card-body">

                <div class="text-center mb-4">
                    <i class="fas fa-credit-card fa-3x text-primary mb-3"
                        style="filter: drop-shadow(0 4px 8px rgba(13,110,253,0.3));"></i>
                    <h2>Selesaikan Pembayaran</h2>
                </div>

                {{-- DETAIL PENDAFTARAN --}}
                <div class="detail-box">
                    <h5>Detail Pendaftaran</h5>
                    <p><strong>Nama:</strong> {{ $pendaftaran->nama_lengkap ?? '-' }}</p>
                    <p><strong>Program:</strong> {{ $pendaftaran->program->nama ?? '-' }}</p>
                    <p class="mb-0">
                        <strong>Jumlah DP:</strong>
                        @if(isset($pendaftaran->program->harga_dp))
                            Rp {{ number_format($pendaftaran->program->harga_dp, 0, ',', '.') }}
                        @else
                            Rp 500.000
                        @endif
                    </p>
                </div>

                {{-- INSTRUKSI PEMBAYARAN --}}
                <h5 class="text-center fw-bold mb-4">Instruksi Pembayaran</h5>
                <p class="text-center text-muted mb-3">Silahkan transfer ke rekening berikut:</p>

                <ul class="list-group mb-4">
                    @if(isset($bank) && $bank)
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-university bank-icon"></i>
                                <div>
                                    <strong class="d-block">{{ $bank->name }}</strong>
                                    <span id="bank-number">{{ $bank->number }}</span> (a.n. {{ $bank->owner }})
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm copy-btn"
                                onclick="copyToClipboard('{{ $bank->number }}', this)">
                                <i class="fas fa-copy"></i> Salin
                            </button>
                        </li>
                    @else
                        <li class="list-group-item text-center text-muted">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Informasi bank belum tersedia.
                        </li>
                    @endif
                </ul>

                <hr class="my-5">

                {{-- FORM UPLOAD --}}
                <form action="{{ route('dp.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="pendaftaran_program_offline_id" value="{{ $pendaftaran->id }}">

                    <div class="mb-4">
                        <label for="bukti_dp" class="form-label">Unggah Bukti Pembayaran</label>
                        <input type="file" name="bukti_dp" id="bukti_dp"
                            class="form-control @error('bukti_dp') is-invalid @enderror" required>
                        @error('bukti_dp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-cloud-upload-alt me-2"></i> Kirim Bukti
                        </button>
                    
                          <a href="{{ url('/') }}" class="btn btn-secondary"><i
                                    class="fas fa-arrow-left me-2"></i> Kembali ke Beranda</a>
                    </div>

                    {{-- KONFIRMASI VIA WHATSAPP --}}
                    <div class="whatsapp-section">
                        <p class="text-muted">Atau konfirmasi manual via WhatsApp</p>
                        @php
                            $waNumber = '6281234567890';
                            $message = "Halo, saya ingin konfirmasi pembayaran DP untuk ID Transaksi: "
                                . ($pendaftaran->trx_id ?? 'Belum ada ID')
                                . " atas nama "
                                . ($pendaftaran->nama_lengkap ?? '-')
                                . ".";
                        @endphp
                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($message) }}" class="btn btn-success"
                            target="_blank">
                            <i class="fab fa-whatsapp me-2"></i> Konfirmasi via WhatsApp
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">


    <script>
        function copyToClipboard(text, button) {
            navigator.clipboard.writeText(text).then(() => {
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-primary');

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-outline-secondary');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }

        @if (session('success_message') && session('trx_id'))
            const trxId = "{{ session('trx_id') }}";
            const successMessage = "{{ session('success_message') }}";

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: `
                        <div class="text-center">
                            <p>${successMessage}</p>
                            <div class="input-group mt-3">
                                <input type="text" class="form-control bg-light text-center fw-bold" value="${trxId}" readonly>
                                <button class="btn btn-outline-secondary copy-btn" onclick="copyToClipboard('${trxId}', this)">
                                    <i class="fas fa-copy"></i> Salin
                                </button>
                            </div>
                            <small class="form-text text-muted d-block mt-2">Silakan simpan ID ini untuk referensi Anda.</small>
                        </div>
                    `,
                showConfirmButton: true,
                confirmButtonText: 'Tutup'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `{!! nl2br(e(session('error'))) !!}`,
                showConfirmButton: true,
                confirmButtonText: 'Tutup'
            });
        @endif
    </script>
@endsection
