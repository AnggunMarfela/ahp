<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN DATA KRITERIA
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $kriterias = Kriteria::all();

        return view('kriteria.index', compact('kriterias'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH KRITERIA
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('kriteria.create');
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA KRITERIA
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|string|max:10|unique:kriteria',
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric'
        ]);

        Kriteria::create([
            'kode_kriteria' => $request->kode_kriteria,
            'nama_kriteria' => $request->nama_kriteria,
            'bobot' => $request->bobot
        ]);

        return redirect()
                ->route('kriteria.index')
                ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT KRITERIA
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        return view('kriteria.edit', compact('kriteria'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA KRITERIA
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $request->validate([
            'kode_kriteria' => 'required|string|max:10',
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric'
        ]);

        $kriteria->update([
            'kode_kriteria' => $request->kode_kriteria,
            'nama_kriteria' => $request->nama_kriteria,
            'bobot' => $request->bobot
        ]);

        return redirect()
                ->route('kriteria.index')
                ->with('success', 'Kriteria berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA KRITERIA
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $kriteria->delete();

        return redirect()
                ->route('kriteria.index')
                ->with('success', 'Kriteria berhasil dihapus.');
    }
}