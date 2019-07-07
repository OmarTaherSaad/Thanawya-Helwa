@extends('layouts.app')
@section('title','معلومات عن التظلم')
@section('content')
<div class="row text-center">
    <div class="col m-2 p-2">
        <div class="jumbotron jumbotron-fluid">
            <h1 class="display-4">التظلم</h1>
            <p class="lead">هنا هنعرفك كل حاجة عن التظلم وخطواته والأسئلة الشائعة عنه.</p>
        </div>
    </div>
</div>
<div class="row text-center justify-content-center">
    <div class="col-12 col-md-11">
        <div class="accordion" id="TzalomQuestions">
            <div class="card">
                <div class="card-header" id="heading1">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                            هل التظلم بيعيد تجميع الدرجات بس؟
                        </button>
                    </h5>

                </div>

                <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#TzalomQuestions">
                    <div class="card-body">
                        <p>
                            لأ، ده مفهوم خاطئ لكن الحقيقة هي إن التظلم بيعمل 3 حاجات:
                            <br>
                            <ul class="list-group text-right">
                                <li class="list-group-item">1- لو في جزء مش متصحح هيتصحح.</li>
                                <li class="list-group-item">2- لو في خطأ في تجميع الدرجات هيصلحوه.</li>
                                <li class="list-group-item">3- لو سؤال اختيار من متعدد (choose) إنت مجاوبه صح واتحسبلك
                                    غلط هيتصلح.</li>
                                {{-- <li class="list-group-item"></li> --}}
                            </ul>
                            <br>
                            الأسئلة المقالية فقط هي اللي مش بيُعاد تصحيحها.
                        </p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading2">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            إيه الورق المطلوب للتظلم؟
                        </button>
                    </h5>

                </div>
                <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#TzalomQuestions">
                    <div class="card-body">
                        <p>مطلوب منك بس صورة البطاقة وإيصال الدفع بتاع البنك الأهلي المصري، وطلب التظلم اللي هتاخده من
                            المديرية.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading3">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            إيه خطوات التظلم؟
                        </button>
                    </h5>

                </div>
                <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#TzalomQuestions">
                    <div class="card-body">
                        <p>
                            <ul class="list-group text-right">
                                <li class="list-group-item">أولًا: بتروح مديرية التعليم اللي إنت تابع ليها، وتقول إنك
                                    عايز تعمل تظلم.</li>
                                <li class="list-group-item">ثانيًا: هيقولولك تروح أقرب فرع للبنك الأهلي المصري وهتدفع
                                    100 جنية عن كل مادة عايز تعملها تظلم (منعرفش غليت ولا لأ لكن كان بـ100 جنية السنة
                                    اللي فاتت) .. المهم هتدفع لحساب صندوق دعم وتمويل المشروعات التعليمية وهتاخد نسخة من
                                    إيصال السداد.</li>
                                <li class="list-group-item">ثالثًا: هترجع المديرية وتسلم الإيصال ده عشان يحددولك ميعاد
                                    للكشف عن ورقتك، ولما تيجي رايح المعاد ده متاخدش مدرس المادة لأن ممنوع.</li>
                                <li class="list-group-item">رابعًا: لما تروح ميعادك هيدولك صورة من ورقة إجابتك لكن من
                                    غير اسمك وبيبقى عليها كود سري (عشان لما مستشار المادة يراجعها ميعرفش إنت مين) وهتبدأ
                                    تكتب ملاحظاتك في ورقة خارجية .. يعني تكتب السؤال رقم كذا فيه مشكلة كذا وكل حاجة شايف
                                    إنك مظلوم فيها .. وياريت تاخد معاك نموذج إجابة لأن مش هيدولك نموذج إجابة هناك ف اعمل
                                    حسابك من قبلها.</li>
                                <li class="list-group-item">خامسًا: هتسلم الورقة الخارجية وصورة ورقة إجابتك عشان
                                    الكنترول يراجعها تاني .. ولو طلع فعلًا ليك درجات هتاخد الدرجات + الفلوس اللي دفعتها
                                    في التظلم، يعني لو عملت تظلم لمادتين ومادة منهم رجعلك فيها درجات هتاخد ال100 جنية
                                    بتاعت المادة دي.</li>
                                <li class="list-group-item">سادسًا: بيبلغوا مكتب التنسيق بالنتيجة الجديدة بتاعتك عشان
                                    تعرف تقدم أو تحول للكلية اللي عايزها بمجموعك الجديد.</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading4">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                            هل التظلم بيرجع درجات ولا مجرد سبوبة عشان ياخدوا فلوس؟
                        </button>
                    </h5>

                </div>
                <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#TzalomQuestions">
                    <div class="card-body">
                        <p>بيرجع درجات، في ناس كتير جدًا رجعلها درجات بالتظلم، لكن مش معناه إنه مضمون 100% بردو، لأن
                            ساعات بتبقى فاكر إنك ليك درجات ويطلع ملكش حاجة (بيحصل بجد)، بس لو واثق إنك ليك درجات يبقى
                            توكل على الله واعمل التظلم.</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading5">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                            لو عملت تظلم وشوفت ورقتي إن ليا درجات بس مرجعوليش حاجة أعمل إيه؟
                        </button>
                    </h5>

                </div>
                <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#TzalomQuestions">
                    <div class="card-body">
                        <p>
                            في الحالة دي لو نَفَسك طويل شوية ارفع عليهم قضية، ولو كسبتها بترجعلك درجاتك (ولو محامي شاطر
                            ممكن يجيبلك تعويض بس مش حاجة مضمونة يعني) .. مع العلم إن ممكن الكلام ده على ما يخلص تكون
                            الدراسة بدأت ف ساعتها لو خدت درجات كتير تدخلك كلية تانية هتحولها السنة اللي بعدها بقى
                            (والحالة دي مشوفنهاش حصلت كتير يعني لأن في الغالب محدش بيبقى نفسه طويل).
                        </p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="heading6">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                            عندي سؤال تاني مش مكتوب هنا
                        </button>
                    </h5>

                </div>
                <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#TzalomQuestions">
                    <div class="card-body">
                        <p>ابعتلنا من هنا <a href="https://m.me/Thanawya.Helwa" target="_blank" rel="noopener"><i
                                    class="fab fa-facebook-messenger"></i></a> وقولنا سؤالك وإحنا هنرد عليك وهنزوده هنا
                            كمان عشان باقي زمايلك.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection