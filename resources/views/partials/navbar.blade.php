<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ Storage::url('assets/images/logo.svg') }}" onerror="this.src='../assets/images/logo.png'; this.onerror=null;" class="img-fluid" alt="فريق ثانوية حلوة">
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
                <a class="nav-link dropdown-toggle" id="TansikDropdown" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">دليلك في التنسيق &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="TansikDropdown">
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
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">تسجيل دخول</a>
                </li> --}}
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        {{--Admin can view all users--}}
                        {{-- @if (Auth::user()->isAdmin())
                        <a class="dropdown-item {{ request()->is(route('allUsers')) ? 'active' : '' }}"
                            href="">
                            عرض جميع مستخدمي الموقع
                        </a>
                        @endif --}}
                        <a class="dropdown-item {{ request()->is(route('edit-user',['user' => Auth::user()->id])) ? 'active' : '' }}"
                            href="{{ route('edit-user',['user' => Auth::user()->id]) }}">
                            تعديل بياناتك
                        </a>
                        <a class="dropdown-item {{ request()->is(route('members.index')) ? 'active' : '' }}"
                            href="{{ route('members.index') }}">
                            تعديل أعضاء الفريق
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
