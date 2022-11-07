<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tugas extends Model
{
    public $table = 'tugas';
    protected $guarded = []; //blacklist
    protected $primaryKey = 'id_tugas';
    public $incrementing = false;
    protected $keyType = 'string';
    use SoftDeletes;
}
