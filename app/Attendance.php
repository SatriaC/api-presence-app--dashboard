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
        'latitude_masuk',
        'longitude_masuk',
        'latitude_pulang',
        'longitude_pulang',
        // 'lokasi_pulang',
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
