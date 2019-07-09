<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('home') }}">
       <img src="{{ Storage::url('assets/images/logo.svg') }}"
        onerror="this.src='../assets/images/logo.png'; this.onerror=null;" class="img-fluid" alt="فريق ثانوية حلوة">
    </a>


    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">الرئيسية</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'Tansik-Previous-Edges' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('Tansik-Previous-Edges') }}">تنسيق السنوات السابقة</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'Tansik-Geo-Dist' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('Tansik-Geo-Dist') }}">جدول التوزيع الجغرافي</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'Tansik-Geo-Dist-Info' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('Tansik-Geo-Dist-Info') }}">معلومات عن القبول الجغرافي</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'Tansik-ReduceAlienation' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('Tansik-ReduceAlienation') }}">معلومات عن تقليل الاغتراب</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'Tansik-Tzalom' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('Tansik-Tzalom') }}">معلومات عن التظلم</a>
            </li>
        </ul>
    </div>
</nav>