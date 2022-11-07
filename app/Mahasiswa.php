<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    public $table = 'mahasiswa';
    protected $guarded = []; //blacklist
    protected $primaryKey = 'NIM';
    public $incrementing = false;
    protected $keyType = 'string';
    use SoftDeletes;
}
