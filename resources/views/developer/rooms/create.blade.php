@extends('adminlte::page')

@section('title', 'Tambah Kamar')

@section('content_header')
    <h1>Tambah Kamar</h1>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-adminlte-card title="Tambah Kamar Baru" theme="primary" icon="fas fa-bed">
                <form method="POST" action="{{ route('developer.rooms.store') }}">
                    @csrf

                    <x-adminlte-select name="program_camp_id" label="Program Camp" fgroup-class="mb-4" required>
                        @foreach ($programCamps as $program)
                            <option value="{{ $program->id }}">{{ $program->nama }}</option>
                        @endforeach
                    </x-adminlte-select>

                    <x-adminlte-input name="nomor_kamar" label="Nomor Kamar" placeholder="Contoh: D-01"
                        fgroup-class="mb-4" required />

                    <x-adminlte-select name="gender" label="Gender" fgroup-class="mb-4" required>
                        <option value="putra">PUTRA</option>
                        <option value="putri">PUTRI</option>
                    </x-adminlte-select>

                    <x-adminlte-select name="kategori" label="Kategori" fgroup-class="mb-4" required>
                        <option value="vvip">VVIP</option>
                        <option value="vip">VIP</option>
                        <option value="barack">Barack</option>
                    </x-adminlte-select>

                    <x-adminlte-input name="kapasitas" label="Kapasitas" type="number" min="1"
                        placeholder="Jumlah kapasitas kamar" fgroup-class="mb-4" required />

                    <x-adminlte-select name="status" label="Status Kamar" fgroup-class="mb-4" required>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </x-adminlte-select>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('developer.rooms.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <x-adminlte-button theme="success" label="Simpan Kamar" icon="fas fa-save" type="submit" />
                    </div>
                </form>
            </x-adminlte-card>
        </div>
    </div>

    @if ($errors->any())
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endsection