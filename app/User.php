<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $table = 'bm_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama','nik', 'email', 'password', 'id_bagian', 'id_lokasi', 'id_wilayah', 'privilege', 'flag'
    ];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];


    public function division() {
        return $this->belongsTo(Division::class, 'id_bagian');
    }

    public function location() {
        return $this->belongsTo(Location::class, 'id_lokasi');
    }

    public function region() {
        return $this->belongsTo(Region::class, 'id_wilayah');
    }

    public function privilege() {
        return $this->belongsTo(Privilege::class, 'privilege');
    }
}
