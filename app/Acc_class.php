<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acc_class extends Model
{
    protected $table = 'acc_class';
    protected $fillable = ['kode_kelas', 'kode_pelatih'];
}
