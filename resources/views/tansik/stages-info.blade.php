@extends('layouts.app')
@section('title','معلومات عن مراحل التنسيق')
@section('content')
<div class="row text-center">
	<div class="col m-2 p-2">
		<div class="jumbotron jumbotron-fluid">
			<h1 class="display-4">مراحل التنسيق</h1>
			<p class="lead">هنا هنعرفك كل حاجة عن مراحل التنسيق الأولى والتانية والتالتة.</p>
		</div>
	</div>
</div>
<div class="row text-center justify-content-center">
	<div class="col-12 col-md-11">
		<div class="accordion" id="GeoDistQuestions">
			{{--يعني إيه مرحلة أولى وتانية وتالتة أصلًا؟!--}}
			<div class="card">
				<div class="card-header" id="heading1">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
					  يعني إيه مرحلة أولى وتانية وتالتة أصلًا؟!
					</button>
				  </h5>
				
				</div>

				<div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							مراحل التنسيق هي تقسيم للدفعة عشان ميبقاش كله بيعمل التنسيق مرة واحدة، ف مكتب التنسيق بيحدد عدد معين من الطلبة
							ويخليهم يعملوا تنسيقهم (المرحلة الأولى)، بعدين ياخد مجموعة تانية يعملوا تنسيقهم (المرحلة الثانية)، بعدها بيكون لسه فاضل ناس، وبيكون في ناس كانت شايلة مواد وامتحنتها في الدور التاني ونجحوا، ف بيجمعوا كل دول سوا ويخلوهم يعملوا تنسيقهم (المرحلة الثالثة).
						</p>
					</div>
				</div>
			</div>
			{{--على أي أساس بيحددوا مين يكون في أنهي مرحلة؟--}}
			<div class="card">
				<div class="card-header" id="heading5">
					<h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse5"
							aria-expanded="false" aria-controls="collapse5">
							على أي أساس بيحددوا مين يكون في أنهي مرحلة؟
						</button>
					</h5>
			
				</div>
				<div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							على أساس الأعداد؛ بيكونوا عايزين مثلًا 100 ألف طالب في أول مرحلة ف بيرتبوا الطلبة بالمجاميع وياخدوا أعلى 100 ألف واحد، وده بيحصل لكل شعبة لوحدها مش على بعض كلهم (طبعًا رقم 100 ألف ده افتراضي من عندنا بنشرح بيه بس).
						</p>
					</div>
				</div>
			</div>
			{{--ازاي بيحطوا الحد الأدنى لكل مرحلة في كل شعبة؟--}}
			<div class="card">
				<div class="card-header" id="heading2">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
					  ازاي بيحطوا الحد الأدنى لكل مرحلة في كل شعبة؟
					</button>
				  </h5>
				
				</div>
				<div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							بعد ما بيحددوا العدد اللي في المرحلة لكل شعبة، بيشوفوا أقل طالب في العدد ده جايب كام ويكون ده الحد الأدنى للمرحلة.
							<br>
							مثال: حددوا إن شعبة علمي رياضة ناخد منها 50 ألف طالب، ولقوا إن الطالب رقم 50 ألف (أقل مجموع في المرحلة) جايب 94%، ساعتها يتم الإعلان إن المرحلة الأولى هتاخد من 94% لشعبة علمي رياضة، وهكذا لباقي الشُعب ولباقي المراحل.
						</p>
					</div>
				</div>
			</div>
			{{--هل كل مرحلة بتفرق عن التانية من حيث الكليات المتاحة؟--}}
			<div class="card">
				<div class="card-header" id="heading3">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
					  هل كل مرحلة بتفرق عن التانية من حيث الكليات المتاحة؟
					</button>
				  </h5>
				
				</div>
				<div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							النظام هو هو في كل المراحل، الفرق إن في كليات بتتملي. يعني طلبة المرحلة الأولى بيكون متاح ليهم كل الكليات، بيختاروا منها وبعد ما التنسيق بتاعهم يخلص وكل واحد يدخل كليته، في كليات بتتملي بيهم؛ مثلًا تلاقي كلية كانت عايزة 5 آلاف طالب وفي 5 آلاف اختاروها خلاص ودخلوها، لو ظهرت في المرحلة التانية مش هيكون ليها لازمة لأنها كده كده مفيهاش مكان خلاص، ف بتتشال من المرحلة التانية ومبتظهرش من الأساس، لكن لو لسه فيها ولو مكان واحد ف بتنزل المرحلة اللي بعدها عادي لحد ما حد يختارها ويملى المكان الفاضي ده.
						</p>
					</div>
				</div>
			</div>
			{{--امتى بنقدر نعرف إن كلية معينة خدت من مجموع كذا؟--}}
			<div class="card">
				<div class="card-header" id="heading8">
					<h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse8"
							aria-expanded="false" aria-controls="collapse8">
							امتى بنقدر نعرف إن كلية معينة خدت من مجموع كذا؟
						</button>
					</h5>
			
				</div>
				<div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							دي مبتتعرفش إلا بعد ما الكلية بتتملي؛ يعني أي خبر على موقع تلاقيه بيقولك تنبؤات بمجموع كلية كذا ولسه مرحلة التنسيق مخلصتش ف ده كلام فاضي ومجرد توقعات، إنما إحنا بنعرف الكلية خدت من كام بعد ما الكلية تملى كل أماكنها ف نشوف أقل طالب دخلها كان جايب كام، ومجموعه ده هو بيبقى الحد الأدنى بتاع الكلية.
							 <br>
							 يعني مفيش حد يقدر يعرف الحد الأدنى بتاع أي كلية قبل ما التنسيق بتاع الكلية دي يخلص وتتملي على آخرها.
						</p>
					</div>
				</div>
			</div>
			{{--التنسيق بيحتاج كمبيوتر ونت، لو معنديش ده أعمل إيه؟--}}
			<div class="card">
				<div class="card-header" id="heading4">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
					  التنسيق بيحتاج كمبيوتر ونت، لو معنديش ده أعمل إيه؟
					</button>
				  </h5>
				
				</div>
				<div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							مكتب التنسيق عامل خدمة مجانية إنك تروح لحاجة اسمها "معامل الحاسبات" موجودة في الجامعات، بتكون مفتوحالك خلال مدة كل مرحلة تنسيق (اللي هي تقريبًا 5 أيام لكل مرحلة)، تقدر تروح هناك وتعمل تنسيقك. وكمان بعض المدارس اللي فيها نت ومعمل كمبيوتر بتقدر تعمل التنسيق من هناك
							<br>
							أماكن مكاتب التنسيق الالكتروني بالجامعات تقدر تشوفها من موقع التنسيق من <a href="https://tansik.egypt.gov.eg/application/Certificates/Thanwy/Dalel/3.htm" target="_blank">هنا</a>
						</p>
					</div>
				</div>
			</div>
			{{--طب أنا مُعفى من اللغة الثانية، مجموعي هيتحسب ازاي؟--}}
			<div class="card">
				<div class="card-header" id="heading6">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
						طب أنا مُعفى من اللغة الثانية، مجموعي هيتحسب ازاي؟
					</button>
				  </h5>
				
				</div>
				<div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p dir="ltr">
							بتحسب حاجة اسمها مجموع اعتباري وده اللي بتتعامل بيه، وده بتحسبه كده
							<br>
							المجموع الكلي x <sup>410</sup>&frasl;<sub>370</sub>
						</p>
					</div>
				</div>
			</div>
			{{--لو أنا بلعب رياضة معينة وليا درجات حافز رياضي، مجموعي هيتحسب ازاي؟--}}
			<div class="card">
				<div class="card-header" id="heading7">
					<h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
						لو أنا بلعب رياضة معينة وليا درجات حافز رياضي، مجموعي هيتحسب ازاي؟
					</button>
				  </h5>
				
				</div>
				<div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#GeoDistQuestions">
					<div class="card-body">
						<p>
							هتزودها على مجموعك (المجموع الأصلي + درجة الحافز الرياضي) وتتعامل بالمجموع الجديد ده في كل حاجة بعد كده.
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