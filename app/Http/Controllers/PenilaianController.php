<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;

class PenilaianController extends Controller
{
    public function index()
    {
        $siswas    = Siswa::with('penilaians')->latest()->get();
        $kriterias = Kriteria::all();
        return view('penilaian.index', compact('siswas', 'kriterias'));
    }

    public function store(Request $request)
    {
        $nilai = $request->input('nilai', []);

        foreach ($nilai as $siswaId => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $val) {
                if ($val === null || $val === '') continue;
                Penilaian::updateOrCreate(
                    ['siswa_id' => $siswaId, 'kriteria_id' => $kriteriaId],
                    ['nilai' => $val]
                );
            }
        }

        return redirect()->route('penilaian.index')
                         ->with('success', 'Penilaian berhasil disimpan.');
    }

    public function create(Siswa $siswa)
    {
        $kriterias = Kriteria::all();
        $existing  = Penilaian::where('siswa_id', $siswa->id)
                              ->pluck('nilai', 'kriteria_id');
        return view('penilaian.create', compact('siswa', 'kriterias', 'existing'));
    }

    public function edit(Siswa $siswa)
    {
        $kriterias = Kriteria::all();
        $existing  = Penilaian::where('siswa_id', $siswa->id)
                              ->pluck('nilai', 'kriteria_id');
        return view('penilaian.edit', compact('siswa', 'kriterias', 'existing'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $kriterias = Kriteria::all();

        foreach ($kriterias as $k) {
            $val = $request->input("nilai_{$k->id}");
            if ($val === null || $val === '') continue;
            Penilaian::updateOrCreate(
                ['siswa_id' => $siswa->id, 'kriteria_id' => $k->id],
                ['nilai' => $val]
            );
        }

        return redirect()->route('penilaian.index')
                         ->with('success', "Penilaian {$siswa->nama_siswa} berhasil diperbarui.");
    }

    public function destroy(Siswa $siswa)
    {
        Penilaian::where('siswa_id', $siswa->id)->delete();
        return redirect()->route('penilaian.index')
                         ->with('success', "Penilaian {$siswa->nama_siswa} berhasil dihapus.");
    }
}