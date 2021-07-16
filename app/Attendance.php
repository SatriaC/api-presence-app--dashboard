<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    protected $table = 'bm_absen';

    // protected $fillable = [
    //     'users_id',
    //     'locations',
    //     'times_in',
    //     'times_out',
    //     'photos_in',
    //     'photos_out',
    //     'flag',
    // ];

    protected $fillable = [
        'id_user',
        'lokasi_masuk',
        'lokasi_pulang',
        'jam_masuk',
        'jam_pulang',
        'foto_masuk',
        'foto_pulang',
        'flag',
    ];

    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
}
