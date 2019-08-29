<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas_data';
    protected $fillable = ['kode_kelas', 'thsmt', 'kode_pelatih', 'nama_kelas', 'durasi_latihan', 'spp', 'avatar'];
}
