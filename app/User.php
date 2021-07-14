<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'divisions_id', 'locations_id', 'regions_id', 'privileges_id', 'flag'
    ];

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
        return $this->belongsTo(Division::class, 'divisions_id');
    }

    public function location() {
        return $this->belongsTo(Location::class, 'locations_id');
    }

    public function region() {
        return $this->belongsTo(Region::class, 'regions_id');
    }

    public function privilege() {
        return $this->belongsTo(Privilege::class, 'privileges_id');
    }
}
