<?php

namespace App\Http\Controllers;

use App\Services\AhpService;
use App\Models\Kriteria;
use App\Models\PerbandinganKriteria;
use Illuminate\Http\Request;

class AhpController extends Controller
{
    protected AhpService $ahpService;

    public function __construct(AhpService $ahpService)
    {
        $this->ahpService = $ahpService;
    }

    public function index()
    {
        $kriterias    = Kriteria::orderBy('id')->get();
        $perbandingan = PerbandinganKriteria::with(['kriteriaA','kriteriaB'])->get();
        $hasil        = $kriterias->count() > 0 && $perbandingan->count() > 0
                        ? $this->ahpService->getHasil()
                        : null;

        return view('ahp.index', compact('kriterias', 'perbandingan', 'hasil'));
    }

    public function simpan(Request $request)
    {
        $kriterias = Kriteria::orderBy('id')->get();

        foreach ($kriterias as $i => $k1) {
            foreach ($kriterias as $j => $k2) {
                if ($i >= $j) continue;

                $nilai = $request->input("nilai_{$k1->id}_{$k2->id}");
                if (!$nilai || !is_numeric($nilai)) continue;

                // Simpan k1 vs k2
                PerbandinganKriteria::updateOrCreate(
                    ['kriteria_1' => $k1->id, 'kriteria_2' => $k2->id],
                    ['nilai' => (float) $nilai]
                );

                // Simpan kebalikan k2 vs k1 otomatis
                PerbandinganKriteria::updateOrCreate(
                    ['kriteria_1' => $k2->id, 'kriteria_2' => $k1->id],
                    ['nilai' => 1 / (float) $nilai]
                );
            }
        }

        // Hitung bobot setelah simpan
        $hasil = $this->ahpService->hitungBobot();

        if (!$hasil['konsisten']) {
            return redirect()->route('ahp.index')
                ->with('warning', "Matriks tidak konsisten! CR = " .
                    number_format($hasil['cr'], 4) .
                    " (harus ≤ 0.1). Silakan perbaiki nilai perbandingan.");
        }

        return redirect()->route('ahp.index')
            ->with('success', "Bobot berhasil dihitung. CR = " .
                number_format($hasil['cr'], 4) . " (Konsisten ✓)");
    }
}