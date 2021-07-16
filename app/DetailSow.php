<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailSow extends Model
{
    protected $table = 'bm_detailsow';
    protected $fillable = [
        'nama','id_kategori', 'flag'
    ];

    public $timestamps = false;

    public function category() {
        return $this->belongsTo(Category::class, 'id_kategori');
    }
}
