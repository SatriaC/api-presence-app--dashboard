<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sow extends Model
{

    protected $table = 'bm_sow';
    protected $fillable = [
        'nama','id_bagian', 'ikon'
    ];

    

    public $timestamps = false;

    public function division() {
        return $this->belongsTo(Division::class, 'id_bagian');
    }

}
