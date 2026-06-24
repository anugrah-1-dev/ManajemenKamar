<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::query();

        if ($request->has('search') && $request->search != '') {
            // Diubah untuk mencari berdasarkan 'judul_konten'
            $query->where('judul_konten', 'like', '%' . $request->search . '%');
        }

        $programs = $query->latest()->paginate(10); // Menampilkan 10 data per halaman
// Menggunakan latest() untuk mengambil data terbaru
        return view('admin.pamflet_programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.pamflet_programs.create');
    }

    public function store(Request $request)
    {
        // Validasi input sesuai nama kolom
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'keunggulan' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Ambil semua input yang sudah valid
        $input = $request->only(['judul', 'deskripsi', 'keunggulan', 'status']);

        // Simpan gambar jika ada
        if ($gambar = $request->file('gambar')) {
            $destinationPath = 'uploads/programs/';
            $namaGambar = date('YmdHis') . "." . $gambar->getClientOriginalExtension();
            $gambar->move($destinationPath, $namaGambar);
            $input['gambar'] = $namaGambar;
        }

        Program::create($input);

        return redirect()->route('admin.pamflet_programs.index')->with('success', 'Program berhasil ditambahkan.');
    }

    public function edit(Program $program)
    {
        return view('admin.pamflet_programs.edit', compact('program'));
    }
    public function update(Request $request, Program $program)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'keunggulan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $input = $request->only(['judul', 'deskripsi', 'keunggulan', 'status']);

        if ($request->has('hapus_gambar')) {
            if ($program->gambar && file_exists(public_path('uploads/programs/' . $program->gambar))) {
                unlink(public_path('uploads/programs/' . $program->gambar));
            }
            $input['gambar'] = null;
        }

        if ($request->hasFile('gambar')) {
            if ($program->gambar && file_exists(public_path('uploads/programs/' . $program->gambar))) {
                unlink(public_path('uploads/programs/' . $program->gambar));
            }

            $destinationPath = 'uploads/programs/';
            $namaGambar = date('YmdHis') . "." . $request->gambar->getClientOriginalExtension();
            $request->gambar->move($destinationPath, $namaGambar);
            $input['gambar'] = $namaGambar;
        }

        $program->update($input);

        return redirect()->route('admin.pamflet_programs.index')
            ->with('success', 'Program berhasil diperbarui.');
    }


    public function destroy(Program $program)
    {
        // Hapus gambar dengan nama kolom baru
        if ($program->gambar && file_exists(public_path('uploads/programs/' . $program->gambar))) {
            unlink(public_path('uploads/programs/' . $program->gambar));
        }

        $program->delete();
        return redirect()->route('admin.pamflet_programs.index')->with('success', 'Program berhasil dihapus.');
    }
}
