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

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA
        |--------------------------------------------------------------------------
        */

        $siswa = Siswa::all();

        $kriterias = Kriteria::all();

        /*
        |--------------------------------------------------------------------------
        | HITUNG NILAI
        |--------------------------------------------------------------------------
        */

        foreach ($siswa as $s) {

            $total = 0;

            $nilaiSiswa = [];

            foreach ($kriterias as $k) {

                $nilai = Penilaian::where([

                    'siswa_id' => $s->id,

                    'kriteria_id' => $k->id

                ])->value('nilai') ?? 0;

                // SIMPAN NILAI
                $nilaiSiswa[$k->id] = $nilai;

                // HITUNG TOTAL
                $total += $nilai * ($k->bobot ?? 1);
            }

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | HASIL
            |--------------------------------------------------------------------------
            */

            $hasil[] = [

                'siswa' => $s->nama_siswa,

                'nilai' => $nilaiSiswa,

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

        foreach ($kriterias as $k) {

            $avg = Penilaian::where('kriteria_id', $k->id)
                    ->avg('nilai');

            $rataKriteria[] = [

                'nama' => $k->nama_kriteria,

                'rata' => round($avg ?? 0)

            ];
        }

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
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
            'rataKriteria',
            'kriterias'

        ));
    }
}