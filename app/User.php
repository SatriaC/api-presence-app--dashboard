<?php

namespace App;

use App\Notifications\MailResetPasswordNotification;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'nama', 'nik', 'email', 'no_hp', 'password', 'id_bagian', 'id_lokasi', 'id_wilayah', 'privilege', 'flag'
    ];
    // public $timestamps = false;

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


    public function division()
    {
        return $this->belongsTo(Division::class, 'id_bagian');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_lokasi');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'id_wilayah');
    }

    public function privil()
    {
        return $this->belongsTo(Privilege::class, 'privilege');
    }

    public function sendPasswordResetNotification($token)
    {

        $url = 'https://10.1.150.220/reset-password?token=' . $token;

        $this->notify(new MailResetPasswordNotification($url));
    }
}
