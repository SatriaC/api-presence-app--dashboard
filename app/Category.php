<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'bm_kategorisow';
    protected $fillable = [
        'nama','id_sow', 'flag'
    ];

    public $timestamps = false;

    public function sow() {
        return $this->belongsTo(Sow::class, 'id_sow');
    }
}
