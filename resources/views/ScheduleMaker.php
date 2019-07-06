<?php
session_start();
?>
<!doctype html>
<html lang="ar" dir="rtl"><!-- InstanceBegin template="/Templates/Main Template.dwt.php" codeOutsideHTMLIsLocked="true" -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="Keywords" content="thanawya,ثانوية,ثانوية عامة,ثانوية حلوة">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="assets/images/logo_bg.svg">
	<!--Splash Screen CSS-->
	<style>
#loader-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
}
#loader {
    display: block;
    position: fixed;
    left: 50%;
    top: 50%;
    width: 150px;
    height: 150px;
    margin: -75px 0 0 -75px;
    border-radius: 50%;
    border: 6px solid transparent;
    border-top-color: #b8b4d8;

    -webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
    animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
    z-index: 1001;
}

    #loader:before {
        content: "";
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        border-radius: 50%;
        border: 6px solid transparent;
        border-top-color: #d24536;

        -webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
        animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
    }

    #loader:after {
        content: "";
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        bottom: 15px;
        border-radius: 50%;
        border: 6px solid transparent;
        border-top-color: #fab7bb;

        -webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
          animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
    }

    @-webkit-keyframes spin {
        0%   { 
            -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(0deg);  /* IE 9 */
            transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
        }
        100% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
        }
    }
    @keyframes spin {
        0%   { 
            -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(0deg);  /* IE 9 */
            transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
        }
        100% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
        }
    }

    #loader-wrapper .loader-section {
        position: fixed;
        top: 0;
        width: 51%;
        height: 100%;
        background: #000000;
        z-index: 1000;
    }

    #loader-wrapper .loader-section.section-left {
        left: 0;
    }
    #loader-wrapper .loader-section.section-right {
        right: 0;
    }

    /* Loaded styles */
    .loaded #loader-wrapper .loader-section.section-left {
        -webkit-transform: translateX(-100%);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(-100%);  /* IE 9 */
                transform: translateX(-100%);  /* Firefox 16+, IE 10+, Opera */

        -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);  /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
                transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);  /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */
    }
    .loaded #loader-wrapper .loader-section.section-right {
        -webkit-transform: translateX(100%);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(100%);  /* IE 9 */
                transform: translateX(100%);  /* Firefox 16+, IE 10+, Opera */

        -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);  /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
                transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);  /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */
    }
    .loaded #loader {
        opacity: 0;
        -webkit-transition: all 0.3s ease-out;  /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
                transition: all 0.3s ease-out;  /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */

    }
    .loaded #loader-wrapper {
        visibility: hidden;

        -webkit-transform: translateY(-100%);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateY(-100%);  /* IE 9 */
                transform: translateY(-100%);  /* Firefox 16+, IE 10+, Opera */
    
        -webkit-transition: all 0.3s 1s ease-out;  /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
                transition: all 0.3s 1s ease-out;  /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */
    }
	.no-js #loader-wrapper {
		display: none;
	}
	.no-js h1 {
		color: #222222;
	}
	</style>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/MainStyle.css">
	<link rel="stylesheet" href="css/forms.css">
	<link rel="stylesheet" href="css/offline-theme-dark.css">
	<link rel="stylesheet" href="css/offline-language-arabic.css">
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/popper.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" defer src="js/MainScript.js"></script>
	<script type="text/javascript" defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<script defer src="js/forms.js"></script>
	<script type="text/javascript" src="js/offline.min.js"></script>
	
	
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>اعمل جدولك | ثانوية حلوة</title>
	<!-- InstanceEndEditable -->
	
	<!-- InstanceBeginEditable name="head" -->
	<!-- InstanceEndEditable -->
	<script src='https://www.google.com/recaptcha/api.js?render=6LdyhWEUAAAAABDOBrzpqRBksopIOuf_p2y3H991'></script>
	<!--Google Auto-Ads-->
	<!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-8176502663524074",
          enable_page_level_ads: true
     });
</script>-->
</head>

<body>
<!--Splash Screen Start-->
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<!--Splash Screen End-->
<!--Navbar Start-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
	<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href="index.php">
	<img src="assets/images/logo.svg" onerror="this.src='../assets/images/logo.png'; this.onerror=null;" class="img-fluid" alt="فريق ثانوية حلوة">
	</a>


	<div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="index.php">الرئيسية</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="about_us.php">عن الفريق</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="modal" data-target="#ContactModal" href="#ContactModal">اتصل بنا</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="join_us.php">انضم إلينا</a>
			</li>
			<!--<li class="nav-item">
				<a class="nav-link" href="../ScheduleMaker.php">اعمل جدولك</a>
			</li>-->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">دليلك في التنسيق</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<a class="dropdown-item" href="Tansik/PreviousEdges.php">الكليات بتقبل من كام؟</a>
					<a class="dropdown-item" href="Tansik/GeoDist.php">جدول التوزيع الجغرافي</a>
					<a class="dropdown-item" href="Tansik/GeoDistInfo.php">معلومات عن القبول الجغرافي</a>
					<a class="dropdown-item" href="Tansik/ReduceAlienation.php">معلومات عن تقليل الاغتراب</a>
					<a class="dropdown-item" href="Tansik/Tzalom.php">معلومات عن التظلم</a>
				</div>
			</li>
		</ul>
	</div>
</nav>
<!--Navbar End-->
<div class="container-fluid">
	<?php if (isset($_SESSION['message'])): ?>
	<div class="alert alert-dismissible text-center fade show <?= $_SESSION['message_type']; ?>" style="position: fixed" role="alert">
		<?= $_SESSION['message']; ?>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
	  </button>


	</div>
	<?php unset($_SESSION["message"],$_SESSION["message_type"]); ?>
	<?php endif; ?>
	<!-- InstanceBeginEditable name="Page Content" -->
	<div class="row">
		<div class="col-12">
			<div class="jumbotron">
				<h1 class="display-4">اعمل جدولك</h1>
				<p>
					كل اللي عليك هو إنك تدينا مواعيد دروسك، وإحنا هنديلك كذا جدول مذاكرة جاهزين حسب ما هتختار طريقة تنظيم الوقت
				</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-12">
			<div class="form-group text-right">
				<label>الشعبة</label>
				<select id="section" class="form-control parameters">
					<option value="0" disabled selected></option>
					<option value="1">علمي علوم</option>
					<option value="2">أدبي</option>
					<option value="3">علمي رياضة</option>
				</select>
			</div>
		</div>
		<div class="col-md-4 col-12">
			<div class="form-group">
				<label for="secLang">اللغة الثانية</label>
				<select  id="secLang" class="form-control parameters">
					<option value="0" disabled selected></option>
					<option value="1">فرنساوي</option>
					<option value="2">ألماني</option>
					<option value="3">إيطالي</option>
					<option value="4">أسباني</option>
				</select>
			</div>
		</div>
		
	</div>
	<div class="row text-right">
		<div class="col-12 col-md-3">
			<div class="jumbotron bg-light">
				<h3 class="display-5">دروس يوم السبت</h3>
				<button class="btn" onclick="addFields(this)" type="button">+ إضافة درس</button>
					<div class="subjectChecking" id="_Sat">
					</div>
			</div>
		</div>
		<div class="col-12 col-md-3">
			<div class="jumbotron bg-light">
				<h3 class="display-5">دروس يوم الأحد</h3>
				<button class="btn" onclick="addFields(this)" type="button">+ إضافة درس</button>
					<div class="subjectChecking" id="_Sun">
					</div>
			</div>
		</div>
		<div class="col-12 col-md-3">
			<div class="jumbotron bg-light">
				<h3 class="display-5">دروس يوم الاثنين</h3>
				<button class="btn" onclick="addFields(this)" type="button">+ إضافة درس</button>
					<div class="subjectChecking" id="_Mon">
					</div>
			</div>
		</div>
		<div class="col-12 col-md-3">
			<div class="jumbotron bg-light">
				<h3 class="display-5">دروس يوم الثلاثاء</h3>
				<button class="btn" onclick="addFields(this)" type="button">+ إضافة درس</button>
					<div class="subjectChecking" id="_Tue">
					
					</div>
			</div>
		</div>
	</div>
	<div class="row text-right">
		<div class="col-12 col-md-4">
			<div class="jumbotron bg-light">
				<h3 class="display-5">دروس يوم الأربعاء</h3>
				<button class="btn" onclick="addFields(this)" type="button">+ إضافة درس</button>
					<div class="subjectChecking" id="_Wed">
					</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="jumbotron bg-light">
				<h3 class="display-5">دروس يوم الخميس</h3>
				<button class="btn" onclick="addFields(this)" type="button">+ إضافة درس</button>
					<div class="subjectChecking" id="_Thu">
					</div>
			</div>
		</div>
		<div class="col-12 col-md-4">
			<div class="jumbotron bg-light">
				<h3 class="display-5">دروس يوم الجمعة</h3>
				<button class="btn" onclick="addFields(this)" type="button">+ إضافة درس</button>
					<div class="subjectChecking" id="_Fri">
					</div>
			</div>
		</div>
	</div>
		<div class="row">
		<div class="col-12 table-responsive">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>اليوم</th>
						<th>الحصص</th>
						<th>مذاكرة وحل نصف الواجب</th>
						<th>مذاكرة وحل باقي الواجب</th>
						<th>مراجعة سريعة</th>
					</tr>
				</thead>
				<tbody>
					<tr id="Sat">
						<td>السبت</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					
					<tr id="Sun">
						<td>الأحد</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					
					<tr id="Mon">
						<td>الاثنين</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					
					<tr id="Tue">
						<td>الثلاثاء</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					
					<tr id="Wed">
						<td>الأربعاء</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					
					<tr id="Thu">
						<td>الخميس</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					
					<tr id="Fri">
						<td>الجمعة</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
	<div class="col-12">
		<div class="jumbotron jumbotron-fluid">
		<div class="container">
  <h3 class="display-4">انضم لجروب الفيسبوك!</h3>
  <p class="lead">انضم لجروب "عمر طاهر سعد" على الفيسبوك عشان تشوف أي أدوات جديدة تتعمل لمساعدتك وكمان تعرف طريقة "أغاني الأدب" اللي بتسهل عليك مذاكرة الأدب</p>
  <hr class="my-4">
  <p>كمان لو عايز تطلب أداة معينة أو أي مساعدة تقدر تعمل ده على الجروب</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="https://www.facebook.com/groups/OTScommunity/" target="_blank" role="button">انضم من هنا</a>
  </p>
</div>
</div>
</div>
	</div>

	<!-- InstanceEndEditable -->
</div>
<!--Footer Start-->
<footer class="footer text-light">
	<div class="row justify-content-center p-1 align-items-center" id="footerCopyrights">
		<div class="col">
			<span>جميع الحقوق محفوظة - فريق ثانوية حلوة&copy; 2018</span>
		</div>

		<div class="col-auto">
			<a href="https://www.facebook.com/Thanawya.Helwa/" target="_blank"><i class="fab fa-facebook-square"></i></a>
			<a href="https://m.me/Thanawya.Helwa" target="_blank"><i class="fab fa-facebook-messenger"></i></a>
			<a href="https://www.youtube.com/channel/UCOKWTpg71q-tbZHwU40PUNw" target="_blank"><i class="fab fa-youtube"></i></a>
			<a href="https://www.instagram.com/thanawyahelwa/" target="_blank"><i class="fab fa-instagram"></i></a>
		</div>
	</div>
</footer>
<!--Footer End-->

<!-- Contact Us Modal Start-->
<div class="modal fade" id="ContactModal" tabindex="-1" role="dialog" aria-labelledby="ContactModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ContactModalLabel">تواصل معانا</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>


			</div>
			<div class="modal-body">
				<div class="container-fluid">
				<div class="row text-right">
					<div class="col">
						<h4>تقدر تتواصل معانا عن طريق الفيسبوك من هنا :&nbsp;&nbsp;<span><a href="https://m.me/Thanawya.Helwa" target="_blank"><i class="fab fa-facebook-messenger"></i></a></span></h4>
					</div>
				</div>
				<div class="row text-right mt-2">
					<div class="col">
						<h4>أو ابعتلنا بالايميل من خلال الاستمارة دي</h4>
					</div>
				</div>
					<div class="row">
						<div class="col text-right">
							<form id="ContactForm" method="post" action="functions/contact_us.php">
								<div class="form-group">
									<label for="Name">الاسم</label>
									<input required class="form-control" type="text" name="Name" id="Name">
								</div>
								<div class="form-group">
									<label for="Email">البريد الالكتروني</label>
									<input required class="form-control" type="email" name="Email" id="Email">
								</div>

								<div class="form-group">
									<label for="Subject">الرسالة بخصوص..</label>
									<input required class="form-control" type="text" name="Subject" id="Subject">
								</div>

								<div class="form-group">
									<label for="Message">الرسالة</label>
									<textarea required class="form-control" name="Message" id="Message"></textarea>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button> &nbsp;&nbsp;
				<input type="submit" form="ContactForm" name="ContactSubmit" id="ContactSubmitBtn" value="إرسال" class="btn btn-primary">
			</div>
		</div>
	</div>
</div>
<!-- Contact US Modal End--->
	<!-- InstanceBeginEditable name="Additional Scripts" -->
<?php
		echo "<script>";
		echo file_get_contents('js/scheduleMaker.js');
		echo "</script>";
?>
	<!-- InstanceEndEditable -->
	<script>
	$(window).bind('load',function() {
		setTimeout(function(){
			$('body').addClass('loaded');
			$('h1').css('color','#222222');
			setTimeout(function(){
				$("#loader-wrapper").remove();
			}, 5000);
		}, 3000);

	});
		
	// when form is submit
    $('form').submit(function(event) { 
        // we stoped it
        event.preventDefault();
        // needs for recaptacha ready
        grecaptcha.ready(function() {
            // do request for recaptcha token
            // response is promise with passed token
            grecaptcha.execute('6LdyhWEUAAAAABDOBrzpqRBksopIOuf_p2y3H991', {action: 'contact_form'}).then(function(token) {
				console.log(token);
                // add token to form
                $('form').prepend('<input type="hidden" name="token" value="' + token + '">');
                $('form').prepend('<input type="hidden" name="action" value="contact_form">');
                // submit form now
                $('form').unbind('submit').submit();
            });
        });
    });
	</script>

</body>

<!-- InstanceEnd --></html>