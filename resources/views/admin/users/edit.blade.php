@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    <x-adminlte-card title="Form Edit User" theme="lightblue" theme-mode="outline">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nama" placeholder="Masukkan nama user"
                        value="{{ old('name', $user->name) }}" required />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="email" type="email" label="Email" placeholder="Masukkan email user"
                        value="{{ old('email', $user->email) }}" required />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="password" label="Password (Opsional)" type="password"
                        placeholder="Biarkan kosong jika tidak ingin mengubah" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-select name="roles[]" label="Role" multiple>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @if (in_array($role->name, $user->roles->pluck('name')->toArray())) selected @endif>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </x-adminlte-select>
                </div>
            </div>

            <x-adminlte-button class="mt-3" type="submit" theme="primary" label="Perbarui User" icon="fas fa-save" />
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3 ml-2">Batal</a>
        </form>
    </x-adminlte-card>
@stop

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
