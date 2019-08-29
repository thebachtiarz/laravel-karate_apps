<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data_Pelatih extends Model
{
    protected $table = 'pelatih_data';
    protected $fillable = ['kode_pelatih', 'nama_pelatih', 'msh_pelatih'];
}
