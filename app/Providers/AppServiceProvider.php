<?php

namespace App\Providers;

use App\Models\Penilaian;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('dashboard', function ($view) {

            $totalSiswa      = 0;
            $totalLayak      = 0;
            $totalBimbingan  = 0;
            $totalTidakLayak = 0;

            try {
                $totalSiswa      = Penilaian::count();
                $totalLayak      = Penilaian::where('status', 'Layak')->count();
                $totalBimbingan  = Penilaian::where('status', 'Bimbingan')->count();
                $totalTidakLayak = Penilaian::where('status', 'Tidak Layak')->count();
            } catch (\Exception $e) {
                //
            }

            $view->with([
                'totalSiswa'      => $totalSiswa,
                'totalLayak'      => $totalLayak,
                'totalBimbingan'  => $totalBimbingan,
                'totalTidakLayak' => $totalTidakLayak,
            ]);
        });
    }
}