<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record_Latihan_Info extends Model
{
    protected $table = 'info_record_training';
    protected $fillable = ['kode_pelatih', 'kode_info', 'keterangan'];
}
