@extends('layouts.app')
@section('title','تعديل عملية شراء')
@section('content')
<div class="row my-1">
    <div class="col-12 col-md-auto">
        <a href="{{ route('tas.payments.index') }}" class="btn btn-primary"><i
                class="fas fa-arrow-alt-circle-right"></i>&nbsp;
            عودة لجميع عمليات الشراء</a>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-auto">
        <h2>تعديل عملية شراء</h2>
    </div>
</div>
<div class="alert alert-warning" role="alert">
    خليك حذر جدًا في تعديل عمليات الشراء، قبل ما تعمل أي تعديل ركز في عواقبه على التذكرة المربوطة بيه.
</div>
<div class="row justify-content-center mt-2">
    <div class="col-12 col-md-6">
        <form action="{{ route('tas.payments.update',['payment' => $payment]) }}" method="POST">
            @csrf
            @method("PATCH")
            <div class="form-group">
                <label for="method">طريقة الشراء</label>
                <select class="form-control" id="method" name="method" required>
                    @if(Auth::user()->isEdba3() || Auth::user()->isAdmin())
                    <option {{ $payment->method == 'offline-Ebda3' ? 'selected' : '' }} value="offline-Ebda3">
                        شراء من "إبداع"
                    </option>
                    @endif
                    @if(Auth::user()->isTeamMember() || Auth::user()->isAdmin())
                    <option {{ $payment->method == 'offline-Team-members' ? 'selected' : '' }}
                        value="offline-Team-members">
                        شراء من خلال أحد أعضاء الفريق
                    </option>
                    <option {{ $payment->method == 'online-Vodafone-cash' ? 'selected' : '' }}
                        value="online-Vodafone-cash">
                        فودافون كاش
                    </option>
                    <option {{ $payment->method == 'online-Etisalat-cash' ? 'selected' : '' }}
                        value="online-Etisalat-cash">
                        اتصالات فلوس
                    </option>
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label for="amount">المبلغ المدفوع</label>
                <select class="form-control" id="method" name="amount" required>
                    <option {{ $payment->amount == 50 ? 'selected' : '' }} value="50">
                        50 جنية
                    </option>
                    <option {{ $payment->amount == 53 ? 'selected' : '' }} value="53">
                        53 جنية
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="mobile_of_payment">رقم الموبايل المُستخدم</label>
                <input type="text" name="mobile_of_payment" id="mobile_of_payment" class="form-control"
                    placeholder="رقم الموبايل بدايةً من 01 والمكون من 11 رقم" pattern="^01[0-9]{9}$"
                    aria-describedby="mobile_of_payment" value="{{ $payment->mobile_of_payment }}" required>
            </div>

            <div class="form-group">
                <label for="date">تاريخ الشراء / الدفع</label>
                <input type="date" name="date" id="date" class="form-control" placeholder="تاريخ الشراء / الدفع"
                    value="{{ $payment->date }}" aria-describedby="date" required>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="تعديل العملية" />
            </div>
        </form>
    </div>

</div>
@endsection