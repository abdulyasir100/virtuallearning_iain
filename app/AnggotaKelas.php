<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnggotaKelas extends Model
{
    protected $table = 'anggotakelas';
    public $timestamps = false;
    protected $guarded = []; //blacklist
}
