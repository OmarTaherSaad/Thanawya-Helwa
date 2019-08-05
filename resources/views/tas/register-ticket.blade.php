@extends('layouts.app')
@section('title','تسجيل تذكرة')
@section('content')
<div id="edgesApp">
    <div class="row justify-content-center mt-2">
        <div class="col-12 col-md-10">
            <h3>تسجيل تذكرة حضورك لقمة الثانوية العامة TAS</h3>
            <h5>قبل ما تكمل في أي خطوة من اللي تحت، لازم تكون اشتريت التذكرة بالفعل وموجودة في إيدك (أو دفعت أونلاين وبعتلنا على الواتساب وأكدنا عليك عملية الشراء).</h5>
            <div class="form-group">
                <label for="paymentMethod">برجاء اختيار الطريقة التي قمت بشراء التذكرة من خلالها</label>
                <select class="form-control" id="paymentMethod" v-model="paymentMethod" @change="register.message = null">
                    <option value="offline-Ebda3">اشتريتها من "إبداع"</option>
                    <option value="offline-Team-members">اشتريتها من خلال أحد أعضاء الفريق</option>
                    <option value="online-Vodafone-cash">فودافون كاش</option>
                    <option value="online-Etisalat-cash">اتصالات فلوس</option>
                </select>
            </div>
            <div v-if="register.message != null" role="alert" v-bind:class="register.success" v-html="register.message">
            </div>
            {{--Offline--}}
            <div class="row" v-if="!paymentIsOnline">
                <label>تقدر تعمل Scan للصورة اللي على التذكرة، أو تكتب السيريال اللي عليها بشكل يدوي لو
                    تحب (اعمل حاجة واحدة من الاتنين).</label>
                <div class="col-12 col-md-6">
                    <qrcode-stream @decode="registerTicketFromQR"></qrcode-stream>
                </div>
                <div class="col-12 col-md-6">
                    <the-mask mask="XXXX-XXXX-XXXX-XXXX" v-model="offlineTicketSerial" style="text-transform: uppercase;" type="text" class="form-control"
                        :masked="true" placeholder="اكتب السيريال هنا (16 رقم/حرف)">
                    </the-mask>
                    <button type="button" class="btn btn-primary" @click="registerTicketFromSerial">تسجيل التذكرة</button>
                </div>
            </div>
            {{--Online--}}
            <div v-if="paymentIsOnline">
                <div class="form-group form-check">
                    <input type="checkbox" id="online-mobileCheck" v-model="onlinePayment.sameMobile">
                    <label class="form-check-label" for="online-mobileCheck">أنا حولت تمن التذكرة / التذاكر من نفس رقمي ({{ \Auth::user()->mobile_number }})</label>
                </div>

                <div class="form-group row" v-if="!onlinePayment.sameMobile">
                    <label for="online-TicketScan">اكتب رقم الموبايل اللي دفعت منه</label>
                    <div class="col-12 col-md-6">
                        <the-mask mask="01## ### ####" v-model="onlinePayment.mobile" type="text" dir="ltr" class="form-control" :masked="true"
                            placeholder="اكتب الرقم هنا (11 رقم يبدأوا بـ01)"></the-mask>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="online-studentsCount">عدد تذاكر "الطلبة" المُراد تسجيلها</label>
                    <div class="col-6 col-md-3">
                        <input v-model="onlinePayment.studentsCount" type="number" min="0" class="form-control" placeholder="اكتب عدد التذاكر"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="online-parentsCount">عدد تذاكر "أولياء الأمور" المُراد تسجيلها</label>
                    <div class="col-6 col-md-3">
                        <input v-model="onlinePayment.parentsCount" type="number" min="0" class="form-control" placeholder="اكتب عدد التذاكر"/>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" @click="registerTicketFromMobile">تسجيل التذكرة / التذاكر</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/ticketsScan.js') }}"></script>
@endsection