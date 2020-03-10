<?php

namespace App\Models\Ticketing;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    static public $OfflinePrice = 50;
    static public $OnlinePrice = 53;

    protected $fillable = [
        'paid', 'type', 'serial', 'secret_token','mobile_of_payment','payment_method'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ownerName() {
        return $this->user()->exists() ? $this->user->name : 'لا أحد';
    }

    public function serial() {
        $serial = strtoupper($this->serial);
        return substr($serial,4*0,4) . '-' . substr($serial,4*1,4) . '-' . substr($serial,4*2,4) . '-'  . substr($serial,4*3,4);
    }

    public function payment() {
        return $this->hasMany(Payment::class);
    }

    public function hasPayment() {
        return $this->payment()->exists() && $this->paid;
    }

    public function hasNoOwner() {
        return !$this->user()->exists() && $this->mobile_of_payment == null;
    }
}
