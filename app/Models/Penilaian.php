<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaians';

    protected $fillable = [

        'siswa_id',
        'kriteria_id',
        'nilai'

    ];
}