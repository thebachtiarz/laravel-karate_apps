<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivateChildsParents extends Model
{
    protected $table = 'private_childs_parents';
    protected $fillable = ['parents_code', 'childs_code', 'kode_kelas'];
}
