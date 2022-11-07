<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materi extends Model
{
    public $table = 'materi';
    protected $guarded = []; //blacklist
    protected $primaryKey = 'id_materi';
    public $incrementing = false;
    protected $keyType = 'string';
    use SoftDeletes;
}
