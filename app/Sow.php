<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sow extends Model
{

    protected $fillable = [
        'name','divisions_id'
    ];

    public $timestamps = false;

    public function division() {
        return $this->belongsTo(Division::class, 'divisions_id');
    }

}
