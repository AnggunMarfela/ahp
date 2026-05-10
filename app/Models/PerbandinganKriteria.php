<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerbandinganKriteria extends Model
{
    protected $table = 'perbandingan_kriteria';

protected $fillable = [
    'kriteria_1',
    'kriteria_2',
    'nilai'
];
}
