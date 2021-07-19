<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'bm_pekerjaan';
    protected $fillable = [
        'id_user',
        'id_detail',
        'id_sow',
        'laporan',
        'foto_before',
        'foto_after',
        'note',
        'approved_by',
        'approved_at',
        'reported_at',
        'alasan_rejected',
        'flag',
    ];

    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detail() {
        return $this->belongsTo(DetailSow::class, 'id_detail');
    }

    public function sow() {
        return $this->belongsTo(Sow::class, 'id_sow');
    }
}
