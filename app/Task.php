<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'users_id',
        'details_id',
        'report',
        'photos_before',
        'photos_after',
        'note',
        'approved_by',
        'reason_rejected',
        'flag',
    ];


    public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function detail() {
        return $this->belongsTo(DetailSow::class, 'details_id');
    }
}
