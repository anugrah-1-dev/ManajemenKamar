<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transports;

class TransportsController extends Controller
{
    public function index()
    {
        $transports = Transports::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.transports.index', compact('transports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',


        ]);

        Transports::create([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Transportasi berhasil ditambahkan.'
        ]);
    }

    public function edit($id)
    {
        $transport = Transports::findOrFail($id);
        return view('admin.transports-edit', compact('transport'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $transport = Transports::findOrFail($id);
        $transport->update([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.transports.index')->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Data transportasi berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $transport = Transports::findOrFail($id);
        $transport->delete();

        return redirect()->route('admin.transports.index')->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Transports berhasil dihapus.'
        ]);
    }
}
