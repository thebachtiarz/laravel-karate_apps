<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data_Peserta extends Model
{
    protected $table = 'peserta_data';
    protected $fillable = ['kode_peserta', 'kode_kelas_peserta', 'nama_peserta', 'tingkat', 'noinduk'];
}
