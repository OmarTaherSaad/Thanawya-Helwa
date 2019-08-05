<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Ticket;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Payment::class,'payment');
    }

    public function index() {
        //Authorize
        $this->authorize('viewAny',Payment::class);
        //view all payments
        if (\Auth::user()->isTeamMember() || \Auth::user()->isAdmin()) {
            $Payments = Payment::all();
        } else {
            //Ebda3
            $Payments = Payment::where('method','offline-Ebda3')->get();
        }
        return view('payments.index')->with(compact('Payments'));
    }

    public function create() {
        //Add payment
        return view('payments.create');
    }

    public function show(Payment $payment)
    {
        return view('payments.show')->with(compact('payment'));
    }

    public function store(Request $request) {
        //Store new payment
        $request->validate([
            'method' => ['required','in:offline-Ebda3,offline-Team-members,online-Vodafone-cash,online-Etisalat-cash'],
            'mobile_of_payment' => ['required', 'numeric', 'digits:11'],
            'amount' => ['required','numeric','min:50'],
            'date' => ['required','date','after_or_equal:today']
        ]);
        $remainder = \Str::contains($request->method,'online') ? $request->amount % Ticket::$OnlinePrice : $request->amount % Ticket::$OfflinePrice;
        if ($remainder == 0) {
            //Valid amount
            if (\Str::contains($request->method,'online')) {
                //Online
                $ticketsCount = $request->amount / Ticket::$OnlinePrice;
            } else {
                //Offline
                $ticketsCount = $request->amount / Ticket::$OfflinePrice;
            }
            //Record payment(s)
            for($i = 0; $i < $ticketsCount; $i++) {
                //Create Payment
                $payment = Payment::create($request->all());
                $payment->amount = $request->amount / $ticketsCount; //Price of one ticket
                $payment->PaymentAdder()->associate($request->user());
                $payment->save();
            }
        } else {
            //Invalid amount paid
            session()->flash('error','المبلغ اللي كتبته مينفعش يكون تمن تذكرة/تذاكر، اتأكد إنك كتبته صح.');
            return back();
        }
        //Link to tickets (offline) if exist.
        $this->linkToTickets($request->mobile_of_payment);
        session()->flash('success',"تم إدخال المبلغ واللي يقدر يشتري عدد $ticketsCount تذكرة");
        return redirect()->route('tas.payments.index');
    }

    public function edit(Request $request, Payment $payment) {
        //Edit existing payment
        return view('payments.edit')->with(compact('payment'));
    }

    public function update(Request $request, Payment $payment) {
        //Update existing payment
        //Validation
        $request->validate([
            'method' => ['required','in:offline-Ebda3,offline-Team-members,online-Vodafone-cash,online-Etisalat-cash'],
            'mobile_of_payment' => ['required', 'numeric', 'digits:11'],
            'amount' => ['required','numeric','min:50'],
            'date' => ['required','date','after_or_equal:today']
        ]);
        $remainder = \Str::contains($request->method,'online') ? $request->amount % Ticket::$OnlinePrice : $request->amount % Ticket::$OfflinePrice;
        if ($remainder != 0) {
            //Invalid amount paid
            session()->flash('error','المبلغ اللي كتبته مينفعش يكون تمن تذكرة/تذاكر، اتأكد إنك كتبته صح.');
            return back();
        }
        //Update
        $payment->update($request->all());
        //Link to tickets (offline) if exist.
        $this->linkToTickets($request->mobile_of_payment);
        session()->flash('success',"تم تعديل عملية الشراء!");
        return redirect()->route('tas.payments.index');
    }

    public function destroy(Payment $payment)
    {
        //Delete a payment
        if ($payment->hasNoTicket()) {
            $payment->delete();
        } else {
            $ticket = $payment->ticket;
            $ticket->paid = false;
            $ticket->mobile_of_payment = null;
            $ticket->payment_method = null;
            $ticket->user()->dissociate();
            $ticket->save();
            $payment->delete();
        }

        session()->flash('success',"تم حذف عملية الشراء بنجاح!");
        return redirect()->route('tas.payments.index');
    }

    public function linkToTickets($mobile_of_payment) {
        $UnusedPayments = Payment::where('mobile_of_payment', $mobile_of_payment)
            ->get()->filter(function($payment) {
                    return $payment->hasNoTicket();
                });
        foreach ($UnusedPayments as $payment) {
            $ticket = Ticket::where([
                'mobile_of_payment' => $mobile_of_payment,
                'payment_method' => $payment->method,
                'paid' => false
            ])->first();
            if ($ticket != null) {
                $ticket->paid = true;
                $payment->ticket()->associate($ticket);
                $ticket->save();
                $payment->save();
            }
        }
    }

}
