<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juklak_Ujian extends Model
{
    protected $table = 'storage_juklak_ujian';
    protected $fillable = ['auth_kyu', 'file_name', 'file_url'];
}
