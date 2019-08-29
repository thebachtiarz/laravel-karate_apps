<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record_Latihan extends Model
{
    protected $table = 'record_latihan';
    protected $fillable = ['thsmt', 'kode_kelas_peserta', 'kode_peserta', 'kode_pelatih', 'keterangan', 'durasi'];
}
