<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Image;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;

class TicketsController extends Controller
{
    public function index() {
        
        return view('tas.tickets')->with('Tickets',\Auth::user()->tickets);;
        //Hash::check('koctw5v6f9655kpb2',$ticket->secret_token)
    }
    
    public function eventEntry() {
        return view('tas.event-entry');
    }

    public function verify(Request $request) {
        $ticket = Ticket::where('secret_token',$request->ticket_token);
        if ($ticket->count() > 0) {
            return response()->json([
                'success' => true,
                'ticket' => $ticket->first()->toJson(),
                'ticket_serial' => $ticket->first()->serial(),
                'ticket_owner' => !is_null($ticket->first()->user) ? $ticket->first()->user->toJson() : null
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    //Offline payment registeration
    public function registerToUser(Request $request) {
        $ticket = null;
        if ($request->has('ticket_token') && $request->has('paymentMethod')) {
            $ticket = Ticket::where('secret_token',$request->ticket_token)->first();
        } else if ($request->has('ticket_serial') && $request->has('paymentMethod')) {
            $ticket = Ticket::where('serial', strtolower($request->ticket_serial))->first();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'حصل عطل من عندنا، حاول في وقت تاني.'
            ]);
        }
        if ($ticket != null && $ticket->hasNoOwner()) {
            $ticket->mobile_of_payment = $request->user()->mobile_number;
            $ticket->payment_method = $request->paymentMethod;
            $ticket->user()->associate($request->user());
            $ticket->save();

            //Check if Payment exist for the ticket
            $payments = $this->checkPaymentExist($ticket);
            if($payments) {
                //Associate Payment to the Ticket
                $payment = $payments->first();
                $payment->ticket()->associate($ticket);
                $payment->save();
                //Pay the ticket
                $ticket->paid = true;
                $ticket->save();
            }

            return response()->json([
                'success' => true,
                'ticket' => $ticket->toJson(),
                'ticket_serial' => $ticket->serial(),
            ]);
        } else {
            if ($ticket != null && $ticket->user->is($request->user())) {
                return response()->json([
                    'success' => false,
                    'message' => 'التذكرة دي تم تسجيلها بإسمك بالفعل.'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'التذكرة دي تم تسجيلها قبل كده أو غير موجودة، اتأكد إنك بتكتب السيريال صح أو اعمل scan تاني. لو دي تذكرتك ياريت تتواصل معانا على صفحة الفيسبوك.'
            ]);
        }
    }

    //Online payment registeration
    public function registerToMobile(Request $request) {
        //paymentMethod,studentsCount,parentsCount,paymentMobile
        //Ensure all parameters exists
        if (!$request->has('paymentMethod') || !$request->has('studentsCount') || !$request->has('parentsCount')) {
            return response()->json([
                'success' => false,
                'alertClass' => 'danger',
                'message' => 'حصل خطأ من ناحيتنا، ياريت تحاول مرة تانية.'
            ]);
        }
        //Determine mobile of payment
        $mobile = $request->has('paymentMobile') ? $request->paymentMobile : \Auth::user()->mobile_number;
        //Check if there are payment(s) with this mobile
        $payments = \App\Payment::where([
            'mobile_of_payment' => $mobile,
            'method' => $request->paymentMethod
        ]);
        if ($payments->count() > 0) {
            //Yes, he/she has recorded payment(s)
            //This is how many tickets he/she wants
            $ticketsRequested = $request->studentsCount + $request->parentsCount;
            //Here we will save how many of his requests was fullfilled
            $ticketsRegistered_student = 0;
            $counter_student = $request->studentsCount;
            $ticketsRegistered_parent = 0;
            //Alert message
            $alertMsg = "";
            //Let's start with student tickets' requests
            for ($i=0; $i < $ticketsRequested; $i++) { 
                //Set counters
                $type = $counter_student > 0 ? 'student' : 'parent';
                $counter_student--;
                //Get the last available ticket (Online starts from last, as Offline sells from first)
                $ticket = Ticket::where('type',$type)->get()->filter(function($ticket) {
                    return $ticket->hasNoOwner();
                })->last();
                //Check if no tickets available
                if ($ticket == null) {
                    if ($counter_student > 0) {
                        $alertMsg .= "للأسف مفيش تذاكر تكفي طلبك لتذاكر الطلبة<br>";
                    } else {
                        $alertMsg .= "للأسف مفيش تذاكر تكفي طلبك لتذاكر أولياء الأمور<br>";
                    }
                    continue;
                }
                //Link Ticket to a Payment
                //Get available Payment (with no ticket and belongs to this user)
                $UnusedPayment = $payments->get()->filter(function($payment) {
                    return $payment->hasNoTicket();
                })->first();
                if($UnusedPayment != null) {
                    $ticket->mobile_of_payment = $request->paymentMobile;
                    $ticket->payment_method = $request->paymentMethod;
                    $ticket->paid = true;
                    //Link ticket to user
                    $ticket->user()->associate(\Auth::user());
                    $ticket->save();
                    $UnusedPayment->ticket()->associate($ticket);
                    $UnusedPayment->save();
                    $varName = 'ticketsRegistered_'.$type;
                    $$varName++;
                }
            }
            //Determine whether it is a full success or partial (all tickets paid or not)
            if ($ticketsRegistered_student == $request->studentsCount && $ticketsRegistered_parent == $request->parentsCount) {
                $alertClass = 'success';
            } else {
                $alertClass = 'warning';
            }
            if ($ticketsRegistered_student < $request->studentsCount || $ticketsRegistered_parent < $request->parentsCount) {
                $alertMsg .= "حسب البيانات اللي معانا: إنت مدفعتش تمن التذكرة / التذاكر اللي طلبتها كلها.<br>";
            }
            if ($ticketsRegistered_student > 0) {
                $alertMsg .= "تم تسجيل $ticketsRegistered_student تذكرة طلبة<br>";
            }
            if ($ticketsRegistered_parent > 0) {
                $alertMsg .= "تم تسجيل $ticketsRegistered_parent تذكرة أولياء أمور<br>";
            }
            $temp1 = \Auth::user()->tickets()->where('type','student')->count() > 0 ? \Auth::user()->tickets()->where('type','student')->count() . " تذكرة طلبة" : "";
            $temp2 = \Auth::user()->tickets()->where('type','parent')->count() > 0 ? \Auth::user()->tickets()->where('type','parent')->count() . " تذكرة أولياء أمور" : "";
            if ($temp1 == $temp2 && $temp1 == '') {
                $alertMsg .= "لا توجد تذاكر مُسجلة بإسمك.";
            } else {
                $alertMsg .= "إجمالي التذاكر المُسجلة بإسمك:<br>$temp1<br>$temp2";
            }
            if (\Str::endsWith($alertMsg,'<br>')) {
                \Str::replaceLast("<br>", "", $alertMsg);
            }
            return response()->json([
                'success' => true,
                'alertClass' => $alertClass,
                'hasPayment' => true,
                'message' => $alertMsg
            ]);
        }
        //Didn't pay yet!
        else {
            return response()->json([
                'success' => false,
                'alertClass' => 'danger',
                'message' => "مفيش أي عمليات دفع تمت من خلال الرقم ده. لو إنت بالفعل حولت تمن التذكرة / التذاكر، هيتم تسجيلها خلال 12 ساعة بالكتير.
                <br>
                لو لسه محولتش الفلوس، لازم تحولها الأول عشان تقدر تاخد تذكرتك.",
                'hasPayment' => false
            ]);
        }
    }

    public function checkPaymentExist(Ticket $ticket) {
        $payments = \App\Payment::where([
            'mobile_of_payment' => $ticket->mobile_of_payment,
            'method' => $ticket->payment_method])
            ->get()->filter(function($payment) {
                    return $payment->hasNoTicket();
                });
        if ($payments->count() > 0) {
            return $payments;
        } else {
            return false;
        }
    }

    public function getImage(String $ticketSerial) {
        $ticket = Ticket::where('serial',$ticketSerial)->first();
        abort_unless($this->authorize('view',$ticket),\Illuminate\Http\Response::HTTP_FORBIDDEN);
        return response()->file(storage_path("app/tickets/$ticket->id.jpg"));
    }
    public function DownloadImage(String $ticketSerial) {
        $ticket = Ticket::where('serial',$ticketSerial)->first();
        abort_unless($this->authorize('view',$ticket),\Illuminate\Http\Response::HTTP_FORBIDDEN);
        return response()->download(storage_path("app/tickets/$ticket->id.jpg"), \Str::random(20).'jpg');
        //return URL::temporarySignedRoute("tas.tickets.image",now()->addMinutes(5),['user' => \Auth::user() , 'ticket' => $ticket]);
    }

    public function getImageLink(\App\User $user,String $ticket) {
        //echo base64_decode(\Storage::disk('local')->get("tickets/$ticket.jpg"));
        $image = base64_decode(\Storage::disk('local')->get("tickets/$ticket.jpg"));
        //dd(\Storage::disk('local')->get("tickets/$ticket.jpg"));
        //\Storage::put('test/test.txt', $image);
        //$ticket = File::get(storage_path("app/tickets/$ticket.jpg"));
        return response()->file(storage_path("app/tickets/$ticket.jpg"));
        //$ticket = \Storage::disk('local')->get("tickets/$ticket.jpg");
        return view('tas.tickets')->with('ticket',$ticket);
        dd(URL::temporarySignedRoute("tas.tickets.image",now()->addMinutes(5),['user' => \Auth::user() , 'ticket' => $ticket]));
    }
}

//Create Tickets

/*foreach($Tickets as $ticket) {
    $qr = Image::make(base_path('/public/storage/QRCodes/'.$ticket->id.'.png'))->resize(300,300);
    $image = Image::canvas(1000,600,'#ccc')
        ->insert($qr,'left',50,100)
        ->text($ticket->serial(),50,50,function($font) {
            $font->file(base_path('/public/css/fonts/Tajawal-Regular.ttf'));
            $font->size(50);
            $font->valign('top');
        })
        ->text($ticket->id,900,400,function($font) {
            $font->file(base_path('/public/css/fonts/Tajawal-Regular.ttf'));
            $font->size(50);
            $font->valign('top');
        });
    $image->save('storage/tickets/' .$ticket->id.'.jpg');
}*/

//Generates a QrCode with an image centered in the middle.

/*foreach($Tickets as $ticket) {
    \QrCode::format('png')->size(1000)->mergeString(\Storage::get('assets/TASlogo.png'),0.2)->generate($ticket->secret_token,'storage/QRCodes/'.$ticket->id.'.png');
}*/