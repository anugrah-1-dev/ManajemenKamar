<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramCamp;
use App\Models\Period;
use App\Models\rooms;
use App\Models\PendaftaranProgramCamp;
use Illuminate\Support\Facades\File;
use App\Models\Banks;


class CampController extends Controller
{
    public function index()
    {
        $camps = ProgramCamp::latest()->paginate(10);
        return view('camp.index', compact('camps'));
    }

    public function show($slug)
    {
        $program = ProgramCamp::with('thumbnails')->where('slug', $slug)->firstOrFail();
        $facilities = !empty($program->fasilitas) ? explode(',', $program->fasilitas) : [];
        $periods = Period::where('is_active', 1)->get();
        $banks = Banks::all();

        $stokHabis = $program->stok == 0; // <--- cek stok di sini

        return view('camp.show', compact('program', 'facilities', 'periods', 'banks', 'stokHabis',));
    }


    // public function storePendaftaran(Request $request, $programCampId)
    // {
    //     $request->validate([
    //         'nama_lengkap' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'no_hp' => 'required|string|max:20',
    //         'asal_kota' => 'required|string|max:255',
    //         'durasi_paket' => 'required|string',
    //         'period_id' => 'required|exists:periods,id',
    //     ]);

    //     $pendaftaran = PendaftaranProgramCamp::create([
    //         'nama_lengkap'     => $request->input('nama_lengkap'),
    //         'email'            => $request->input('email'),
    //         'no_hp'            => $request->input('no_hp'),
    //         'asal_kota'        => $request->input('asal_kota'),
    //         'program_camp_id'  => $programCampId,
    //         'period_id'        => $request->input('period_id'),
    //         'durasi_paket'     => $request->input('durasi_paket'),
    //         'status'           => 'pending',
    //     ]);

    //     session(['pendaftaran_camp_id' => $pendaftaran->id]);

    //     return redirect()->route('camp.room', [
    //         'slug' => $pendaftaran->programCamp->slug,
    //         'id'   => $pendaftaran->id
    //     ])->with('success', 'Silakan pilih kamar Anda.');
    // }

    public function room($slug)
    {
        $program = ProgramCamp::where('slug', $slug)->firstOrFail();
        $rooms = Rooms::where('program_camp_id', $program->id)->get();

        return view('camp.room', compact('program', 'rooms'));
    }

    public function pilihKamar($slug)
    {
        $program = ProgramCamp::where('slug', $slug)->firstOrFail();
        $rooms = Rooms::where('program_camp_id', $program->id)->get();
        // dd('masuk ke method pilihKamar dengan slug:', $slug);

        return view('camp.room', compact('program', 'rooms'));
    }



    public function pembayaran($id)
    {
        $pendaftaran = PendaftaranProgramCamp::findOrFail($id);
        $banks = Banks::where('status', 'active')->get();
        return view('camp.pembayaran', compact('pendaftaran', 'banks'));
    }

    public function submitBuktiPembayaran(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pendaftaran = PendaftaranProgramCamp::findOrFail($id);

        $file = $request->file('bukti_pembayaran');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('bukti_pembayaran'), $filename);

        $pendaftaran->update([
            'bukti_pembayaran' => $filename,
            'status' => 'validasi',
        ]);

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil! Bukti pembayaran sudah dikirim.');
    }
}
