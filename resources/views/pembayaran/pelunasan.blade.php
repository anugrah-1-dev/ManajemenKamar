<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelunasan Cicilan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            background-color: #f3f6fa;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .card-header {
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
            font-size: 1.2rem;
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: none;
        }
        .copy-btn {
            cursor: pointer;
            transition: all 0.3s;
        }
        .copy-btn:hover {
            transform: scale(1.05);
        }
        .bank-icon {
            font-size: 1.5rem;
            margin-right: 10px;
            color: #0d6efd;
        }
        .instructions {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            border: 1px dashed #ddd;
        }
        .btn-primary, .btn-success {
            border: none;
            padding: 12px 22px;
            font-weight: 500;
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #0d6efd;
        }
        .btn-success {
            background-color: #198754;
        }
        .btn-primary:hover, .btn-success:hover {
            opacity: 0.9;
        }
        .upload-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            border: 1px dashed #ddd;
        }
        .info-box {
            border-left: 4px solid #0d6efd;
            background: #fdfdfd;
            padding: 15px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Pelunasan Cicilan</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>Silakan selesaikan pembayaran cicilan ke-{{ $cicilan->bulan_ke }} sebelum jatuh tempo</div>
                        </div>

                        <!-- Informasi Cicilan -->
                        <div class="info-box mb-4">
                            <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Informasi Cicilan</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>ID Transaksi:</strong> {{ $cicilan->pendaftaran->trx_id }}</p>
                                    <p class="mb-1"><strong>Cicilan ke:</strong> {{ $cicilan->bulan_ke }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Jumlah:</strong> Rp {{ number_format($cicilan->jumlah, 0, ',', '.') }}</p>
                                    <p class="mb-0"><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($cicilan->tanggal_jatuh_tempo)->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Instruksi Pembayaran -->
                        <div class="instructions mb-4">
                            <h5 class="text-center mb-3">Instruksi Pembayaran</h5>
                            <p>Silahkan transfer ke rekening berikut:</p>
                            
                            <ul class="list-group mb-3">
                                @if($bank)
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-university bank-icon"></i>
                                        <div>
                                            <strong>{{ $bank->name }}</strong><br>
                                            <span id="bank-number">{{ $bank->number }}</span> (a.n. {{ $bank->owner }})
                                        </div>
                                    </div>
                                    <button class="btn btn-outline-secondary btn-sm copy-btn" onclick="copyToClipboard('{{ $bank->number }}', this)">
                                        <i class="fas fa-copy"></i>
                                        <span class="copy-text">Salin</span>
                                    </button>
                                </li>
                                @else
                                <li class="list-group-item text-center text-muted">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Informasi bank belum tersedia. Silakan hubungi administrator.
                                </li>
                                @endif
                            </ul>
                            
                            <div class="alert alert-warning mt-3" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Perhatian:</strong> Transfer sesuai jumlah tagihan lalu unggah bukti pembayaran.
                            </div>
                        </div>

                        <!-- Form Unggah Bukti Pembayaran -->
                        <div class="upload-section mt-4">
                            <h5 class="text-center mb-3">Unggah Bukti Pembayaran</h5>
                            <form action="{{ route('cicilan.pelunasan.store', $cicilan->pendaftaran_program_offline_id) }}" 
                                  method="POST" enctype="multipart/form-data" id="pelunasanForm">
                                @csrf
                                <input type="file" name="bukti_pembayaran" class="form-control mb-3" required>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check-circle me-2"></i> Lunasi Semua Cicilan
                                </button>
                            </form>
                        </div>

                        <!-- Konfirmasi WhatsApp -->
                        <div class="text-center mt-4">
                            <p class="text-muted">Atau konfirmasi langsung via WhatsApp</p>
                            @php
                                $waNumber = '6281234567890'; // ganti sesuai nomor CS
                                $message = "Halo, saya ingin konfirmasi pembayaran cicilan ke-".$cicilan->bulan_ke." untuk ID Cicilan: ".$cicilan->id." dengan jumlah Rp ".number_format($cicilan->jumlah, 0, ',', '.');
                            @endphp
                            <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($message) }}" 
                               class="btn btn-success mb-2" target="_blank">
                                <i class="fab fa-whatsapp me-2"></i> Konfirmasi via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyToClipboard(text, buttonElement) {
            navigator.clipboard.writeText(text).then(function() {
                const copyText = buttonElement.querySelector('.copy-text');
                const icon = buttonElement.querySelector('i');
                copyText.textContent = 'Tersalin!';
                icon.classList.replace('fa-copy','fa-check');
                setTimeout(function() {
                    copyText.textContent = 'Salin';
                    icon.classList.replace('fa-check','fa-copy');
                }, 2000);
            });
        }

      // SweetAlert setelah submit
document.getElementById('pelunasanForm').addEventListener('submit', function(e) {
    e.preventDefault(); 
    let form = this;

    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Pelunasan cicilan Anda telah berhasil 🎉',
        confirmButtonText: 'OK'
    }).then(() => {
        form.submit(); // submit form setelah klik OK
    });
});

        // Jika ada session sukses dari controller
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#198754'
        });
        @endif

        // Jika ada error
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#d33'
        });
        @endif
    </script>
</body>
</html>
