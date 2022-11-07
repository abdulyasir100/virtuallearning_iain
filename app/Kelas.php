<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    public $table = 'kelas';
    protected $guarded = []; //blacklist
    protected $primaryKey = 'kode_kelas';
    public $incrementing = false;
    protected $keyType = 'string';
    use SoftDeletes;
}
