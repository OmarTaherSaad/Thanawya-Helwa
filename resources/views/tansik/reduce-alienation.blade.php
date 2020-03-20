@extends('layouts.app')
@section('title','معلومات عن تقليل الاغتراب')
@section('content')
<div class="row text-center">
    <div class="col m-2 p-2">
        <div class="jumbotron jumbotron-fluid">
            <h1>يعني إيه تقليل اغتراب؟</h1>
            <p class="lead">هنا هنقولك كل حاجة محتاج تعرفها عن تقليل الاغتراب وشروطه، وهتلاقي إجابة كل الأسئلة الشائعة
                بخصوص الموضوع ده.</p>
            <hr class="my-4">
            <p>لو عايز تعرف الجامعات المتاحة لمحافظتك والمجموعات (أ،ب،ج) دوس هنا</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="{{ route('tansik.geo_dist') }}" role="button">دوس هنا</a>
            </p>
        </div>
    </div>
</div>
<div class="row text-center justify-content-center">
    <div class="col-12 col-md-11">
        <div class="accordion" id="ReduceAlienationQuestions">
            {{--إيه تقليل الاغتراب ده؟--}}
            <div class="card">
                <div class="card-header" id="heading1">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                            إيه تقليل الاغتراب ده؟
                        </button>
                    </h5>
                </div>

                <div id="collapse1" class="collapse" aria-labelledby="heading1"
                    data-parent="#ReduceAlienationQuestions">
                    <div class="card-body">
                        <p>
                            لما تظهر نتيجة التنسيق ويجيلك كلية بعيدة عنك -بعيدة يعني خارج جامعات مجموعة (أ)؛ من مجموعة
                            (ب) أو (ج) - تقدر تعمل حاجة اسمها "تقليل اغتراب" وده بيخليك تحول لنفس الكلية بس في جامعة من
                            مجموع (أ) ، والغرض منه تحويلك لمكان قريب، لكن مش التحويل عشان غيرت رأيك.
                            <br>
                            يعني مينفعش مثلًا تكون من سكان القاهرة، وجاتلك كلية ألسن مثلًا، تقوم عامل تقليل اغتراب عشان
                            تحول لكلية آداب، لأن الكلية اللي تم ترشيحك ليها أساسًا من مجموعة (أ).
                            <br>
                            وبيتقسم لنوعين: <strong>تحويل لكلية مناظرة، وتحويل لكلية غير مناظرة</strong>.
                        </p>
                    </div>
                </div>
            </div>

            {{--يعني إيه تحويل لكلية مناظرة؟--}}
            <div class="card">
                <div class="card-header" id="heading3">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            يعني إيه تحويل لكلية مناظرة؟
                        </button>
                    </h5>
                </div>
                <div id="collapse3" class="collapse" aria-labelledby="heading3"
                    data-parent="#ReduceAlienationQuestions">
                    <div class="card-body">
                        <p>
                            يعني هتحول لنفس الكلية في جامعة مختلفة، مثال: أنت من سكان القاهرة، بس مجموعك مجابش إنك تدخل
                            هندسة من اللي في القاهرة، فاضطريت تدخل هندسة أسيوط، تقدر تقدم طلب تقليل اغتراب فيخلوك تدخل
                            هندسة من اللي في القاهرة حتى لو مجموعك مش جايبها، بس بيحولوك لكلية الهندسة اللي واخدة من أقل
                            مجموع في مجموعة (أ) يعني مش بتختار عايز أنهي جامعة في القاهرة.
                        </p>
                    </div>
                </div>
            </div>

            {{--يعني إيه تحويل لكلية غير مناظرة؟ وإيه شروطه؟--}}
            <div class="card">
                <div class="card-header" id="heading4">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            يعني إيه تحويل لكلية غير مناظرة؟ وإيه شروطه؟
                        </button>
                    </h5>
                </div>
                <div id="collapse4" class="collapse" aria-labelledby="heading4"
                    data-parent="#ReduceAlienationQuestions">
                    <div class="card-body">
                        <p>
                            يعني هتحول لكلية مختلفة، مثال: أنت من سكان القاهرة، بس مجموعك جابلك تدخل آداب أسيوط مثلًا،
                            وأنت عايز تحول كلية تجارة في القاهرة مش كلية آداب، فـ ساعتها بتعمل تقليل اغتراب بشرط إنك
                            تكون جايب مجموع تجارة في القاهرة (مش زي التحويل للكليات المناظرة)، وكمان شرط إنك تكون ناجح
                            في اختبار القدرات لو كنت ناوي تروح كلية ليها اختبار قدرات زي فنون جميلة مثلًا وغيرها.
                        </p>
                    </div>
                </div>
            </div>

            {{--اعرف منين الجامعات اللي في مجموعة "أ" لمحافظتي؟--}}
            <div class="card">
                <div class="card-header" id="heading2">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            أعرف منين الجامعات اللي في مجموعة (أ) لمحافظتي؟
                        </button>
                    </h5>
                </div>
                <div id="collapse2" class="collapse" aria-labelledby="heading2"
                    data-parent="#ReduceAlienationQuestions">
                    <div class="card-body">
                        <p><a href="{{ route('tansik.geo_dist') }}" target="_blank" rel="noopener">دوس هنا</a> واختار محافظتك والإدارة
                            التعليمية اللي تابع ليها وإحنا هنقولك إيه الجامعات اللي في مجموعة (أ) ليك.</p>
                    </div>
                </div>
            </div>

            {{--إيه نظام التحويل المُناظر في الكليات اللي فيها انتظام وانتساب موجه؟--}}
            <div class="card">
                <div class="card-header" id="heading5">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            إيه هو نظام التحويل المُناظر في الكليات اللي فيها انتظام وانتساب موجه؟
                        </button>
                    </h5>
                </div>
                <div id="collapse5" class="collapse" aria-labelledby="heading5"
                    data-parent="#ReduceAlienationQuestions">
                    <div class="card-body">
                        <p>
                            في حالة ترشيحك لكلية بنظام انتظام وعايز تحول لكلية زيها (مناظرة) فعندنا حالتين:
                            <br>
                            <ul class="list-group text-right">
                                <li class="list-group-item">
                                    لو جايب مجموع درجات أكتر من الحد الأدنى لدرجات نظام انتساب موجه في الكلية اللي عايز
                                    تروحها، هيتم تقييدك في نظام انتظام.
                                </li>
                                <li class="list-group-item">
                                    لو جايب مجموع درجات يساوي أو أقل من الحد الأدنى لنظام انتساب موجه في الكلية اللي
                                    عايز تروحها، هيتم تقييدك في نظام انتساب موجه.
                                </li>
                            </ul>
                            <br>
                            أما لو تم ترشيحك لكلية بنظام انتساب موجه وعايز تحول لكلية مناظرة (زيها) فلازم هتتحول انتساب
                            موجه مينفعش تتحول انتظام.
                        </p>
                    </div>
                </div>
            </div>

            {{--هل أي حد يقدر يعمل تقليل اغتراب؟ مفيش حدود؟--}}
            <div class="card">
                <div class="card-header" id="heading6">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                            هل أي حد يقدر يعمل تقليل اغتراب؟ مفيش حدود؟
                        </button>
                    </h5>
                </div>
                <div id="collapse6" class="collapse" aria-labelledby="heading6"
                    data-parent="#ReduceAlienationQuestions">
                    <div class="card-body">
                        <p>
                            أي حد يقدر يقدم الطلب ده، لكن مش كله بيتقبل أكيد لأن المجلس الأعلى للجامعات بيحدد نسبة 10%
                            بس من الأماكن المقررة لكل كلية هي اللي تكون متاحة لتقليل الاغتراب، فصعب كل الناس تتقبل.
                        </p>
                    </div>
                </div>
            </div>

            {{--هل في استثناءات؟--}}
            <div class="card">
                <div class="card-header" id="heading7">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                            هل في استثناءات؟
                        </button>
                    </h5>

                </div>
                <div id="collapse7" class="collapse" aria-labelledby="heading7"
                    data-parent="#ReduceAlienationQuestions">
                    <div class="card-body">
                        <p>
                            أيوة في استثناءات:
                            <ol class="list-group text-right">
                                <li class="list-group-item">
                                    الكليات دي من الكليات الفريدة وليس لها مناظر، والتحويل منها أو إليها يخضع لنظام
                                    التحويل لكليات غير مناظرة.
                                    <ul class="list-group">
                                        <li class="list-group-item">كلية التخطيط العمرانى بالقاهرة</li>
                                        <li class="list-group-item">كلية اللغات والترجمة جامعة اسوان</li>
                                        <li class="list-group-item">كلية علوم البترول والتعدين فرع مطروح جامعة الاسكندرية</li>
                                        <li class="list-group-item">كلية التكنولوجيا والتنمية شعبة علوم مالية /
                                            شعبة علوم زراعية</li>
                                    </ul>
                                </li>
                                <li class="list-group-item">
                                    الكليات دي مناظرة لباقى كليات الهندسة للجامعات المصرية الأخرى فقط للطلاب المستجدين
                                    والمرشحين للفرقة الاعدادية ويتم القبول بها خارج
                                    التوزيع الجغرافى والاقليمى ويتم التحويل منها أو العكس طبقًا لقواعد التحويل المناظر.
                                    <ul class="list-group">
                                        <li class="list-group-item">كليات الهندسة الالكترونية بمنوف جامعة المنوفية</li>
                                        <li class="list-group-item">هندسة البترول والتعدين بالسويس جامعة السويس</li>
                                        <li class="list-group-item">هندسة الطاقة بأسوان جامعة أسوان</li>
                                    </ul>
                                </li>
                                <li class="list-group-item">
                                    تعتبر كلية الطب بالاسماعيلية جامعة قناة السويس مناظرة لباقى كليات الطب بالجامعات
                                    المصرية ويتم القبول بها وفقًا لقواعد التوزيع الجغرافى ويتم التحويل منها أو إليها مع
                                    باقي كليات الطب بالجامعات.
                                </li>
                            </ol>
                        </p>
                    </div>
                </div>
            </div>

            {{--ملحوظات هامة من موقع التنسيق--}}
            <div class="card">
                <div class="card-header" id="heading8">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                            ملحوظات هامة من موقع التنسيق
                        </button>
                    </h5>

                </div>
                <div id="collapse8" class="collapse" aria-labelledby="heading8"
                    data-parent="#ReduceAlienationQuestions">
                    <div class="card-body">
                        <p>
                            <ul class="list-group text-right">
                                <li class="list-group-item">
                                    يتم التحويل للبرامج الجديدة بكليات الجامعات المصرية عن طريق الجامعات مباشرة وفى حدود
                                    الحد الأدنى للقطاع.
                                </li>
                                <li class="list-group-item">يكون التحويل بسبب النقل الإداري عن طريق الجامعة مباشرة وبشرط
                                    موافقة الجامعة والكلية المعنية بالتحويل إليها.</li>
                                <li class="list-group-item">يكون التحويل بسبب الحالات المرضية عن طريق الجامعات مباشرة
                                    تطبيقًا للمادة (86) من اللائحة التنفيذية لقانون تنظيم الجامعات.</li>
                                <li class="list-group-item">يكون التحويل بعد ذلك عن طريق الجامعات مباشرة بعد نهاية
                                    الفرقة الأولى تطبيقًا للمادة (86) من اللائحة التنفيذية لقانون تنظيم الجامعات.</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>

            {{--أقدم منين على تقليل الاغتراب؟--}}
            <div class="card">
                <div class="card-header" id="heading10">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                            أقدم منين على تقليل الاغتراب؟
                        </button>
                    </h5>

                </div>
                <div id="collapse10" class="collapse" aria-labelledby="heading10"
                    data-parent="#ReduceAlienationQuestions">
                    <div class="card-body">
                        <p>
                            من موقع التنسيق.. <a href="https://tansik.egypt.gov.eg/application/" target="_blank" rel="noopener">دوس هنا
                                عشان تدخل عليه</a>
                        </p>
                    </div>
                </div>
            </div>

            {{--عندي سؤال تاني مش مكتوب هنا--}}
            <div class="card">
                <div class="card-header" id="heading9">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                            عندي سؤال تاني مش مكتوب هنا
                        </button>
                    </h5>

                </div>
                <div id="collapse9" class="collapse" aria-labelledby="heading9"
                    data-parent="#ReduceAlienationQuestions">
                    <div class="card-body">
                        <p>ابعتلنا من هنا <a href="https://m.me/Thanawya.Helwa" target="_blank" rel="noopener"><i
                                    class="fab fa-facebook-messenger"></i></a> وقولنا سؤالك وإحنا هنرد عليك وهنزوده هنا
                            كمان عشان
                            باقي زمايلك.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
