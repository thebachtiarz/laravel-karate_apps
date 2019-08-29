<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Static_Budget extends Model
{
    protected $table = 'static_req_budget';
    protected $fillable = ['thsmt', 'kode_kelas', 'tingkat', 'biaya_ujian'];
}
