@extends('layouts.app')

@if(Auth::user()->is($user))
@section('title','تعديل بياناتك')
@else
@section('title','تعديل بيانات "' . $user->name . '"')
@endif

@section('content')
<div class="row my-2">
    <div class="col-12">
        <a href="{{ url()->previous() }}" class="btn btn-primary">الرجوع</a>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="card">
            @if(Auth::user()->is($user))
            <div class="card-header">تعديل بياناتك</div>
            @else
            <div class="card-header">تعديل بيانات "{{ $user->name }}"</div>
            @endif
            <div class="card-body">
                <form method="post" action="{{ route('users.update',['user' => $user]) }}" autocomplete="off">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label>الاسم</label>
                        <input class="form-control" type="text" name="name" value="{{ $user->name }}" required />
                    </div>

                    <div class="form-group">
                        <label>البريد الالكتروني (الايميل)</label>
                        <input class="form-control" type="email" name="email" value="{{ $user->email }}" @if(!is_null($user->email)) required @endif />
                    </div>

                    <div class="form-group">
                        <label>رقم الموبايل</label>
                        <input class="form-control" type="text" pattern="[0-9]{11}" name="mobile_number" value="{{ $user->mobile_number ? $user->mobile_number : old('mobile_number') }}" @if(!is_null($user->mobile_number)) required @endif/>
                    </div>

                    @if (Auth::user()->isAdmin())
                    <div class="form-group">
                        <label for="userRole">الدور (Role)</label>
                        <select class="form-control" id="userRole" name="role">
                            <option {{ $user->role == 'admin' ? 'selected' : '' }} value="admin">إدارة الموقع</option>
                            <option {{ $user->role == 'THteam' ? 'selected' : '' }} value="THteam">فريق "ثانوية حلوة"</option>
                            <option {{ $user->role == 'user' ? 'selected' : '' }} value="user">مُستخدم عادي</option>
                        </select>
                    </div>
                    @endif

                    <div class="form-group">
                        <label>كلمة السر الجديدة</label>
                        <input class="form-control" type="password" name="password" />
                    </div>

                    <div class="form-group">
                        <label>تأكيد كلمة السر الجديدة</label>
                        <input class="form-control" type="password" name="password_confirmation" />
                    </div>

                    <button class="btn btn-primary" type="submit">حفظ البيانات</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
