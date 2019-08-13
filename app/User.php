<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
    public function hasTicket() {
        return $this->tickets->count() > 0;
    }

    public function hasRole($role) {
        return $this->role == $role;
    }

    public function canAddPayments() {
        return $this->role == 'Ebda3team' || $this->role == 'TAteam'  || $this->role == 'admin';
    }

    public function isTeamMember() {
        return  $this->role == 'TAteam';
    }

    public function isEdba3() {
        return $this->role == 'Ebda3team';
    }

    public function isAdmin() {
        return $this->role == 'admin';
    }

    public function hadPaidAnyPayments() {
        return \App\Payment::all()->where('mobile_of_payment',$this->mobile_number)->count() > 0;
    }
    
    public function paidPayments() {
        return $this->hadPaidAnyPayments() ? \App\Payment::all()->where('mobile_of_payment',$this->mobile_number) : false;
    }
}
