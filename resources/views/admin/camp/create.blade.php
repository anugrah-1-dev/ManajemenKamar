@extends('adminlte::page')

@section('title', 'Tambah Pendaftar Camp')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0"><i class="fas fa-bed mr-2"></i>Tambah Pendaftar Camp (Manual)</h1>
        <a href="{{ route('admin.pendaftaran.camp.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
@stop

@section('content')

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 col-md-10 col-12 mx-auto">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-plus mr-2"></i>Data Peserta</h3>
                    <div class="card-tools">
                        <span class="badge badge-info">Input oleh Admin</span>
                    </div>
                </div>

                <form action="{{ route('admin.pendaftaran.camp.store') }}" method="POST" id="formPendaftar">
                    @csrf
                    <div class="card-body">

                        {{-- ===================== IDENTITAS ===================== --}}
                        <div class="card card-light mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0"><i class="fas fa-id-card mr-1 text-primary"></i> Identitas Peserta</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_lengkap" id="nama_lengkap"
                                            class="form-control @error('nama_lengkap') is-invalid @enderror"
                                            value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap peserta" required>
                                        @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="no_hp">No HP / WhatsApp <span class="text-danger">*</span></label>
                                        <input type="text" name="no_hp" id="no_hp"
                                            class="form-control @error('no_hp') is-invalid @enderror"
                                            value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required>
                                        @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" placeholder="email@contoh.com">
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="asal_kota">Kota / Alamat Asal <span class="text-danger">*</span></label>
                                        <input type="text" name="asal_kota" id="asal_kota"
                                            class="form-control @error('asal_kota') is-invalid @enderror"
                                            value="{{ old('asal_kota') }}" placeholder="Contoh: Surabaya" required>
                                        @error('asal_kota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="gender" id="gender"
                                            class="form-control @error('gender') is-invalid @enderror" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="putra" {{ old('gender') == 'putra' ? 'selected' : '' }}>Putra</option>
                                            <option value="putri" {{ old('gender') == 'putri' ? 'selected' : '' }}>Putri</option>
                                        </select>
                                        @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ===================== PROGRAM & KAMAR ===================== --}}
                        <div class="card card-light mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0"><i class="fas fa-building mr-1 text-success"></i> Program & Kamar</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="program_camp_id">Program Camp <span class="text-danger">*</span></label>
                                        <select name="program_camp_id" id="program_camp_id"
                                            class="form-control @error('program_camp_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Program --</option>
                                            @foreach ($programs as $prog)
                                                <option value="{{ $prog->id }}" {{ old('program_camp_id') == $prog->id ? 'selected' : '' }}>
                                                    {{ $prog->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('program_camp_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="room_id">Pilih Kamar <span class="text-danger">*</span>
                                            <small class="text-muted">(hanya kamar yang masih ada slot)</small>
                                        </label>
                                        <select name="room_id" id="room_id"
                                            class="form-control @error('room_id') is-invalid @enderror" required disabled>
                                            <option value="">-- Pilih program dulu --</option>
                                        </select>
                                        @error('room_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    {{-- Info kamar terpilih --}}
                                    <div class="col-12" id="infoKamar" style="display:none;">
                                        <div class="alert alert-info py-2 px-3">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            <strong id="infoNamaKamar"></strong> —
                                            <span id="infoGenderKamar"></span> |
                                            Kapasitas: <strong id="infoKapasitas"></strong> |
                                            Terisi: <strong id="infoPenghuni"></strong> |
                                            Sisa: <strong id="infoSisa"></strong>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="period_id">Periode <span class="text-danger">*</span></label>
                                        <select name="period_id" id="period_id"
                                            class="form-control @error('period_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Periode --</option>
                                            @foreach ($periods as $period)
                                                <option value="{{ $period->id }}" {{ old('period_id') == $period->id ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::parse($period->date)->translatedFormat('d F Y') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('period_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="durasi_paket">Durasi Paket <span class="text-danger">*</span></label>
                                        <select name="durasi_paket" id="durasi_paket"
                                            class="form-control @error('durasi_paket') is-invalid @enderror" required>
                                            <option value="">-- Pilih Durasi --</option>
                                            @foreach ($durasiOptions as $key => $label)
                                                <option value="{{ $key }}" {{ old('durasi_paket') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('durasi_paket')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    {{-- Tanggal Masuk --}}
                                    <div class="col-md-6 form-group">
                                        <label for="tanggal_masuk">Tanggal Masuk <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                                            class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                            value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                                        @error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    {{-- Preview Tanggal Keluar (readonly, dihitung JS) --}}
                                    <div class="col-md-6 form-group">
                                        <label>Estimasi Tanggal Keluar</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-warning text-dark"><i class="fas fa-calendar-times"></i></span>
                                            </div>
                                            <input type="text" id="previewKeluar" class="form-control font-weight-bold text-danger bg-light"
                                                readonly placeholder="Pilih durasi & tanggal masuk dulu...">
                                        </div>
                                        <small class="text-muted">Dihitung otomatis dari tanggal masuk + durasi paket.</small>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- ===================== PEMBAYARAN & STATUS ===================== --}}
                        <div class="card card-light mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0"><i class="fas fa-money-bill-wave mr-1 text-warning"></i> Pembayaran & Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="payment_type">Jenis Pembayaran <span class="text-danger">*</span></label>
                                        <select name="payment_type" id="payment_type"
                                            class="form-control @error('payment_type') is-invalid @enderror" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="tunai" {{ old('payment_type') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                            <option value="nontunai" {{ old('payment_type') == 'nontunai' ? 'selected' : '' }}>Non Tunai</option>
                                        </select>
                                        @error('payment_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4 form-group" id="bankWrapper" style="display:none;">
                                        <label for="bank_id">Bank</label>
                                        <select name="bank_id" id="bank_id"
                                            class="form-control @error('bank_id') is-invalid @enderror">
                                            <option value="">-- Pilih Bank --</option>
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                                    {{ $bank->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bank_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="status">Status Pendaftaran <span class="text-danger">*</span></label>
                                        <select name="status" id="status"
                                            class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="diterima" {{ old('status', 'diterima') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="validasi" {{ old('status') == 'validasi' ? 'selected' : '' }}>Validasi</option>
                                            <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>{{-- card-body --}}

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.pendaftaran.camp.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">
                            <i class="fas fa-save mr-1"></i> Simpan Pendaftar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card-light .card-header {
            border-bottom: 2px solid #e9ecef;
        }
        label {
            font-weight: 600;
        }
    </style>
@stop

@section('js')
    <script>
        const routeRooms = "{{ url('admin/pendaftaran/camp') }}";

        // Tampilkan/sembunyikan field bank
        document.getElementById('payment_type').addEventListener('change', function () {
            const bankWrapper = document.getElementById('bankWrapper');
            if (this.value === 'nontunai') {
                bankWrapper.style.display = '';
                document.getElementById('bank_id').setAttribute('required', true);
            } else {
                bankWrapper.style.display = 'none';
                document.getElementById('bank_id').removeAttribute('required');
                document.getElementById('bank_id').value = '';
            }
        });

        // Restore old value on page reload
        document.getElementById('payment_type').dispatchEvent(new Event('change'));

        // ===== KAMAR: Load & Filter by Gender =====
        let allRooms = []; // Simpan semua kamar dari server

        function renderKamarOptions() {
            const roomSelect = document.getElementById('room_id');
            const gender     = document.getElementById('gender').value;
            const infoKamar  = document.getElementById('infoKamar');

            roomSelect.innerHTML = '<option value="">-- Pilih Kamar --</option>';
            infoKamar.style.display = 'none';

            // Filter berdasarkan gender jika sudah dipilih
            const filtered = gender
                ? allRooms.filter(r => (r.gender ?? '').toLowerCase() === gender.toLowerCase())
                : allRooms;

            if (filtered.length === 0) {
                const opt = document.createElement('option');
                opt.value   = '';
                opt.textContent = gender
                    ? `Tidak ada kamar untuk gender "${gender}"`
                    : 'Tidak ada kamar tersedia';
                roomSelect.appendChild(opt);
                roomSelect.disabled = true;
                return;
            }

            filtered.forEach(room => {
                const sisa = room.kapasitas - room.penghuni;
                const opt  = document.createElement('option');
                opt.value            = room.id;
                opt.dataset.gender   = room.gender ?? '-';
                opt.dataset.kategori = room.kategori ?? '-';
                opt.dataset.kapasitas= room.kapasitas;
                opt.dataset.penghuni = room.penghuni;
                opt.dataset.sisa     = sisa;
                opt.textContent      = `${room.nomor_kamar} | ${room.gender ?? '-'} | Sisa: ${sisa}/${room.kapasitas}`;
                roomSelect.appendChild(opt);
            });

            roomSelect.disabled = false;
        }

        // Load kamar saat program dipilih
        document.getElementById('program_camp_id').addEventListener('change', function () {
            const programId = this.value;
            const roomSelect = document.getElementById('room_id');
            const infoKamar  = document.getElementById('infoKamar');

            allRooms = [];
            roomSelect.innerHTML = '<option value="">-- Memuat kamar... --</option>';
            roomSelect.disabled  = true;
            infoKamar.style.display = 'none';

            if (!programId) {
                roomSelect.innerHTML = '<option value="">-- Pilih program dulu --</option>';
                return;
            }

            fetch(`${routeRooms}/${programId}/rooms-by-program`)
                .then(res => res.json())
                .then(rooms => {
                    allRooms = rooms;
                    renderKamarOptions();
                })
                .catch(() => {
                    roomSelect.innerHTML = '<option value="">Gagal memuat kamar</option>';
                });
        });

        // Filter ulang kamar saat gender diubah
        document.getElementById('gender').addEventListener('change', function () {
            const roomSelect = document.getElementById('room_id');
            const infoKamar  = document.getElementById('infoKamar');

            // Reset pilihan kamar dan info
            roomSelect.value = '';
            infoKamar.style.display = 'none';

            if (allRooms.length > 0) {
                renderKamarOptions();
            }
        });

        // Tampilkan info kamar saat dipilih
        document.getElementById('room_id').addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            const infoKamar = document.getElementById('infoKamar');

            if (!opt.value) {
                infoKamar.style.display = 'none';
                return;
            }

            document.getElementById('infoNamaKamar').textContent  = opt.text.split('|')[0].trim();
            document.getElementById('infoGenderKamar').textContent = opt.dataset.gender;
            document.getElementById('infoKapasitas').textContent   = opt.dataset.kapasitas;
            document.getElementById('infoPenghuni').textContent    = opt.dataset.penghuni;
            document.getElementById('infoSisa').textContent        = opt.dataset.sisa;
            infoKamar.style.display = '';
        });


        // Restore program pilihan sebelumnya jika ada (old input)
        @if(old('program_camp_id'))
            document.getElementById('program_camp_id').dispatchEvent(new Event('change'));
        @endif

        // ===== Hitung Preview Tanggal Keluar =====
        const durasiDays = {
            'perhari':     1,
            'satu_minggu': 7,
            'dua_minggu':  14,
            'tiga_minggu': 21,
            'satu_bulan':  30,
            'dua_bulan':   60,
            'tiga_bulan':  90,
        };

        const bulanLabel = {
            'satu_bulan': 1,
            'dua_bulan':  2,
            'tiga_bulan': 3,
        };

        const weekLabel = {
            'satu_minggu': 1,
            'dua_minggu':  2,
            'tiga_minggu': 3,
        };

        function hitungTanggalKeluar() {
            const durasi  = document.getElementById('durasi_paket').value;
            const masuk   = document.getElementById('tanggal_masuk').value;
            const preview = document.getElementById('previewKeluar');

            if (!durasi || !masuk) {
                preview.value = '';
                preview.placeholder = 'Pilih durasi & tanggal masuk dulu...';
                return;
            }

            const d = new Date(masuk);

            if (bulanLabel[durasi] !== undefined) {
                d.setMonth(d.getMonth() + bulanLabel[durasi]);
            } else if (weekLabel[durasi] !== undefined) {
                d.setDate(d.getDate() + weekLabel[durasi] * 7);
            } else if (durasi === 'perhari') {
                d.setDate(d.getDate() + 1);
            }

            const opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            preview.value = d.toLocaleDateString('id-ID', opts);
        }

        document.getElementById('durasi_paket').addEventListener('change', hitungTanggalKeluar);
        document.getElementById('tanggal_masuk').addEventListener('change', hitungTanggalKeluar);

        // Jalankan sekali saat pertama load
        hitungTanggalKeluar();
    </script>
@stop

