<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'bm_bagian';
    protected $fillable = [
        'nama','flag'
    ];

    public $timestamps = false;

}
