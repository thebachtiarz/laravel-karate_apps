<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest_Otentifikasi extends Model
{
    protected $table = 'otentifikasi';
    protected $fillable = ['tujuan_code', 'tujuan_kelas', 'asal_email', 'asal_newstat', 'asal_info'];
}
