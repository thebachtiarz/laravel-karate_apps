<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record_Budget extends Model
{
    protected $table = 'peserta_req_budget';
    protected $fillable = ['thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'aggregate', 'kredit', 'keterangan', 'saldo'];
}
