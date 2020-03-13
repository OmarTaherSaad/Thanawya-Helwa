<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class,'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index')->with('users',User::paginate(config('app.pagination_max')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //abort_unless(auth()->user()->is($user),\Illuminate\Http\Response::HTTP_FORBIDDEN);
        return view('users.edit')->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //abort_unless(auth()->user()->is($user),\Illuminate\Http\Response::HTTP_FORBIDDEN);
        $v = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable','in:admin,THteam,Ebda3team,user']
        ]);
        $v->sometimes('email','required|string|email|max:255|unique:users,email,'.$user->id,function() use ($user) {
            return !is_null($user->email);
        });
        $v->sometimes('mobile_number', 'required|numeric|digits:11|unique:users,mobile_number,'.$user->id,function() use ($user) {
            return !is_null($user->mobile_number);
        });
        $v->validate();

        $user->name = $request->name;
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('mobile_number')) {
            $user->mobile_number = $request->mobile_number;
        }
        if (auth()->user()->isAdmin()) {
            //Avoid being locked: if user to edit is the last admin, and we are trying to make him non-admin -> NOT ALLOWED
            if (auth()->user()->is($user) //He is the user to edit
                && User::where('role','admin')->count() == 1 //And he is the last admin
                && $request->role != null //And role is sent
                && $request->role != 'admin' //And role is not 'admin'!
            ) {
                session()->flash('error', 'مينفعش نخليك مش في إدارة الموقع، لأنك آخر مدير موجود دلوقتي.');
            } else {
                $user->role = $request->role;
            }
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        if (auth()->user()->isAdmin() && !auth()->user()->is($user)) {
            session()->flash('success','تم حفظ بيانات العضو بنجاح.');
            return redirect()->route('users.index');
        }
        session()->flash('success','تم حفظ بياناتك بنجاح.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $logged_out = false;
        if (auth()->user()->is($user)) {
            $logged_out = true;
        }
        $user->delete();
        if ($logged_out) {
            session()->flash('warning','We are sad to see you going. Account deleted successfully.');
            return redirect()->route('home');
        }
        session()->flash('success','Account deleted successfully.');
        return redirect()->route('users.index');
    }

    public function notifications(User $user)
    {
        return view('users.notifications')->with(compact('user'));
    }

    public function markNotificationsAsRead(User $user)
    {
        $user->unreadNotifications->markAsRead();
        return response()->json([
            'success' => true
        ]);
    }
}
