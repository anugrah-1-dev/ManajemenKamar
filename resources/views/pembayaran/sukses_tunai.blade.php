<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Berhasil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        .success-card {
            border-top: 5px solid #198754;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm success-card">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        <h2 class="card-title mt-3">Pendaftaran Berhasil!</h2>
                        <p class="text-muted">Terima kasih telah mendaftar untuk program <strong>{{ $pendaftaran->program->nama }}</strong>.</p>
                        <hr>
                        <div class="instruction-box my-4">
                            <h5>Langkah Selanjutnya</h5>
                            <p>Silakan selesaikan pembayaran Anda secara tunai di kantor kami.</p>
                            <div class="alert alert-info">
                                <p class="mb-1">Harap tunjukkan atau sebutkan <strong>ID Transaksi</strong> Anda kepada staf kami:</p>
                                
                                {{-- PERUBAHAN: Menambahkan input group dengan tombol salin --}}
                                <div class="input-group mt-2">
                                    <input type="text" class="form-control bg-light" value="{{ $pendaftaran->trx_id }}" readonly>
                                    <button class="btn btn-outline-secondary" onclick="copyToClipboard('{{ $pendaftaran->trx_id }}', this)">
                                        <i class="bi bi-clipboard"></i>
                                        <span class="copy-text ms-1">Salin</span>
                                    </button>
                                </div>

                            </div>
                        </div>
                        <a href="{{ url('/') }}" class="btn btn-primary"><i class="bi bi-house-door-fill"></i> Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SCRIPT BARU UNTUK FUNGSI COPY TO CLIPBOARD --}}
    <script>
        function copyToClipboard(text, buttonElement) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                const copyTextSpan = buttonElement.querySelector('.copy-text');
                const icon = buttonElement.querySelector('i');

                if (copyTextSpan) {
                    copyTextSpan.textContent = 'Tersalin!';
                }
                icon.classList.remove('bi-clipboard');
                icon.classList.add('bi-check-lg');
                buttonElement.classList.remove('btn-outline-secondary');
                buttonElement.classList.add('btn-success');

                setTimeout(() => {
                    if (copyTextSpan) {
                        copyTextSpan.textContent = 'Salin';
                    }
                    icon.classList.remove('bi-check-lg');
                    icon.classList.add('bi-clipboard');
                    buttonElement.classList.remove('btn-success');
                    buttonElement.classList.add('btn-outline-secondary');
                }, 2000);

            } catch (err) {
                console.error('Gagal menyalin teks: ', err);
            }
            document.body.removeChild(textArea);
        }
    </script>
</body>
</html>
