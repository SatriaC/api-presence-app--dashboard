<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    protected $fillable = [
        'users_id',
        'locations',
        'times_in',
        'times_out',
        'photos_in',
        'photos_out',
        'flag',
    ];

    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }
}
