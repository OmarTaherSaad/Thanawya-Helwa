<?php

namespace App\Models\Ticketing;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Payment extends Model
{
    protected $fillable = [
        'method','date','amount','mobile_of_payment'
    ];

    //User who recieved the payment, not who paid it
    public function PaymentAdder() {
        return $this->belongsTo(User::class,'payment_adder_user_id');
    }

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }

    public function hasNoTicket() {
        return !$this->ticket()->exists();
    }

    public function method() {
        switch($this->method) {
            case 'online-Vodafone-cash':
                return 'أونلاين | فودافون كاش';
                break;
            case 'online-Etisalat-cash':
                return 'أونلاين | اتصالات فلوس';
                break;
            case 'offline-Ebda3':
                return 'شراء يدًا بيد | إبداع';
                break;
            case 'offline-Team-members':
                return 'شراء يدًا بيد | أحد أعضاء الفريق';
                break;
        }
    }

}
