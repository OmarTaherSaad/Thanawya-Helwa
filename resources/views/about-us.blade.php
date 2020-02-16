@extends('layouts.app')

@section('title','عن الفريق')

@section('content')
<div class="row align-items-center my-3 my-3">
    <div class="col text-center">
        <h1>عن الفريق</h1>
    </div>
</div>
<div class="row text-right my-2 py-2 align-items-center">
    <div class="col-12 col-md-3">
        <a href="{{ Storage::url('assets/images/logo_bg.jpg') }}" class="progressive replace">
            <img src="{{ Storage::url('assets/images/logo_bg-sm.jpg') }}" alt="Thanawya Helwa Team" class="preview img-fluid" style="border-radius: 10%">
        </a>
    </div>
    <div class="col">
        <div class="row my-3">
            <div class="col">
                <h3>
                    إحنا مين؟
                </h3>
                <p>
                    إحنا فريق من طلاب الجامعات, جمعتنا فكرة واحدة وهي مساعدة طلاب المرحلة الثانوية, ومش من
                    كلية أو جامعة واحدة لأ من جامعات مختلفة وكليات متنوعة.
                </p>
            </div>
        </div>
        <hr>
        <div class="row my-3">
            <div class="col">
                <h3>
                    مكاننا فين؟
                </h3>
                <p>
                    حاليًا موجودين في القاهرة، ملناش مقر لكن بنسعى إننا نكون متسجلين تبع جامعة.
                </p>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row text-right my-2 py-2 align-items-center">
    <div class="col">
        <h3>
            بدأنا إزاي؟
        </h3>
        <p>
            إحنا اتجمعنا عن طريق بوست صغير كتبه "عمر طاهر سعد" عشان يشوف مين حابب يساعد طلبة ثانوي, اتجمعنا
            كلنا وقررنا إننا نعمل الصفحة يوم 20-8-2015 ونكون في خدمة الطلبة.
        </p>
    </div>
    <div class="col-md-5 col-12" id="frameContainer">

    </div>
</div>
<hr>
<div class="row text-right my-2 py-2 align-items-center">
    <div class="col-12 col-md-3">
        <a href="{{ Storage::url('assets/images/shantet_elthanawya.jpg') }}" class="progressive replace">
            <img src="{{ Storage::url('assets/images/shantet_elthanawya-sm.jpg') }}" alt="Thanawya Helwa Team" class="preview img-fluid" style="border-radius: 5%">
        </a>
    </div>
    <div class="col">
        <h3>
            بنعمل إيه؟
        </h3>
        <p>
            بنساعدهم بجزئين: نصايح، وشرح المناهج.
            <br><br>
            بننصحهم عن طريق أكتر حاجة بيستخدموها الفترة دي وهي الإنترنت, بنوصلهم عن طريق الموقع بتاعنا وصفحة
            الفيسبوك وبنوجهلهم نصايح عن كل حاجة ممكن يحتاجوها زي مذاكرة كل مادة بتكون إزاي وتنظيم الوقت
            والنوم والأكل والترفية والمشاكل الشخصية اللي أي حد فيهم بيواجهها وكمان بنقدملهم دعم نفسي لو حد
            فيهم محبط أو متضايق أو حتى مش عارف يذاكر من غير سبب واضح وبنحاول نكون أخواتهم الكبار اللي مشايين
            معاهم خطوة بخطوة. مش بس كده, إحنا كمان بنعمل فعاليات وإيفينتات نحمسهم فيها ونساعدهم أكتر,
            ونقابلهم وجهًا لوجه عشان يكلمونا براحتهم أكتر.
            <br><br>
            مؤخرًا كمان بدأنا حاجة جديدة وهي إننا نشرحلهم المناهج كلها، ونساعدهم ضد جشع بعض المدرسين، ومعانا
            مئات المتطوعين اللي مستعدين يشرحوا في أكتر من محافظة، فبنرتبلهم إن بدايةَ من دفعة 2019 هيكون في
            شرح للمناهج متاح على النت وعلى أرض الواقع، وبأسلوب هيفهمهم مش يحفظهم كلام وخلاص.
        </p>
    </div>
</div>
<div dir="ltr">
    @if($members_founder->count() > 0)
    {{-- Founders --}}
    <div class="row">
        <div class="col-12 px-0">
            <!-- Header -->
            <div class="bg-success text-center py-5 mb-4">
                <div class="container">
                    <h1 class="font-weight-light text-white">Meet Our Founders</h1>
                </div>
            </div>

            <!-- Page Content -->
            <div class="container">
                <div class="row justify-content-center">
                    @foreach ($members_founder as $member)
                    <div class="col-xl-4 col-6 mb-4">
                        @include('containers.member',$member)
                    </div>
                    @endforeach
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container -->
        </div>
    </div>
    {{-- Founders END --}}
    @endif
    @if($members_current->count() > 0)
    {{-- Current --}}
    <div class="row">
        <div class="col-12 px-0">
            <!-- Header -->
            <div class="bg-primary text-center py-5 mb-4">
                <div class="container">
                    <h1 class="font-weight-light text-white">and Here is our Current Team!</h1>
                </div>
            </div>

            <!-- Page Content -->
            <div class="container">
                <div class="row justify-content-center">
                    @foreach ($members_current as $member)
                    <div class="col-xl-4 col-6 mb-4">
                        @include('containers.member',$member)
                    </div>
                    @endforeach
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container -->
        </div>
    </div>
    @endif
    {{-- Current END --}}

    {{-- Old --}}
    @if($members_old->count() > 0)
    <div class="row">
        <div class="col-12 px-0">
            <!-- Header -->
            <div class="bg-secondary text-center py-5 mb-4">
                <div class="container">
                    <h1 class="font-weight-light text-white">Also, we would love to thank our former members :)</h1>
                </div>
            </div>

            <!-- Page Content -->
            <div class="container">
                <div class="row justify-content-center">
                    @foreach ($members_old as $member)
                    <div class="col-xl-4 col-6 mb-4">
                        @include('containers.member',$member)
                    </div>
                    @endforeach
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container -->
        </div>
    </div>
    {{-- Old END --}}
    @endif
</div>
@endsection

@section('scripts')
    <script async>
        let iframe = document.createElement('iframe');
        iframe.src = 'https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FOmarTaherSaad%2Fposts%2F865257316855598&width=500';
        iframe.title = "Omar Taher's Facebook post of founding Thanawya Helwa";
        iframe.classList.add('w-100');
        iframe.scrolling = 'no';
        iframe.style.border = 'none';
        iframe.style.overflow = 'hidden';
        iframe.allowTransparency = 'true';
        document.getElementById('frameContainer').appendChild(iframe);
    </script>
@endsection
