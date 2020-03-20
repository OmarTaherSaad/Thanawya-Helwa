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
                <a class="nav-link" href="{{ route('tansik.previous_edges') }}">تنسيق السنوات السابقة</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'Tansik-Geo-Dist' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tansik.geo_dist') }}">جدول التوزيع الجغرافي</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'Tansik-Geo-Dist-Info' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tansik.geo_dist_info') }}">القبول الجغرافي</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'Tansik-ReduceAlienation' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tansik.reduce_alienation') }}">تقليل الاغتراب</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'Tansik-Tzalom' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tansik.tzalom') }}">التظلم</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'Tansik-Stages-Info' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tansik.stages_info') }}">مراحل التنسيق</a>
            </li>
        </ul>
    </div>
</nav>
