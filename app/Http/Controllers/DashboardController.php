<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kriteria;
use App\Models\Penilaian;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL DATA
        |--------------------------------------------------------------------------
        */

        $totalSiswa = Siswa::count();

        $totalKriteria = Kriteria::count();

        $totalPenilaian = Penilaian::count();

        /*
        |--------------------------------------------------------------------------
        | STATUS SISWA
        |--------------------------------------------------------------------------
        */

        $layak = 0;
        $bimbingan = 0;
        $tidakLayak = 0;

        $hasil = [];

        $siswa = Siswa::all();
        $kriteria = Kriteria::all();

        foreach ($siswa as $s) {

            $total = 0;

            foreach ($kriteria as $k) {

                $nilai = Penilaian::where([
                    'siswa_id' => $s->id,
                    'kriteria_id' => $k->id
                ])->value('nilai') ?? 0;

                $total += $nilai * ($k->bobot ?? 1);
            }

            // status
            if ($total >= 80) {

                $status = "Layak";
                $layak++;

            } elseif ($total >= 60) {

                $status = "Perlu Bimbingan";
                $bimbingan++;

            } else {

                $status = "Tidak Layak";
                $tidakLayak++;
            }

            $hasil[] = [
                'nama' => $s->nama_siswa,
                'skor' => $total,
                'status' => $status
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | RATA-RATA KRITERIA
        |--------------------------------------------------------------------------
        */

        $rataKriteria = [];

        foreach ($kriteria as $k) {

            $avg = Penilaian::where('kriteria_id', $k->id)
                    ->avg('nilai');

            $rataKriteria[] = [
                'nama' => $k->nama_kriteria,
                'nilai' => round($avg ?? 0)
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | KIRIM KE VIEW
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'totalSiswa',
            'totalKriteria',
            'totalPenilaian',
            'layak',
            'bimbingan',
            'tidakLayak',
            'hasil',
            'rataKriteria'
        ));
    }
}