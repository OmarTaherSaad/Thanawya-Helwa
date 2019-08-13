<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

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
        return view('users.index')->with('Users',User::all());
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'mobile_number' => ['required', 'numeric', 'digits:11', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable','in:admin,TAteam,Ebda3team,user']
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_number = $request->mobile_number;
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
        session()->flash('success','تم حفظ بياناتك بنجاح.');
        if (auth()->user()->isAdmin() && !auth()->user()->is($user)) {
            return redirect()->route('allUsers');
        }
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
        //
    }
}
