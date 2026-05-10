<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerbandinganKriteria;
use App\Models\Kriteria;
use App\Services\AhpService;

class PerbandinganController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        return view('ahp.index', compact('kriteria'));
    }

    public function store(Request $request)
    {
        foreach ($request->nilai as $key => $value) {
            if ($value != null) {
                [$k1, $k2] = explode('-', $key);

                PerbandinganKriteria::updateOrCreate(
                    [
                        'kriteria_1' => $k1,
                        'kriteria_2' => $k2
                    ],
                    [
                        'nilai' => $value
                    ]
                );
            }
        }

        // 🔥 HITUNG AHP
        $ahp = new AhpService();
        $ahp->hitungBobot();

        return redirect('/kriteria')->with('success', 'AHP berhasil dihitung');
    }
}