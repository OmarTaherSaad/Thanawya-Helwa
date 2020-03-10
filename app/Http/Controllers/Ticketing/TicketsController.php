<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticketing\Ticket;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Image;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use App\User;

class TicketsController extends Controller
{
    public function index() {
        if (\Auth::user()->isAdmin()) {
            return view('tas.tickets')
            ->with('Tickets',\Auth::user()->tickets)
            ->with('AllTickets',Ticket::all()->reject(function ($ticket) {
                return $ticket->hasNoOwner();
            }));
        }
        return view('tas.tickets')->with('Tickets',\Auth::user()->tickets);
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
        $payments = \App\Models\Ticketing\Payment::where([
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
        $payments = \App\Models\Ticketing\Payment::where([
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

    public function DownloadAll(User $user) {
        $zipName = public_path("storage/app/tickets_zip/".\Str::slug($user->name) . "-tickets.zip");
        $zip = new \ZipArchive();
        foreach($user->tickets as $ticket) {
            abort_unless($this->authorize('view',$ticket),\Illuminate\Http\Response::HTTP_FORBIDDEN);

            $zip->open($zipName, \ZipArchive::CREATE);
            $zip->addFile(storage_path("app/tickets/$ticket->id.jpg"),"tickets/$ticket->id.jpg");
            dd($zip);
            $zip->close();
        }
        return response()->download(storage_path("app/tickets_zip/".\Str::slug($user->name) . "-tickets.zip"));
    }

    public function eventEntered(Request $request) {
         $ticket = Ticket::where('secret_token',$request->ticket_token);
        if ($ticket->count() > 0) {
            $ticket = $ticket->first();
            if ($ticket->checked_in) {
                //Ticket already entered
                return response()->json([
                    'alertClass' => 'danger',
                    'message' => "التذكرة دي دخلت قبل كده!"
                ]);
            } else {
                //Enter the ticket
                $ticket->checked_in = true;
                $ticket->save();
                return response()->json([
                    'alertClass' => 'success',
                    'message' => 'تم تسجيل الدخول بهذه التذكرة، ابتسامة لطيفة، وقول أهلًا بيك :)'
                ]);
            }
        } else {
            return response()->json([
                'alertClass' => 'danger',
                'message' => "دي مش تذكرة مُسجلة عندنا!"
            ]);
        }
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

//Create Tickets groups (A3 -> 12 per page)

/*
$i = 1;
$filesArr = \Storage::files('tickets');
natsort($filesArr);
foreach (collect($filesArr)->chunk(12) as $ticketsGroup) {
    $image = Image::make(\Storage::get("groupTemplate.jpg"));
    $counterX = 0;
    $counterY = 0;
    foreach ($ticketsGroup as $ticket) {
        $TicketImage = Image::make(\Storage::get($ticket))->resize(round($image->height() / 3) - 1, round($image->width() / 4) - 1)->rotate(90);
        $image->insert($TicketImage, 'top-left', round($counterX * $image->width() / 4), round($counterY * $image->height() / 3));
        if ($counterX < 3) {
            //Lines
            $image->line(
                round($counterX * $image->width() / 4),
                0,
                round($counterX * $image->width() / 4),
                $image->height()
                , function ($draw) {
                    $draw->color('#ffffff');
                });
            $counterX++;
        } else {
            //Lines
            $image->line(
                round($counterX * $image->width() / 4),
                0,
                round($counterX * $image->width() / 4),
                $image->height()
                , function ($draw) {
                    //$draw->file(base_path('/public/css/fonts/Tajawal-Regular.ttf'));
                    $draw->color('#ffffff');
                });
            $counterY++;
            $counterX = 0;
        }
        $i++;
    }
    $i--;
    $image->save("storage/ticketsGroup/From-" . ($i - 11) . "-To-$i.jpg");
    echo "Done ticket Group $i <br>";
    $i++;
}
dd("DONE ALL");
*/

//Create Tickets groups (A4 -> 6 per page)
/*
$i = 1;
$filesArr = \Storage::files('tickets');
natsort($filesArr);
foreach (collect($filesArr)->chunk(6) as $ticketsGroup) {
    $image = Image::make(\Storage::get("ticketTemplate2.jpg"));
    $counterX = 0;
    $counterY = 0;
    foreach ($ticketsGroup as $ticket) {
        $TicketImage = Image::make(\Storage::get($ticket))->resize(round($image->height() / 2) - 1, round($image->width() / 3) - 1)->rotate(90);
        $image->insert($TicketImage, 'top-left', round($counterX * $image->width() / 3), round($counterY * $image->height() / 2));
        if ($counterX < 2) {
            //Lines
            $image->line(
                round($counterX * $image->width() / 3),
                0,
                round($counterX * $image->width() / 3),
                $image->height()
                , function ($draw) {
                    $draw->color('#ffffff');
                });
            $counterX++;
        } else {
            //Lines
            $image->line(
                round($counterX * $image->width() / 3),
                0,
                round($counterX * $image->width() / 3),
                $image->height()
                , function ($draw) {
                    //$draw->file(base_path('/public/css/fonts/Tajawal-Regular.ttf'));
                    $draw->color('#ffffff');
                });
            $counterY++;
            $counterX = 0;
        }
        $i++;
    }
    $i--;
    $image->save("storage/ticketsGroup2/From-" . ($i - 5) . "-To-$i.jpg");
    echo "Done ticket Group $i <br>";
    $i++;
}
dd("DONE ALL");
*/
