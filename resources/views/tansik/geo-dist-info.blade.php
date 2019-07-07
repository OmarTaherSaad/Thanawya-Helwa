@extends('layouts.app')
@section('title','معلومات عن التوزيع الجغرافي')
@section('content')
    <div class="row text-center">
		<div class="col m-2 p-2">
			<div class="jumbotron jumbotron-fluid">
  <h1>يعني إيه قبول جغرافي؟</h1>
  <p class="lead">هنا هنقولك كل حاجة محتاج تعرفها عن القبول الجغرافي وهتلاقي إجابة كل الأسئلة الشائعة بخصوص الموضوع ده.</p>
  <hr class="my-4">
  <p>لو عايز تعرف الجامعات المتاحة لمحافظتك دوس هنا</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="{{ route('Tansik-Geo-Dist') }}" role="button">دوس هنا</a>
  </p>
</div>
		</div>
	</div>
<div class="row text-center justify-content-center">
	<div class="col-12 col-md-11">
		<div class="accordion" id="GeoDistQuestions">
			{{--يعني إيه قبول جغرافي؟--}}
			<div class="card">
				<div class="card-header" id="heading1">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
					  يعني إيه قبول جغرافي؟
					</button>
				  </h5>
				
				</div>

				<div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							يعني عشان تدخل كلية في جامعة معينة, مش بس لازم تكون جايب مجموعها, لأ وكمان لازم تكون الجامعة دي متاحة لمحافظتك عشان تقدر تختارها وتدخلها, والجامعات بتتقسم لـ3 مجموعات, "أ" - "ب" - "ج" , لازم تختار كل جامعات مجموع "أ" الأول قبل ما تختار أي جامعة تانية من "ب" و "ج", ولازم تختار كل جامعات "ب" بعدها قبل ما تختار حاجة من جامعات "ج", وفي الآخر خالص تختار من "ج" براحتك.
						</p>
					</div>
				</div>
			</div>
			{{--إيه المجموعات "أ" و "ب" و "ج" دول؟--}}
			<div class="card">
				<div class="card-header" id="heading5">
					<h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse5"
							aria-expanded="false" aria-controls="collapse5">
							إيه المجموعات "أ" و "ب" و "ج" دول؟
						</button>
					</h5>
			
				</div>
				<div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							<strong>مجموعة "أ" وهي الإجبارية ليك تختار منها أول حاجة:</strong>
							<br>
							هي الجامعة أو الجامعات الأقرب لإدارتك التعليمية، وفى بعض الحالات بتكون أكتر من جامعة لأن إدارتك
							التعليمية بتقع في حيز متساوي المسافة من الجامعتين.
							<br><hr>
							<strong>مجموعة "ب" وهي الإجبارية بعد ما تخلص كل الجامعات الموجودة في مجموعة "أ" الأول:</strong>
							<br>
							مجموعة جامعات بتقع قرب حيز الإدارة التعليمية ليك ومفيش فرق في اختيار أي حاجة منها قبل غيرها.
							<br><hr>
							<strong>مجموعة "ج" وهي آخر اختيار ليك بعد "أ" و "ب" :</strong>
							<br>
							باقي الجامعات التي فيها الكلية اللي بتختارها، بيُسمح ليك تختار أي حاجة منها وتعتبر متساوية، لأن كلهم
							بعاد عن محل سكنك وإدارتك التعليمية.
						</p>
					</div>
				</div>
			</div>
			{{--أعرف منين الجامعات المتاحة لمحافظتي؟--}}
			<div class="card">
				<div class="card-header" id="heading2">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
					  أعرف منين الجامعات المتاحة لمحافظتي؟
					</button>
				  </h5>
				
				</div>
				<div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p><a href="{{ route('Tansik-Geo-Dist') }}" target="_blank" rel="noopener">دوس هنا</a> واختار محافظتك والإدارة التعليمية اللي تابع ليها وإحنا هنقولك كل المجموعات بالنسبالك.</p>
					</div>
				</div>
			</div>
			{{--لو اتلغبطت وحطيت جامعة من مجموعة "ب" أو "ج" قبل جامعات مجموعة "أ" وأنا برتب الرغبات؟--}}
			<div class="card">
				<div class="card-header" id="heading3">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
					  لو اتلغبطت وحطيت جامعة من مجموعة "ب" أو "ج" قبل جامعات مجموعة "أ" وأنا برتب الرغبات؟
					</button>
				  </h5>
				
				</div>
				<div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>مش هتتلغبط لأن أصلًا نظام التنسيق اللي بتملى عليه رغباتك متبرمج إنه ميقبلش رغبات في جامعة معينة غير لو كانت متاحة ليك كتوزيع جغرافي, يعني لو إنت من القاهرة وجربت تحط هندسة اسكندرية أول رغبة مش هتعرف كده كده, لازم تملى مجموعة "أ" الأول بعدين "ب" بعدين "ج".</p>
					</div>
				</div>
			</div>
			{{--بس أنا عايز أدخل كلية مش موجودة في الجامعات اللي في مجموعة "أ" بتاعتي!؟--}}
			<div class="card">
				<div class="card-header" id="heading4">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
					  بس أنا عايز أدخل كلية مش موجودة في الجامعات اللي في مجموعة "أ" بتاعتي!؟
					</button>
				  </h5>
				
				</div>
				<div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>متقلقش, دي الحالة الوحيدة اللي بيكون مسموحلك تختار جامعة في مجموعة غير "أ" كأول رغبة, لو الكلية اللي عايز تدخلها مش موجودة غير في جامعات معينة, والجامعات دي مش مجموعة "أ" بالنسبالك ف هتقدر تختارها بردو وتدخلها عادي جدًا.
							<br>
							مثال: لو إنت ساكن في الاسكندرية وعايز تدخل كلية اعلام، هيكون مفتوحلك تختار اعلام القاهرة عادي لأنك معندكش اعلام في جامعة الاسكندرية.
						</p>
					</div>
				</div>
			</div>
			{{--وإيه وضع المدارس الداخلية من الموضوع (الرياضية - العسكرية - المتفوقين)--}}
			<div class="card">
				<div class="card-header" id="heading6">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
						وإيه وضع المدارس الداخلية من الموضوع ( مثال: الرياضية - العسكرية - المتفوقين)؟
					</button>
				  </h5>
				
				</div>
				<div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							بياخدوا بمقر سكن الطالب اللي متسجل في بيانات تقدمه في استمارة الثانوية العامة
						</p>
					</div>
				</div>
			</div>
			{{--عايز مثال يوضحلي الكلام اللي بتقولوه ده--}}
			<div class="card">
				<div class="card-header" id="heading7">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
						عايز مثال يوضحلي الكلام اللي بتقولوه ده
					</button>
				  </h5>
				
				</div>
				<div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							جايبينلك مثال من موقع التنسيق نفسه .. لو عندنا طالب  في علمي رياضة تابع للإدارة التعليمية بالسيدة زينب بمحافظة القاهرة وعايز يختار كلية الهندسة فهيكون الاختيار كما يلي:
							<br>
							<ul class="list-group text-right">
								<li class="list-group-item">
									أولا: يختار كليات النطاق الجغرافي (أ):
									<ul class="list-group">
										<li class="list-group-item">كلية الهندسة جامعة القاهرة</li>
										<li class="list-group-item">كلية الهندسة جامعة عين شمس</li>
										<li class="list-group-item">كلية الهندسة جامعة بحلوان جامعة حلوان</li>
										<li class="list-group-item">كلية الهندسة جامعة بالمطرية جامعة حلوان</li>
										<li class="list-group-item">كلية الهندسة جامعة بشبرا جامعة بنها</li>
									</ul>
									بيختار منهم بأي ترتيب يحبه عادي حسب رغبته.
									<br>
									ميقدرش يختار كليات النطاق الجغرافي (ب)، قبل ما يخلص كل كليات الهندسة في النطاق الجغرافي (أ) قبلها.
								</li>
								<li class="list-group-item">
									ثانيا: كليات النطاق الجغرافي (ب): كلية الهندسة جامعة الفيوم، وفي حالتنا هنا (كليات هندسة يعني) فهى كلية وحيدة في النطاق ده للطالب ده. لو في أكتر من كلية في النطاق الجغرافي (ب) فمش هيقدر يختار من مجموعة (ج) قبل ما يستكمل اختيار جميع كليات النطاق الجغرافي (ب).
								</li>
								<li class="list-group-item">
									ثالثا: المجموعة (ج) ودي بنسميها "الاختيار الحر" : باقي كليات الهندسة في باقي الجامعات، وبيرتبهم زي ما هو عايز.
								</li>
							</ul>
						</p>
					</div>
				</div>
			</div>
			{{--إيه الحاجات اللي خارجة عن القواعد دي؟--}}
			<div class="card">
				<div class="card-header" id="heading8">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse?">
						إيه الحاجات اللي خارجة عن القواعد دي؟
					</button>
				  </h5>
				
				</div>
				<div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
						<ul class="list-group text-right">
							<li class="list-group-item">المعاهد العليا التابعة للجامعات (مثال: المعهد العالي للحاســب الآلي جامعة ببور سعيد)</li>
							<li class="list-group-item">المعاهد الفنية للخدمة الاجتماعية والمعاهد الفنية للآثار والمعاهد الفنية للسياحة والفنادق والمعاهد الفنية الصناعية غير المتناظرة (المتخصصة)</li>
							<li class="list-group-item">الجامعة العمالية والمعهد الفني للصناعات المتطورة بمدينة السلام – النهضة- القاهرة</li>
							<li class="list-group-item">المعاهد الخاصة العليا والمتوسطة</li>
							<li class="list-group-item"> المجمع التكنولوجى المتكامل بالاميرية و المجمع التكنولوجى المتكامل بالسلام (بشرط اجتياز الاختبار الشخصي)</li>
							<li class="list-group-item">مركز التكنولوجيا المتميز بالاميرية "تخصص التشغيل الاتوماتيكى ( ماكينات كهربية ) – تخصص تشغيل لصناعة الاحذية ( ميكانيكا انتاج)"</li>
						</ul>
						</p>
					</div>
				</div>
			</div>
			{{--ملحوظات هامة من موقع التنسيق--}}
			<div class="card">
				<div class="card-header" id="heading9">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
						ملحوظات هامة من موقع التنسيق
					</button>
				  </h5>
				
				</div>
				<div id="collapse9" class="collapse" aria-labelledby="heading9" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							<ul class="list-group text-right">
								<li class="list-group-item">
									طلاب مناطق (الخانكة - شبرا الخيمة – شبين القناطر- القناطر الخيرية- قليوب – ابوزعبل - الخصوص- العبور) التابعة لمحافظة القليوبية يكون قبولهم أولا بجميع كليات جامعة عين شمس أو جامعة بنها، ماعدا كلية الهندسة فيقتصر قبولهم أولاً علي كلية الهندسة بشبرا جامعة بنها عدا طلاب منطقة العبور لهم الحق في إبداء رغبتهم بكلية الهندسة جامعة عين شمس كأختيار أول.
								</li>
								<li class="list-group-item">
								التوزيع الوارد بالجداول -اللي هتلاقوها على موقع ثانوية حلوة هنا- توزيع جغرافى لا ينطبق علي كليات التربية وشعبها المختلفة والتربية النوعية وشعبها المختلفة وكلية البنات ( تربية – تربية رياضة - تعليم ابتدائى – طفولة ) جامعة عين شمس والمعاهد الفنية للتمريض والمعاهد الفنية الصحية والكليات الاخرى التى تقبل طبقا للتوزيع الاقليمى حيث إن القبول بهذه الكليات والمعاهد يخضع لقاعدة التوزيع الإقليمي، <a href="https://tansik.egypt.gov.eg/application/Certificates/Thanwy/Dalel/4-3.htm" target="_blank" rel="noopener">(افتح جداول القبول الإقليمي من هنا)</a>.
								</li>
								<li class="list-group-item">
								القبول بالمعاهد الفنية التابعة للكليات التكنولوجية لها توزيع جغرافي خاص بها ولا يخضع للتوزيع الوارد بهذه الجداول.
								</li>
								<li class="list-group-item">
								القبول بالمعاهد الخاصة متاح أمام جميع الطلاب، ولا يطبق عليها نظام التوزيع الجغرافي والإقليمي.
								</li>
								<li class="list-group-item">
								طلاب المدارس ذات الطبيعة الخاصة (المتفوقين – المكفوفين – الحربية – الثانوية العسكرية – الداخلية – البالية – الثانوية الرياضية) يتم ترشيحهم طبقا للقواعد التي تنطبق على عنوان السكن المدون باستمارة البيانات الأولية المقدمة للحاسب وبذلك إذا كان سكن أسرة الطالب المثبت باستمارة البيانات الأولية المقدمة للحاسب في أحد محافظات القاهرة الكبرى يرشح الطالب طبقا لقواعد التوزيع الجغرافي للقاهرة الكبرى وإذا كان عنوان سكن أسرة الطالب المثبت باستمارة البيانات الأولية المقدمة للحاسب في محافظة أسيوط مثلا يتم توزيعه طبقا لقواعد التوزيع الجغرافي لطلاب محافظة أسيوط.
								</li>
								<li class="list-group-item">
								 القبول بكليات التمريض يتم على اساس قواعد القبول الجغرافى وليس الاقليمى اعتبارا من العام الجامعى 2014/2015 .
								</li>
							</ul>
						</p>
					</div>
				</div>
			</div>
			{{--هقدم منين للتنسيق؟--}}
			<div class="card">
				<div class="card-header" id="heading11">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
						هقدم منين للتنسيق؟
					</button>
				  </h5>
				
				</div>
				<div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							من موقع التنسيق .. <a href="https://tansik.egypt.gov.eg/application/" target="_blank" rel="noopener">دوس هنا عشان تدخل عليه</a>.
						</p>
					</div>
				</div>
			</div>
			{{--عندي سؤال تاني مش مكتوب هنا--}}
			<div class="card">
				<div class="card-header" id="heading10">
					<h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse10"
							aria-expanded="false" aria-controls="collapse10">
							عندي سؤال تاني مش مكتوب هنا
						</button>
					</h5>
			
				</div>
				<div id="collapse10" class="collapse" aria-labelledby="heading10" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>ابعتلنا من هنا <a href="https://m.me/Thanawya.Helwa" target="_blank" rel="noopener"><i
									class="fab fa-facebook-messenger"></i></a> وقولنا سؤالك وإحنا هنرد عليك وهنزوده هنا كمان عشان
							باقي زمايلك.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection