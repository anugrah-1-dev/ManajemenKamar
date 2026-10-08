<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// Pastikan Anda sudah membuat FormRequest untuk ProgramOnline
// use App\Http\Requests\Admin\ProgramOnline\StoreRequest;
// use App\Http\Requests\Admin\ProgramOnline\UpdateRequest;

class ProgramOnlineController extends Controller
{
    // NOTE: Ganti StoreRequest dan UpdateRequest dengan versi ProgramOnline
    // yang sudah Anda buat. Untuk contoh ini, saya akan gunakan validasi inline.

    public function index()
    {
        $programs = ProgramOnline::latest()->paginate(10);
        return view('admin.programs.online.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.online.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'             => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:program_online,slug',
            'lama_program'     => 'required|string|max:255',
            'kategori'         => 'required|string|max:100',
            'harga'            => 'required|numeric|min:0',
            'features_program' => 'required|string',
            'is_active'        => 'required|boolean',
            'thumbnail'        => 'required|image|mimes:jpg,jpeg,png|max:5048',
            'program_bahasa'   => 'required|in:inggris,jerman,mandarin,arab,nhc',
        ]);

        // Konversi fitur dari textarea ke array
        $validated['features_program'] = json_encode(
            array_filter(array_map('trim', explode("\n", $validated['features_program'])))
        );

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails/program_online', 'public');
        }

        ProgramOnline::create($validated);

        return redirect()->route('admin.online.index')->with('success', 'Program online berhasil ditambahkan.');
    }


    public function edit(ProgramOnline $online)
    {
        return view('admin.programs.online.edit', ['online' => $online]);
    }
    public function update(Request $request, ProgramOnline $online)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'lama_program' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'harga' => 'required|integer|min:0',
            'features_program' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'is_active' => 'required|in:0,1',
            'program_bahasa' => 'required|in:inggris,jerman,mandarin,arab,nhc',
        ]);

        $data = $request->only([
            'nama',
            'lama_program',
            'kategori',
            'harga',
            'features_program',
            'is_active',
            'thumbnail',
            'program_bahasa',
        ]);

        $data['slug'] = Str::slug($data['nama']);
        $data['is_active'] = (int) $data['is_active'];

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            // Hapus lama
            if ($online->thumbnail && Storage::disk('public')->exists($online->thumbnail)) {
                Storage::disk('public')->delete($online->thumbnail);
            }

            $path = $request->file('thumbnail')->store('thumbnails/program_online', 'public');
            $data['thumbnail'] = $path;
        }


        $features = array_filter(array_map('trim', explode("\n", $request->input('features_program', ''))));
        $data['features_program'] = json_encode($features);

        $online->update($data);

        return redirect()->route('admin.online.index')->with('success', 'Program Online berhasil diperbarui.');
    }



    public function destroy($id)
    {
        $program = ProgramOnline::findOrFail($id);

        // Hapus thumbnail jika ada
        if ($program->thumbnail && Storage::disk('public')->exists($program->thumbnail)) {
            Storage::disk('public')->delete($program->thumbnail);
        }

        $program->delete(); // pakai SoftDeletes

        return redirect()->route('admin.online.index')->with('success', 'Program online berhasil dihapus.');
    }
    public function byLanguage($bahasa)
    {
        // Contoh: ambil data program online berdasarkan bahasa
        $programs = ProgramOnline::where('tipe', 'online')
            ->where('bahasa', $bahasa)
            ->get();

        return view('program.online', compact('programs', 'bahasa'));
    }
}
