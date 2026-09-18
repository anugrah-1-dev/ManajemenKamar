<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banks;


class BankController extends Controller
{
    // Display a listing of the banks
    public function index()
    {
        $banks = Banks::all();
        return view('admin.banks.index', compact('banks'));
    }

    // Show the form for creating a new bank
    public function create()
    {
        return view('admin.banks.create');
    }

    // Store a newly created bank in storage
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'owner'  => 'required|string|max:255',
            'number' => 'required|string|min:10|max:50',
            'status' => 'required|in:active,inactive',

        ]);


        Banks::create($request->all());

        return redirect()->route('admin.banks.index')->with('success', 'Bank created successfully.');
    }

    public function edit($id)
    {
        $bank = Banks::findOrFail($id);
        return view('admin.banks.edit', compact('bank'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'owner'  => 'required|string|max:255',
            'number' => 'required|string|min:10|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        $bank = Banks::findOrFail($id);
        $bank->update($request->all());

        return redirect()->route('admin.banks.index')->with('success', 'Bank berhasil diperbarui.');
    }


    // Remove the specified bank from storage
    public function destroy($id)
    {
        $bank = Banks::findOrFail($id);
        $bank->delete();

        return redirect()->route('admin.banks.index')
            ->with('success', 'Bank deleted successfully.')
            ->with('sweetalert', true);
    }
}
