<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ikon extends Model
{
    protected $table = 'bm_ikon';
    protected $fillable = [
        'ikon', 'status'
    ];
    
    public $timestamps = false;
}
