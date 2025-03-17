<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const Role_Admin = 'admin';
    const Role_User = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'last_login_at',
        'role',
        'password',
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
        'password' => 'hashed',
        'last_login_at' => 'datetime',

    ];

    public function profile(){
        return $this->hasOne(Profile::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }
    public function wishlist()
{
    return $this->hasMany(Wishlist::class, 'user_id');
}

public function isOnline()
{
    if (Cache::has('user-is-offline-' . $this->id)) {
        return false;
    }
    return $this->last_login_at && $this->last_login_at->gt(Carbon::now()->subMinutes(5));
}

}
