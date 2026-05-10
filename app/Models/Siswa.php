<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nama_siswa',
        'umur',
        'jenis_kelamin',
        'alamat',
        'nama_orang_tua',
    ];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'siswa_id');
    }

    public function getNilaiKriteria($kriteriaId)
    {
        return $this->penilaians
                    ->firstWhere('kriteria_id', $kriteriaId)
                    ?->nilai;
    }

    public function hitungSkorAhp()
    {
        $kriterias = Kriteria::all();
        $skor      = 0;

        foreach ($kriterias as $k) {
            $p = $this->penilaians->firstWhere('kriteria_id', $k->id);
            if (!$p || !$k->bobot) return null;
            $skor += ($p->nilai / 100) * $k->bobot;
        }

        return $skor;
    }

    public function getStatusAttribute()
    {
        $skor = $this->hitungSkorAhp();
        if ($skor === null)  return null;
        if ($skor >= 0.75)   return 'Layak';
        if ($skor >= 0.50)   return 'Bimbingan';
        return 'Tidak Layak';
    }

    public function sudahDinilai()
    {
        $jumlahKriteria = Kriteria::count();
        return $this->penilaians->count() >= $jumlahKriteria && $jumlahKriteria > 0;
    }
}