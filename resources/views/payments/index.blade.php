@extends('layouts.app')
@section('title','عرض كل التذاكر المدفوعة')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
@endsection
@section('content')
<div id="edgesApp" class="m-2">
    <div class="row mt-2">
        <div class="col-12 col-md-8">
            <h2>عرض كل التذاكر اللي تم شرائها</h2>
            <h6>لازم كل ما حد يشتري تذكرة تضيف عملية الشراء دي، لأن من غيرها مش هيتم تسجيل شراء الشخص ده للتذكرة</h6>
        </div>
        <div class="col-12 col-md-4">
        <a class="btn btn-primary" href="{{ route('tas.payments.create') }}" role="button">إضافة عملية شراء جديدة</a>
        </div>
    </div>
    <div class="row">
        <h4 class="d-block d-sm-none">اتحرك يمين وشمال جوا الجدول عشان تشوف باقي السنوات</h4>
        <div class="col-12 table-responsive">
            <table class="table table-light table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>وسيلة الدفع</th>
                        <th>المبلغ</th>
                        <th>الموبايل المٌستخدم / المُسجل</th>
                        <th>التاريخ</th>
                        <th>تم ربط التذكرة؟</th>
                        <th>صاحب التذكرة المربوطة</th>
                        <th>تمت إضافتها بواسطة</th>
                        <th>تعديل | حذف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Payments as $payment)
                    <tr>
                        <td>{{ $payment->method() }}</td>
                        <td>{{ $payment->amount }} جنية</td>
                        <td>{{ $payment->mobile_of_payment }}</td>
                        <td>{{ $payment->date }}</td>
                        <td>{{ $payment->hasNoTicket() ? 'لا' : 'نعم' }}</td>
                        <td>{{ $payment->hasNoTicket() ? 'لم يتم الربط' : $payment->ticket->user->name }}</td>
                        <td>{{ $payment->PaymentAdder->name }}</td>
                        <td>
                            @if(\Auth::user()->isAdmin())
                            <div class="btn-group" role="group" aria-label="Controls" dir="ltr">
                                <a href="{{ route('tas.payments.edit',['payment' => $payment]) }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i>
                                    &nbsp;
                                    تعديل</a>
                                    <button type="button" class="btn btn-danger" data-link="{{ route('tas.payments.destroy',['payment' => $payment]) }}" @click="toDelete" data-toggle="modal" data-target="#deleteConfirmModal">
                                        <i class="fas fa-trash-alt"></i>
                                        &nbsp;
                                        حذف    
                                    </button>
                            </div>
                            @else
                            لا يمكنك تعديل أو حذف العملية
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{--Confirmation box for deletion--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteConfirmModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">هل أنت متأكد أن تريد حذف هذه العملية؟</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>لازم تكون حريص لأن ده هيلغي ربطها بأي تذكرة وبالتالي هيأثر على اللي حاجز التذكرة. تأكد إنك تكون عارف بتعمل إيه.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء الحذف</button>
                    <form class="delete" v-bind:action="toDeleteLink" method="POST">
                        @csrf
                        @method("DELETE")
                        <input type="submit" value="تأكيد حذف عملية الدفع" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/payment.js') }}"></script>
@endsection