@extends('layouts.app')
@section('title','عرض كل الحسابات المُسجلة')
@section('head')
<link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
<style>
    .fit-content {
        white-space: nowrap;
        width: 1%;
    }
</style>
@endsection
@section('content')
<div id="edgesApp" class="m-2">
    <div class="row mt-2">
        <div class="col-12 col-md-8">
            <h2>عرض كل الحسابات المُسجلة</h2>
        </div>
    </div>
    <div class="row">
        <h4 class="d-block d-sm-none">اتحرك يمين وشمال جوا الجدول عشان تشوف باقي البيانات</h4>
        <div class="col-12 table-responsive">
            <table class="table table-light table-bordered table-hover table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th class="align-middle">الاسم</th>
                        <th class="align-middle">الايميل</th>
                        <th class="align-middle">الموبايل</th>
                        <th class="align-middle">سجل بالفيسبوك؟</th>
                        <th class="align-middle">التذاكر</th>
                        <th class="align-middle">المدفوعات</th>
                        <th class="align-middle">نوع الحساب</th>
                        <th class="align-middle">تعديل</th>
                        <th class="align-middle">تاريخ التسجيل</th>
                        <th class="align-middle">آخر تعديل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Users as $user)
                    <tr>
                        <td class="fit-content">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile_number ? $user->mobile_number : 'لم يُسجل بعد' }}</td>
                        <td>{{ $user->provider == 'facebook' ? "نعم" : "لا" }}</td>
                        <td>{{ $user->hasTicket() ? $user->tickets()->count() : 'لا يمتلك تذاكر' }}</td>
                        <td>{{ $user->hadPaidAnyPayments() ? $user->paidPayments()->count() : 'لم يدفع أي مدفوعات' }}</td>
                        <td>{{ Str::title($user->role) }}</td>
                        <td>
                            @if(\Auth::user()->isAdmin())
                            <div class="btn-group" role="group" aria-label="Controls" dir="ltr">
                                <a href="{{ route('edit-user',['user' => $user]) }}" class="btn btn-info">
                                    <i class="fas fa-edit"></i>
                                    &nbsp;
                                    تعديل</a>
                            </div>
                            @else
                            لا يمكنك تعديل أو حذف المٌستخدم
                            @endif
                        </td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>{{ $user->updated_at->diffForHumans() }}</td>
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
                    <p>لازم تكون حريص لأن ده هيلغي ربطها بأي تذكرة وبالتالي هيأثر على اللي حاجز التذكرة. تأكد إنك تكون
                        عارف بتعمل إيه.</p>
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