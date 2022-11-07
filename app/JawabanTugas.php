<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawabanTugas extends Model
{
    public $table = 'jawabanTugas';
    protected $guarded = []; //blacklist
    protected $primaryKey = 'id_jawaban';
    public $incrementing = false;
    protected $keyType = 'string';
    use SoftDeletes;
}
