<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'bm_wilayah';
    protected $fillable = [
        'nama', 'flag'
    ];
    public $timestamps = false;

}
