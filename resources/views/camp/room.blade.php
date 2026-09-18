@extends('layouts.app')
@section('content')

    <div class="container py-5">
        <h2 class="text-center mb-4">Pilih Kamar Camp</h2>

        @php
            use App\Helpers\RoomDummy as RD;
        @endphp

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


    @section('content')
        <style>
            .room-layout-wrapper {
                padding: 20px;
            }

            .gender-title {
                font-weight: bold;
                margin-bottom: 10px;
                text-align: center;
                font-size: 18px;
                color: #555;
            }

            .room-grid {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                justify-content: center;
            }

            .room-card {
                width: 60px;
                height: 60px;
                border-radius: 8px;
                background-color: #f3f3f3;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                font-size: 12px;
                cursor: pointer;
                border: 2px solid transparent;
                transition: 0.3s ease;
                position: relative;



            }

            .room-full {
                background-color: #ef4444 !important;
                /* Merah */
            }

            .room-partial {
                background-color: #facc15 !important;
                /* Kuning */
            }

            .room-empty {
                background-color: #22c55e !important;
                /* Hijau */
            }


            .room-card:hover {
                transform: scale(1.05);
                border-color: #007bff;
            }

            .room-card.occupied {
                background-color: #ffc4c4;
                border-color: #ff0000;
            }

            .room-card.available {
                background-color: #c8facc;
                border-color: #28a745;
            }

            .room-number {
                font-weight: bold;
            }

            .room-status {
                font-size: 10px;
                color: #666;
            }
        </style>




        <form action="{{ route('camp.proseskamaruser') }}" method="POST">
            @csrf
            <input type="hidden" name="trx_id" value="{{ $trx_id }}">
            <input type="hidden" name="nama_kamar" id="inputNamaKamar">
            <input type="hidden" name="kamar_id" id="inputKamarId">


            <div id="selectedRoomInfo" class="alert alert-info d-none text-center mt-3">
                @if (auth()->check() && auth()->user()->role === 'admin')
                    Kamar dipilih: <strong id="selectedRoomName"></strong>
                @else
                    Kamar telah dipilih
                    {{-- tetap sisipkan span hidden supaya JS bisa update kalau perlu --}}
                    <strong id="selectedRoomName" class="d-none"></strong>
                @endif
            </div>

            <div class="text-center"> <!-- Tambahkan wrapper center -->
                <button type="submit" class="btn btn-primary mt-3" id="submitBtn" disabled>
                    Lanjut ke Pembayaran
                </button>
            </div>
        </form>



        {{-- === Hidden Input untuk Kamar Terpilih === --}}
        {{-- <input type="hidden" name="nama_kamar" id="inputNamaKamar">
        <input type="hidden" name="kamar_id" id="inputKamarId"> --}}

        {{-- === Tampilan Kamar yang Terpilih === --}}
        <div id="selectedRoomInfo" class="alert alert-info d-none">
            Kamar terpilih: <strong id="selectedRoomName"></strong>
        </div>

        {{-- ===================== VVIP ===================== --}}
        <div class="room-layout-wrapper">
            <h4 class="text-center mb-4">Layout Kamar VVIP - {{ ucfirst($pendaftar->gender) }}</h4>
            <div class="row">

                @if ($pendaftar->gender === 'putri')
                    {{-- Kolom Putri --}}
                    <div class="col-md-12">
                        <div class="gender-column">
                            <div class="gender-title">Putri</div>
                            <div class="room-grid">
                                @foreach (RD::filter($rooms, 'A', 19, 23) as $kamar)
                                    @if ($kamar->gender === 'putri' && $kamar->nomor_kamar !== 'A-12A')
                                        @php
                                            $penghuniAktif = $penghuniAktifPerRoom[$kamar->id] ?? 0;
                                            $isFull = $penghuniAktif >= $kamar->kapasitas;
                                            $isInactive = $kamar->status === 'nonaktif';
                                        @endphp
                                        <div class="room-card {{ RD::getStatusClass($kamar, $penghuniAktif) }}"
                                            data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                            data-kamar="{{ $kamar->nomor_kamar }}" data-gender="{{ $kamar->gender }}"
                                            data-kategori="{{ $kamar->kategori }}"
                                            data-kapasitas="{{ $kamar->kapasitas }}"
                                            data-penghuni="{{ $kamar->penghuni }}"
                                            @unless ($isFull || $isInactive) onclick="selectRoom(this)" role="button" @endunless
                                            style="{{ $isFull || $isInactive ? 'cursor: not-allowed; opacity: 0.6;' : '' }}">

                                            {{-- hanya admin yang bisa lihat nomor kamar --}}
                                            @php
                                                $isAdmin =
                                                    auth()->check() &&
                                                    strtolower(auth()->user()->role ?? '') === 'admin';
                                            @endphp

                                            @role('admin')
                                                <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                            @else
                                                <span class="room-number d-none">{{ $kamar->nomor_kamar }}</span>
                                            @endrole





                                            <span
                                                class="room-status">{{ RD::getStatusText($kamar, $penghuniAktif) }}</span>
                                            <span class="room-capacity">
                                                {{ $kamar->kapasitas }}/{{ $penghuniAktif }}
                                            </span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @elseif ($pendaftar->gender === 'putra')
                    {{-- Kolom Putra --}}
                    <div class="col-md-12">
                        <div class="gender-column">
                            <div class="gender-title">Putra</div>
                            <div class="room-grid">
                                @foreach (RD::filter($rooms, 'A', 24, 28) as $kamar)
                                    @if ($kamar->gender === 'putra')
                                        @php
                                            $penghuniAktif = $penghuniAktifPerRoom[$kamar->id] ?? 0;
                                            $isFull = $penghuniAktif >= $kamar->kapasitas;
                                            $isInactive = $kamar->status === 'nonaktif';

                                        @endphp
                                        <div class="room-card {{ RD::getStatusClass($kamar, $penghuniAktif) }}"
                                            data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                            data-kamar="{{ $kamar->nomor_kamar }}" data-gender="{{ $kamar->gender }}"
                                            data-kategori="{{ $kamar->kategori }}"
                                            data-kapasitas="{{ $kamar->kapasitas }}"
                                            data-penghuni="{{ $kamar->penghuni }}"
                                            @unless ($isFull || $isInactive) onclick="selectRoom(this)" role="button" @endunless
                                            style="{{ $isFull || $isInactive ? 'cursor: not-allowed; opacity: 0.6;' : '' }}">

                                            {{-- hanya admin yang bisa lihat nomor kamar --}}
                                            @php
                                                $isAdmin =
                                                    auth()->check() &&
                                                    strtolower(auth()->user()->role ?? '') === 'admin';
                                            @endphp

                                            @role('admin')
                                                <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                            @else
                                                <span class="room-number d-none">{{ $kamar->nomor_kamar }}</span>
                                            @endrole


                                            <span
                                                class="room-status">{{ RD::getStatusText($kamar, $penghuniAktif) }}</span>
                                            <span class="room-capacity">
                                                {{ $kamar->kapasitas }}/{{ $penghuniAktif }}
                                            </span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ===================== VIP ===================== --}}
        <div class="room-section mt-5">
            <h4 class="text-center mb-4">Layout Kamar VIP - {{ ucfirst($pendaftar->gender) }}</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="gender-column">
                        <div class="gender-title">{{ ucfirst($pendaftar->gender) }}</div>
                        <div class="room-grid">
                            @php
                                $vipRooms = collect();

                                if ($pendaftar->gender === 'putri') {
                                    $vipRooms = collect()
                                        ->merge(RD::filter($rooms, 'A', 1, 18, 'putri'))
                                        ->merge(RD::filter($rooms, 'B', 1, 25, 'putri'))
                                        ->merge(RD::filter($rooms, 'C', 1, 25, 'putri'))
                                        ->reject(
                                            fn($k) => $k->nomor_kamar === 'A-12A' || strtoupper($k->kategori) !== 'VIP',
                                        );
                                } elseif ($pendaftar->gender === 'putra') {
                                    $vipRooms = collect()
                                        ->merge(
                                            RD::filter($rooms, 'A', 29, 46, 'putra')->reject(
                                                fn($k) => $k->nomor_kamar === 'A-35' ||
                                                    ($k->nomor_kamar >= 'A-24' && $k->nomor_kamar <= 'A-28') ||
                                                    strtoupper($k->kategori) !== 'VIP',
                                            ),
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
                                }
                            @endphp

                            @foreach ($vipRooms->unique('nomor_kamar') as $kamar)
                                @php
                                    $penghuniAktif = $penghuniAktifPerRoom[$kamar->id] ?? 0;
                                    $isFull = $penghuniAktif >= $kamar->kapasitas;
                                    $isInactive = $kamar->status === 'nonaktif';
                                @endphp
                                <div class="room-card {{ RD::getStatusClass($kamar, $penghuniAktif) }}"
                                    data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                    data-kamar="{{ $kamar->nomor_kamar }}" data-gender="{{ $kamar->gender }}"
                                    data-kategori="{{ $kamar->kategori }}" data-kapasitas="{{ $kamar->kapasitas }}"
                                    data-penghuni="{{ $kamar->penghuni }}"
                                    @unless ($isFull || $isInactive) onclick="selectRoom(this)" role="button" @endunless
                                    style="{{ $isFull || $isInactive ? 'cursor: not-allowed; opacity: 0.6;' : '' }}">


                                    {{-- hanya admin yang bisa lihat nomor kamar --}}
                                    @php
                                        $isAdmin =
                                            auth()->check() && strtolower(auth()->user()->role ?? '') === 'admin';
                                    @endphp

                                    @role('admin')
                                        <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                    @else
                                        <span class="room-number d-none">{{ $kamar->nomor_kamar }}</span>
                                    @endrole

                                    <span class="room-status">{{ RD::getStatusText($kamar, $penghuniAktif) }}</span>
                                    <span class="room-capacity">
                                        {{ $kamar->kapasitas }}/{{ $penghuniAktif }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== BARACK ===================== --}}
        <div class="room-section mt-5">
            <h4 class="text-center mb-4">Layout Kamar Barack - {{ ucfirst($pendaftar->gender) }}</h4>
            <h3 class="section-title">Kamar Barack</h3>
            <div class="row">
                {{-- Putri --}}
                @if ($pendaftar->gender === 'putri')
                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putri</div>
                            <div class="room-grid">
                                @php
                                    $kamarPutriBarack = $rooms->firstWhere('nomor_kamar', 'A-12A');
                                @endphp

                                @if ($kamarPutriBarack)
                                    @php
                                        $kamar = $kamarPutriBarack;
                                        $penghuniAktif = $penghuniAktifPerRoom[$kamar->id] ?? 0;
                                        $isFull = $penghuniAktif >= $kamar->kapasitas;
                                        $isInactive = $kamar->status === 'nonaktif';
                                    @endphp

                                    <div class="room-card {{ RD::getStatusClass($kamar, $penghuniAktif) }}"
                                        data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                        data-kamar="{{ $kamar->nomor_kamar }}" data-gender="{{ $kamar->gender }}"
                                        data-kategori="{{ $kamar->kategori }}" data-kapasitas="{{ $kamar->kapasitas }}"
                                        data-penghuni="{{ $kamar->penghuni }}"
                                        @unless ($isFull || $isInactive) onclick="selectRoom(this)" role="button" @endunless
                                        style="{{ $isFull || $isInactive ? 'cursor: not-allowed; opacity: 0.6;' : '' }}">
                                        {{-- hanya admin yang bisa lihat nomor kamar --}}
                                        {{-- hanya admin yang bisa lihat nomor kamar --}}
                                        @php
                                            $isAdmin =
                                                auth()->check() && strtolower(auth()->user()->role ?? '') === 'admin';
                                        @endphp

                                        @role('admin')
                                            <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                        @else
                                            <span class="room-number d-none">{{ $kamar->nomor_kamar }}</span>
                                        @endrole


                                        <span class="room-status">{{ RD::getStatusText($kamar, $penghuniAktif) }}</span>
                                        <span class="room-capacity">
                                            {{ $kamar->kapasitas }}/{{ $penghuniAktif }}
                                        </span>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    {{-- Putra --}}
                @elseif ($pendaftar->gender === 'putra')
                    <div class="col-md-6">
                        <div class="gender-column">
                            <div class="gender-title">Putra</div>
                            <div class="room-grid">
                                @php
                                    $kamarPutraBarack = $rooms->firstWhere('nomor_kamar', 'A-35');
                                @endphp

                                @if ($kamarPutraBarack)
                                    @php
                                        $kamar = $kamarPutraBarack;
                                        $penghuniAktif = $penghuniAktifPerRoom[$kamar->id] ?? 0;
                                        $isFull = $penghuniAktif >= $kamar->kapasitas;
                                        $isInactive = $kamar->status === 'nonaktif'; //
                                    @endphp

                                    <div class="room-card {{ RD::getStatusClass($kamar, $penghuniAktif) }}"
                                        data-id="{{ $kamar->id }}" data-nama="{{ $kamar->nomor_kamar }}"
                                        data-kamar="{{ $kamar->nomor_kamar }}" data-gender="{{ $kamar->gender }}"
                                        data-kategori="{{ $kamar->kategori }}" data-kapasitas="{{ $kamar->kapasitas }}"
                                        data-penghuni="{{ $kamar->penghuni }}"
                                        @unless ($isFull || $isInactive) onclick="selectRoom(this)" role="button" @endunless
                                        style="{{ $isFull || $isInactive ? 'cursor: not-allowed; opacity: 0.6;' : '' }}">

                                        {{-- hanya admin yang bisa lihat nomor kamar --}}
                                        @php
                                            $isAdmin =
                                                auth()->check() && strtolower(auth()->user()->role ?? '') === 'admin';
                                        @endphp

                                        @role('admin')
                                            <span class="room-number">{{ $kamar->nomor_kamar }}</span>
                                        @else
                                            <span class="room-number d-none">{{ $kamar->nomor_kamar }}</span>
                                        @endrole


                                        <span class="room-status">{{ RD::getStatusText($kamar, $penghuniAktif) }}</span>
                                        <span class="room-capacity">
                                            {{ $kamar->kapasitas }}/{{ $penghuniAktif }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>



    </div>

    <script>
        function selectRoom(element) {
            const kamarId = element.getAttribute('data-id');
            const namaKamar = element.getAttribute('data-nama');

            console.log("Selected Room ID:", kamarId);
            console.log("Selected Room Name:", namaKamar);

            document.getElementById('inputKamarId').value = kamarId;
            document.getElementById('inputNamaKamar').value = namaKamar;

            document.getElementById('selectedRoomName').textContent = namaKamar;
            document.getElementById('selectedRoomInfo').classList.remove('d-none');

            document.querySelectorAll('.room-card').forEach(card => card.classList.remove('selected-room'));
            element.classList.add('selected-room');

            // Enable tombol submit
            document.getElementById('submitBtn').disabled = false;
        }
    </script>

    {{-- CSS PILIHAN --}}
    <style>
        .room-card.selected-room {
            border: 3px solid #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
        }
    </style>


@endsection
