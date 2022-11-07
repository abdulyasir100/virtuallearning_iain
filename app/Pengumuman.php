<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengumuman extends Model
{
    public $table = 'pengumuman';
    protected $guarded = []; //blacklist
    protected $primaryKey = 'id_pengumuman';
    public $incrementing = false;
    protected $keyType = 'string';
    use SoftDeletes;
}
