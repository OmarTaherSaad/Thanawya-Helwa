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
            <li class="nav-item {{ Route::currentRouteName() == 'tas.home' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tas.home') }}">رئيسية القمة</a>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'tas.schedule' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tas.schedule') }}">جدول اليوم</a>
            </li>
            <li class="nav-item dropdown {{ Str::contains(Route::currentRouteName(),'ticket') ? 'active' : '' }}">
                <a class="nav-link dropdown-toggle" id="TicketsLink" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">التذاكر</a>
                <div class="dropdown-menu" aria-labelledby="TicketsLink">
                    <a class="dropdown-item {{ Route::currentRouteName() == 'tas.tickets.register' ? 'active' : '' }}"
                        href="{{ route('tas.tickets.register') }}">تسجيل تذكرة</a>
                    @auth
                    <a class="dropdown-item {{ Route::currentRouteName() == 'tas.tickets.view' ? 'active' : '' }}"
                        href="{{ route('tas.tickets.view') }}">تذاكري</a>
                    @endauth
                    <a class="dropdown-item {{ Route::currentRouteName() == 'tas.buy-ticket-online' ? 'active' : '' }}"
                        href="{{ route('tas.buy-ticket-online') }}">شراء تذكرة أونلاين</a>
                </div>
            </li>
            <li class="nav-item {{ Route::currentRouteName() == 'tas.countdown' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tas.countdown') }}">العد التنازلي</a>
            </li>
            @can('viewAny', \App\Payment::class)
            <li class="nav-item {{ Route::currentRouteName() == 'tas.payments.index' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tas.payments.index') }}">عمليات الدفع</a>
            </li>
            @endcan
            @if (Auth::check() && (Auth::user()->isTeamMember() || Auth::user()->isAdmin()))
                <li class="nav-item {{ Route::currentRouteName() == 'tas.tickets.eventEntry' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('tas.tickets.eventEntry') }}">الدخول (يوم الايفينت)</a>
                </li>
            @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="MainSiteLink" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">العودة للموقع</a>
                <div class="dropdown-menu" aria-labelledby="MainSiteLink">
                    <a class="dropdown-item" href="{{ route('home') }}">الرئيسية</a>
                    <a class="dropdown-item" href="{{ route('about-us') }}">عن الفريق</a>
                    <a class="dropdown-item" href="{{ route('contact') }}">تواصل معنا</a>
                    <a class="dropdown-item" href="{{ route('join-us') }}">انضم إلينا</a>
                    <a class="dropdown-item" href="{{ route('Tansik-Previous-Edges') }}">تنسيق السنوات السابقة</a>
                    <a class="dropdown-item" href="{{ route('Tansik-Geo-Dist') }}">جدول التوزيع الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('Tansik-Geo-Dist-Info') }}">معلومات عن القبول الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('Tansik-ReduceAlienation') }}">معلومات عن تقليل الاغتراب</a>
                    <a class="dropdown-item" href="{{ route('Tansik-Tzalom') }}">معلومات عن التظلم</a>
                    <a class="dropdown-item" href="{{ route('Tansik-Stages-Info') }}">معلومات عن مراحل التنسيق</a>
                </div>
            </li>
        </ul>
        {{--End Right--}}
        <div class="mx-md-auto"></div>
        {{--Left--}}
        <ul class="navbar-nav">
            <!-- Authentication Links -->
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">تسجيل دخول</a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">التسجيل لحضور القمة</a>
            </li>
            @endif
            @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    {{--Admin can view all users--}}
                    @if (Auth::user()->isAdmin())
                    <a class="dropdown-item {{ request()->is(route('allUsers')) ? 'active' : '' }}" href="{{ route('allUsers') }}">
                        عرض جميع مستخدمي الموقع
                    </a>
                    @endif
                    <a class="dropdown-item {{ request()->is(route('edit-user',['user' => Auth::user()->id])) ? 'active' : '' }}"
                        href="{{ route('edit-user',['user' => Auth::user()->id]) }}">
                        تعديل بياناتك
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                        تسجيل خروج
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</nav>