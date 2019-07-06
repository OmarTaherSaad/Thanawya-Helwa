<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ Storage::url('assets/images/logo.svg') }}" 
            class="img-fluid" alt="فريق ثانوية حلوة">
    </a>


    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">الرئيسية</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'about-us' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('about-us') }}">عن الفريق</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'contact' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('contact') }}">تواصل معنا</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'join-us' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('join-us') }}">انضم إلينا</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">دليلك في التنسيق</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('Tansik-Previous-Edges') }}">تنسيق السنوات السابقة</a>
                    <a class="dropdown-item" href="{{ route('Tansik-Geo-Dist') }}">جدول التوزيع الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('Tansik-Geo-Dist-Info') }}">معلومات عن القبول الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('Tansik-ReduceAlienation') }}">معلومات عن تقليل الاغتراب</a>
                    <a class="dropdown-item" href="{{ route('Tansik-Tzalom') }}">معلومات عن التظلم</a>
                </div>
            </li>
        </ul>
    </div>
</nav>