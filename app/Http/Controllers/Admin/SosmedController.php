<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sosmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SosmedController extends Controller
{
    public function index()
    {
        $sosmeds = Sosmed::latest()->paginate(10);
        return view('admin.sosmed.index', compact('sosmeds'));
    }

    public function create()
    {
        return view('admin.sosmed.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'url' => 'required|url',
            'image_path' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nama', 'url');

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('sosmed', 'public');
        }

        Sosmed::create($data);

        return redirect()->route('admin.sosmed.index')->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Sosial media baru telah ditambahkan.',
        ]);
    }

    public function edit(Sosmed $sosmed)
    {
        return view('admin.sosmed.edit', compact('sosmed'));
    }

    public function update(Request $request, Sosmed $sosmed)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'url' => 'required|url',
            'image_path' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nama', 'url');

        if ($request->hasFile('image_path')) {
            // Hapus file lama kalau ada
            if ($sosmed->image_path) {
                Storage::disk('public')->delete($sosmed->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('sosmed', 'public');
        }

        $sosmed->update($data);

        return redirect()->route('admin.sosmed.index')->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Data sosial media berhasil diperbarui.',
        ]);
    }

    public function destroy(Sosmed $sosmed)
    {
        if ($sosmed->image_path) {
            Storage::disk('public')->delete($sosmed->image_path);
        }

        $sosmed->delete();

        return redirect()->route('admin.sosmed.index')->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Data sosial media telah dihapus.',
        ]);
    }
}
