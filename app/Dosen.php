<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Model
{
    public $table = 'dosen';
    protected $guarded = []; //blacklist
    protected $primaryKey = 'kode_dosen';
    public $incrementing = false;
    protected $keyType = 'string';
    use SoftDeletes;
}
