@extends('layouts.app')

@section('title','تعديل بياناتك')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="card">
            <div class="card-header">تعديل بياناتك</div>
            <div class="card-body">
                <form method="post" action="{{ route('edit-user',['user' => Auth::user()->id]) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label>الاسم</label>
                        <input class="form-control" type="text" name="name" value="{{ $user->name }}" required />
                    </div>

                    <div class="form-group">
                        <label>البريد الالكتروني (الايميل)</label>
                        <input class="form-control" type="email" name="email" value="{{ $user->email }}" required />
                    </div>

                    <div class="form-group">
                        <label>رقم الموبايل</label>
                        <input class="form-control" type="text" pattern="[0-9]{11}" name="mobile_number" value="{{ $user->mobile_number ? $user->mobile_number : old('mobile_number') }}" required />
                        <small class="form-text text-muted">في خانة رقم الموبايل، لازم تكتب رقم الموبايل اللي استخدمته / هتستخدمه في
                            الدفع.</small>
                    </div>

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