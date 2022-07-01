<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'avatar',
        'isOnline',
    ];

    const isOnline =  [
        'offline' => 0,
        'online'  => 1
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    #region relationships
    public function rooms()
    {
        return $this->hasMany(Room::class, 'creator_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
    public function AauthAcessToken()
    {
        return $this->hasMany(OauthAccessToken::class);
    }

    public function canJoinRoom($room_id)
    {
        return $this->participants()->where('room_id', $room_id)->first() ? true : false;
    }
    #endregion

    #region functions
    public static function getUser($type, $email_username): object
    {
        return self::where($type, $email_username)->first();
    }
    #endregion
}
