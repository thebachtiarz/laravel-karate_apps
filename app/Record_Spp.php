<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record_Spp extends Model
{
    protected $table = 'record_spp_peserta';
    protected $fillable = ['thsmt', 'kode_kelas', 'kode_peserta', 'kredit', 'untuk_bulan', 'kode_pj'];
}
