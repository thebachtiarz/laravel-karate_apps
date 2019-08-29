<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record_File extends Model
{
    protected $table = 'peserta_req_file';
    protected $fillable = ['thsmt', 'kode_kelas', 'kode_peserta', 'kode_pj', 'kode_file', 'file_info'];
}
