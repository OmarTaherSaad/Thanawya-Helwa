<?php

namespace App;

use App\Traits\Memberable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use Memberable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'mobile_number', 'year', 'email', 'password', 'provider', 'provider_id', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($role) {
        return $this->role == $role;
    }

    public function isTeamMember() {
        return  $this->role == 'THteam' || $this->role == 'admin';
    }

    public function isEdba3() {
        return $this->role == 'Ebda3team';
    }

    public function isAdmin() {
        return $this->role == 'admin';
    }
}
