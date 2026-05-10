<?php

namespace App\Services;

use App\Models\PerbandinganKriteria;
use App\Models\Kriteria;

class AhpService
{
    public function hitungBobot()
    {
        $kriteria = Kriteria::orderBy('id')->get();
        $n        = count($kriteria);

        if ($n === 0) return null;

        // ===== STEP 1: Bangun matriks PCM =====
        $matriks = [];
        foreach ($kriteria as $i) {
            foreach ($kriteria as $j) {
                if ($i->id === $j->id) {
                    $matriks[$i->id][$j->id] = 1;
                } else {
                    $data = PerbandinganKriteria::where([
                        'kriteria_1' => $i->id,
                        'kriteria_2' => $j->id,
                    ])->first();

                    if ($data) {
                        $matriks[$i->id][$j->id] = $data->nilai;
                    } else {
                        $balik = PerbandinganKriteria::where([
                            'kriteria_1' => $j->id,
                            'kriteria_2' => $i->id,
                        ])->first();
                        $matriks[$i->id][$j->id] = $balik ? (1 / $balik->nilai) : 1;
                    }
                }
            }
        }

        // ===== STEP 2: Jumlah tiap kolom =====
        $jumlahKolom = [];
        foreach ($kriteria as $j) {
            $total = 0;
            foreach ($kriteria as $i) {
                $total += $matriks[$i->id][$j->id];
            }
            $jumlahKolom[$j->id] = $total;
        }

        // ===== STEP 3: Normalisasi matriks =====
        $normalisasi = [];
        foreach ($kriteria as $i) {
            foreach ($kriteria as $j) {
                $normalisasi[$i->id][$j->id] =
                    $matriks[$i->id][$j->id] / $jumlahKolom[$j->id];
            }
        }

        // ===== STEP 4: Bobot prioritas (rata-rata baris) =====
        $bobot = [];
        foreach ($kriteria as $i) {
            $bobot[$i->id] = array_sum($normalisasi[$i->id]) / $n;
        }

        // ===== STEP 5: Weighted Sum Vector (Aw) =====
        $weightedSum = [];
        foreach ($kriteria as $i) {
            $total = 0;
            foreach ($kriteria as $j) {
                $total += $matriks[$i->id][$j->id] * $bobot[$j->id];
            }
            $weightedSum[$i->id] = $total;
        }

        // ===== STEP 6: Lambda max =====
        $lambdaValues = [];
        foreach ($kriteria as $i) {
            if ($bobot[$i->id] > 0) {
                $lambdaValues[] = $weightedSum[$i->id] / $bobot[$i->id];
            }
        }
        $lambdaMax = array_sum($lambdaValues) / count($lambdaValues);

        // ===== STEP 7: Consistency Index (CI) =====
        $ci = $n > 1 ? ($lambdaMax - $n) / ($n - 1) : 0;

        // ===== STEP 8: Random Index (RI) tabel Saaty =====
        $riTable = [
            1 => 0.00, 2 => 0.00, 3 => 0.58,
            4 => 0.90, 5 => 1.12, 6 => 1.24,
            7 => 1.32, 8 => 1.41, 9 => 1.45,
            10 => 1.49,
        ];
        $ri = $riTable[$n] ?? 1.49;

        // ===== STEP 9: Consistency Ratio (CR) =====
        $cr = $ri > 0 ? $ci / $ri : 0;

        // ===== STEP 10: Simpan bobot ke database =====
        foreach ($kriteria as $k) {
            Kriteria::where('id', $k->id)->update([
                'bobot' => $bobot[$k->id],
            ]);
        }

        // ===== Return semua hasil =====
        return [
            'kriteria'    => $kriteria,
            'matriks'     => $matriks,
            'normalisasi' => $normalisasi,
            'jumlahKolom' => $jumlahKolom,
            'bobot'       => $bobot,
            'lambdaMax'   => $lambdaMax,
            'ci'          => $ci,
            'ri'          => $ri,
            'cr'          => $cr,
            'konsisten'   => $cr <= 0.1,
            'n'           => $n,
        ];
    }

    public function getHasil()
    {
        $kriteria = Kriteria::orderBy('id')->get();
        $n        = count($kriteria);

        if ($n === 0 || PerbandinganKriteria::count() === 0) return null;

        return $this->hitungBobot();
    }
}