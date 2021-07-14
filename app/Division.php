<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = [
        'name','flag'
    ];

    public $timestamps = false;
    
}
