<?php

namespace App\Traits;

use App\Ticketing\Ticket;
use App\Ticketing\Payment;

/**
 * Trait for ticket buying
 */
trait CanBuyTickets
{
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function hasTicket()
    {
        return $this->tickets->count() > 0;
    }

    public function canAddPayments()
    {
        return $this->role == 'Ebda3team' || $this->role == 'TAteam'  || $this->role == 'admin';
    }

    public function hadPaidAnyPayments()
    {
        return Payment::all()->where('mobile_of_payment', $this->mobile_number)->count() > 0;
    }

    public function paidPayments()
    {
        return $this->hadPaidAnyPayments() ? Payment::all()->where('mobile_of_payment', $this->mobile_number) : false;
    }
}
