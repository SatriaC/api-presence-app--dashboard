<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailSow extends Model
{
    protected $fillable = [
        'name','sows_id'
    ];

    public $timestamps = false;

    public function sow() {
        return $this->belongsTo(Sow::class, 'sows_id');
    }
}
