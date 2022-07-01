<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table =  'rooms';
    protected $fillable = [
        'creator_id',
        'name',
        'code',
    ];


    #region releshionships
    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    #endregion

    #region function
    public static function generateCode()
    {
        $token = openssl_random_pseudo_bytes(16);
        return bin2hex($token);
    }

    public static function getRoomBaseCode($room_code)
    {
        return self::where('code', $room_code)->first();
    }
    #endregion
}
