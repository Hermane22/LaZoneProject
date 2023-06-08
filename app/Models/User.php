<?php

namespace App\Models;

use App\Models\User;
use App\Models\Cover;
use App\Models\Memory;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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
    ];

    public static function getAllUsers()
    {
        return User::all();
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    /* public function isAdmin()
    {
        return $this->roles()->where('name', 'admin')->first();
    }

    public function isOperator(array $roles)
    {
        return $this->roles()->whereIn('name', $roles)->first();
    }

    public function isAgentPublic(array $roles)
    {
        return $this->roles()->whereIn('name', $roles)->first();
    }

    public function isSupervisor(array $roles)
    {
        return $this->roles()->whereIn('name', $roles)->first();
    }*/


    public function hasAnyRole(array $roles)
    {
        return $this->roles()->whereIn('name', $roles)->first();
    } 

    public function cvRequests()
    {
        return $this->belongsToMany(Cv::class, 'cv_user', 'user_id', 'cv_id');
    }

    public function coverRequests()
    {
        return $this->belongsToMany(Cover::class, 'cover_user', 'user_id', 'cover_id');
    }

    public function memoryRequests()
    {
        return $this->belongsToMany(Memory::class, 'memorie_user', 'user_id', 'memorie_id');
    }

}
