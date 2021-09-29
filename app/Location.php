<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'bm_lokasi';
    protected $fillable = [
        'nama', 'flag', 'id_wilayah'
    ];
    public $timestamps = false;
    //

    public function region() {
        return $this->belongsTo(Region::class, 'id_wilayah');
    }
}
