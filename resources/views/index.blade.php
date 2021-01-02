@extends('layouts.app')

@section('title','الرئيسية')

@section('head')
<script defer>
    //Load css files
    var tag = document.createElement("link");
    tag.href = "{{ mix('css/home.css') }}";
    tag.setAttribute('rel', 'stylesheet');
    document.getElementsByTagName("head")[0].appendChild(tag);
</script>
@endsection
@section('content')
<div class="header-wrap parallax" style="background-image: url('{{ Storage::url('assets/header.jpg') }}');">
    <div class="container-fluid h-100 w-100" style="background: rgba(57, 41, 121, 0.82);">
        <div class="row slider-text js-fullheight align-items-center justify-content-center">
            <div class="col-md-9 text-center">
                <h4 class="text-light">أهلًا بيك في موقع فريق ثانوية حلوة .. فريق كامل من المتطوعين بنساعد طلبة الثانوية
                    العامة المصرية </h4>
                <h1 class="text-light">هدفنا نساعدكم توصلوا</h1>
            </div>
        </div>
    </div>
</div>

<section class="bg-light">
    <div class="container-fluid">
        <div class="row d-flex align-items-center">
            <div class="col-md-6 order-md-last heading-section pl-md-5 th-animate">
                <h2 class="mb-4">بنساعد الطالب بكل الأشكال الممكنة</h2>
                <p>
                    في ثانوية عامة بيكون مهم إنك تحدد هدفك وتعرف عايز تعمل إيه بالظبط، وبعدها تشتغل على تحقيق الهدف ده
                    بتركيز وثبات وتمشي خطوات صحيحة في الطريق إليه.
                </p>
                <p>
                    المشكلة إنك وإنت في الطريق ده ساعات بتزهق أو بتتعب، وبتحس إنك مش قادر تكمله، أو بتحصل حاجة تحبطك
                    وتحس إنك ماشي غلط! وعشان كده "ثانوية حلوة" دورها إنها تساعدك في تحديد الطريق وتكون معاك من أوله
                    لآخره؛ ترشدك وتدلك على الأخطاء اللي تتجنبها والحاجات الصح اللي تعملها.
                </p>
            </div>
            <div class="col-md-6">
                <div class="row text-center section1">
                    <div class="col-md-6">
                        <i class="fas fa-crosshairs fa-3x my-3" aria-hidden="true"></i>
                        <div class="media-body">
                            <h3 class="heading mb-3">تحديد الهدف</h3>
                            <p>
                                بنساعدك تحدد هدفك وبنتكلم سوا كتير لحد ما نحدد سوا إيه أنسب كلية ليك، وده لأنك لازم
                                تختار الطريق المناسب عشان تقدر تبدع فيه.
                            </p>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <i class="fas fa-question-circle fa-3x my-3"></i>
                        <div class="media-body">
                            <h3 class="heading mb-3">نصائح عامة</h3>
                            <p>
                                "أذاكر ازاي؟"، "أنظم وقتي ازاي؟"، وغيرهم من الأسئلة اللي بتدور في بال كل طالب ثانوية
                                عامة، وإحنا بنكون معاك وبننزل نصائح في كل الحاجات اللي بتواجهك في فترة الثانوية العامة.
                            </p>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <i class="fas fa-comments fa-2x my-3"></i>
                        <h3 class="heading mb-3">تواصل شخصي</h3>
                        <p>
                            زي ما في مشاكل بتحصل لكل الطلبة، في مشاكل خاصة بيك لوحدك وظروف لحياتك، وعلشان كده بنستقبل
                            رسايلك ونتكلم معاك في كل مشاكلك دي ونحاول نحلها معاك عشان ترتاح نفسيًا وتقدر تذاكر وتركز قدر
                            الإمكان.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <i class="fas fa-user-friends fa-2x my-3"></i>
                        <h3 class="heading mb-3">مش مجرد صفحة</h3>
                        <p>
                            مع الوقت هتلاقي إننا مش مجرد صفحة بتبعتلهم مشكلة ويردوا عليك، هنتحول لأصدقاء وهتلاقي نفسك مع
                            كل حاجة بتحصل في ثانوي سواء حلوة أو وحشة بتيجي تحكيلنا وبتلاقي مننا نفس الحماس نسمعك كل مرة،
                            وهتعرف ليه إحنا مقتنعين إن "ثانوية حلوة".
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="th-counter img" id="eventCounters">
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-6 d-flex">
                <div class="img d-flex align-self-stretch"
                    style="background-image:url({{ Storage::url('assets/events.jpg') }});"></div>
            </div>
            <div class="col-md-6 pl-md-5 py-5">
                <div class="row justify-content-start pb-3">
                    <div class="col-md-12 heading-section th-animate">
                        <h2 class="mb-4">فعاليات غير ربحية</h2>
                        <p>
                            إحنا مش بس بنتكلم عن طريق الفيسبوك، لكن كمان بنعمل events وفعاليات (غير هادفة للربح) بنتكلم
                            مع طلبة ثانوي وأولياء أمورهم كمان، وبيكون فيها جزء ترفيهي عشان يغيروا جو.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 justify-content-center counter-wrap">
                        <div class="block-18 text-center mb-4">
                            <div class="text">
                                <strong class="number" data-number="5">0</strong>
                                <span>فعاليات</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 justify-content-center counter-wrap">
                        <div class="block-18 text-center mb-4">
                            <div class="text">
                                <strong class="number" data-number="+1000">0</strong>
                                <span>طالب استفادوا من فعالياتنا</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 justify-content-center counter-wrap">
                        <div class="block-18 text-center mb-4">
                            <div class="text">
                                <strong class="number" data-number="+58000">30000</strong>
                                <span>متابع على صفحتنا</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section>
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center th-animate">
                <h2 class="mb-4">إجابة لكل أسئلتك في فترة التنسيق</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 th-animate">
                <div class="tansik-part">
                    <a href="{{ route('tansik.geo_dist') }}" class="img"
                        style="background-image: url({{ Storage::url('assets/question-card.jpg') }});">
                        <div class="text">
                            <div class="question-card-overlay"></div>
                            <span>توزيعك الجغرافي</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 th-animate">
                <div class="tansik-part">
                    <a href="{{ route('tansik.previous_edges') }}" class="img"
                        style="background-image: url({{ Storage::url('assets/question-card.jpg') }});">
                        <div class="text">
                            <div class="question-card-overlay"></div>
                            <span>تنسيق السنوات الماضية</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="{{ mix('js/home.js') }}"></script>
@endsection
