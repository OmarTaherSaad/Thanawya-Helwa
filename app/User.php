<?php

namespace App;

use App\Jobs\SendPasswordResetEmail;
use App\Notifications\Auth\ResetPassword;
use App\Notifications\Auth\VerifyEmail;
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

    public function hasRole($role)
    {
        return $this->role == $role;
    }

    public function isTeamMember()
    {
        return  $this->role == 'THteam' || $this->role == 'admin';
    }

    public function isEdba3()
    {
        return $this->role == 'Ebda3team';
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function readNotificationsData()
    {
        $notifications = collect();
        foreach ($this->readNotifications as $notif) {
            $notif = $notif->data;
            $notif['read'] = true;
            $notifications->push($notif);
        }
        return $notifications;
    }
    public function unreadNotificationsData()
    {
        $notifications = collect();
        foreach ($this->unreadNotifications as $notif) {
            $notif = $notif->data;
            $notif['read'] = false;
            $notifications->push($notif);
        }
        return $notifications;
    }

    public function notificationsData()
    {
        return $this->unreadNotificationsData()->merge($this->readNotificationsData());
    }

    public function latestNotificationsData()
    {
        $takeRead = max(10 - $this->unreadNotificationsData()->take(10)->count(), 0);
        return $this->unreadNotificationsData()->merge($this->readNotificationsData()->take($takeRead));
    }

    public static function teamMembers()
    {
        return User::all()->filter(function ($user) {
            return $user->isTeamMember();
        });
    }
    public static function admins()
    {
        return User::all()->filter(function ($user) {
            return $user->isAdmin();
        });
    }
}
