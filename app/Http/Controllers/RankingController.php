<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;

class RankingController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        $kriteria = Kriteria::all();

        $hasil = [];

        foreach ($siswa as $s) {

            $total = 0;

            foreach ($kriteria as $k) {

                $nilai = Penilaian::where([
                    'siswa_id' => $s->id,
                    'kriteria_id' => $k->id
                ])->value('nilai') ?? 0;

                // 🔥 hitung nilai x bobot
                $total += $nilai * $k->bobot;
            }

            // 🔥 status kesiapan
            if ($total >= 80) {

                $status = "Layak";

            } elseif ($total >= 60) {

                $status = "Perlu Bimbingan";

            } else {

                $status = "Tidak Layak";
            }

            // 🔥 simpan hasil
            $hasil[] = [
                'nama' => $s->nama_siswa,
                'skor' => $total,
                'status' => $status
            ];
        }

        // 🔥 urutkan ranking terbesar
        usort($hasil, function ($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });

        return view('ranking.index', compact('hasil'));
    }
}