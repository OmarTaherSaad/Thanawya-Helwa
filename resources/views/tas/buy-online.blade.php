@extends('layouts.app')
@section('title','شراء تذاكر TAS أونلاين')
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="jumbotron jumbotron-fluid">
            <div class="container-fluid">
                <h1 class="display-4">شراء تذاكر "TAS" أونلاين</h1>
                <p class="lead">إحنا بنقدملك طريقتين لشراء تذاكر قمة الثانوية العامة "TAS" من أي مكان: "فودافون كاش" و "اتصالات فلوس"</p>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-md-2 col-12">
                <div class="list-group" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list"
                        href="#list-VCash" role="tab" aria-controls="VodafoneCash">فودافون كاش</a>
                    <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
                        href="#list-ECash" role="tab" aria-controls="EtisalatCash">اتصالات فلوس</a>
                </div>
            </div>
            <div class="col-md-10 col-12">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="list-VCash" role="tabpanel" aria-labelledby="list-VCash-list">
                        <h5>تقدر تشتري التذكرة باستخدام فودافون كاش</h5>
                        <ul class="list-group">
                            <li class="list-group-item">
                                تتأكد إنك مفعل خدمة "فودافون كاش" على الخط بتاعك (تقدر تعمل ده من خدمة العملاء لو مش فاكر أو لما تتصل بـ<a dir="ltr" href="tel:7001">7001</a>)
                                <br>
                                لو مش مفعلها عندك، هتروح لأقرب فرع فودافون ومعاك بطاقتك (لو الخط بإسمك) وتطلب تشغيل خدمة فودافون كاش.
                            </li>
                            <li class="list-group-item">
                                تتأكد إن حسابك في فودافون كاش فيه أكتر من 54 جنية (لمعرفة رصيد حسابك استخدم الكود ده <a dir="ltr" href="tel:*9*13#">*9*13#</a>
                                <br>
                                لو حسابك مفيهوش المبلغ، بتروح أقرب فرع فودافون ومعاك بطاقتك (لو الخط بإسمك) وتطلب تشحن فودافون كاش بتاعك.
                            </li>
                            <li class="list-group-item">تحول 53 جنية للرقم: <strong dir="ltr">0101 183 6776</strong> (تقدر تعمل ده من الكود ده <a dir="ltr" href="tel:*9*7*01011836776*53#">*9*7*01011836776*53#</a>). اتأكد إنك بتكتب الرقم زي ما كاتبينه فوق</li>
                            <li class="list-group-item">هترجع هنا على الموقع تعمل <a href="{{ route('tas.tickets.register') }}">تسجيل للتذكرة</a></li>
                            <li class="list-group-item">لو عدى 12 ساعة ولسه التحويل بتاعك متسجلش، ابعتلنا رسالة واتساب على نفس الرقم تقولنا إنك حولت الفلوس، تقدر تبعتها <a href="https://wa.me/201011836776/?text=%D8%A3%D9%86%D8%A7%20%D8%AF%D9%81%D8%B9%D8%AA%20%D8%AA%D8%B0%D9%83%D8%B1%D8%A9%20TAS%20%D8%A8%D8%A7%D8%B3%D8%AA%D8%AE%D8%AF%D8%A7%D9%85%20%D9%81%D9%88%D8%AF%D8%A7%D9%81%D9%88%D9%86%20%D9%83%D8%A7%D8%B4">من هنا</a>.</li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="list-ECash" role="tabpanel" aria-labelledby="list-ECash-list">
                        <h5>تقدر تشتري التذكرة باستخدام اتصالات فلوس</h5>
                        <ul class="list-group">
                            <li class="list-group-item">
                                تتأكد إنك مفعل خدمة "اتصالات فلوس" على الخط بتاعك (تقدر تعمل ده من خدمة العملاء لو مش فاكر أو لما تتصل بـ<a
                                    dir="ltr" href="tel:778">778</a>)
                                <br>
                                لو مش مفعلها عندك، هتروح لأقرب فرع اتصالات ومعاك بطاقتك (لو الخط بإسمك) وتطلب تشغيل خدمة اتصالات فلوس.
                            </li>
                            <li class="list-group-item">
                                تتأكد إن حسابك في اتصالات فلوس فيه أكتر من 54 جنية (لمعرفة رصيد حسابك استخدم الكود ده <a dir="ltr"
                                    href="tel:*777#">*777#</a>
                                <br>
                                لو حسابك مفيهوش المبلغ، بتروح أقرب فرع اتصالات ومعاك بطاقتك (لو الخط بإسمك) وتطلب تشحن محفظة اتصالات فلوس بتاعك.
                            </li>
                            <li class="list-group-item">تحول 53 جنية (لكل تذكرة) للرقم: <strong dir="ltr">0114 691 9792</strong> (تقدر تعمل ده من الكود ده
                                <a dir="ltr" href="tel:*777#">*777#</a> وتختار "إرسال مبلغ"). اتأكد إنك بتكتب الرقم زي ما كاتبينه فوق</li>
                            <li class="list-group-item">هترجع هنا على الموقع تعمل <a href="{{ route('tas.tickets.register') }}">تسجيل للتذكرة</a>
                            </li>
                            <li class="list-group-item">لو عدى 12 ساعة ولسه التحويل بتاعك متسجلش، ابعتلنا رسالة واتساب على نفس الرقم تقولنا إنك حولت الفلوس، تقدر تبعتها <a href="https://wa.me/201146919792/?text=%D8%A3%D9%86%D8%A7%20%D8%AF%D9%81%D8%B9%D8%AA%20%D8%AA%D8%B0%D9%83%D8%B1%D8%A9%20TAS%20%D8%A8%D8%A7%D8%B3%D8%AA%D8%AE%D8%AF%D8%A7%D9%85%20%D8%A7%D8%AA%D8%B5%D8%A7%D9%84%D8%A7%D8%AA%20%D9%81%D9%84%D9%88%D8%B3">من
                                    هنا</a>.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection