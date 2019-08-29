<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Static_File extends Model
{
    protected $table = 'static_req_file';
    protected $fillable = ['thsmt', 'kode_file', 'kode_kelas', 'nama_file'];
}
