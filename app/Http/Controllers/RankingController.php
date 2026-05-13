<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;

class RankingController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::orderBy('id')->get();
        $siswas    = Siswa::with('penilaians')->get();

        $hasil = [];

        foreach ($siswas as $siswa) {
            $skor    = 0;
            $lengkap = true;

            foreach ($kriterias as $k) {
                $p = $siswa->penilaians->firstWhere('kriteria_id', $k->id);
                if (!$p || !$k->bobot) {
                    $lengkap = false;
                    break;
                }
                $skor += ($p->nilai / 100) * $k->bobot;
            }

            if (!$lengkap) continue;

            if ($skor >= 0.75)         $status = 'Layak';
            elseif ($skor >= 0.50)     $status = 'Perlu Bimbingan';
            else                       $status = 'Tidak Layak';

            $hasil[] = [
                'siswa_id' => $siswa->id,
                'siswa'    => $siswa->nama_siswa,
                'skor'     => $skor,
                'status'   => $status,
                'nilai'    => $siswa->penilaians->pluck('nilai', 'kriteria_id'),
            ];
        }

        usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

        return view('ranking.index', compact('hasil', 'kriterias'));
    }
}