<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ Storage::url('assets/blank.gif') }}" data-src="{{ Storage::url('assets/images/logo.svg') }}"
            onerror="this.src='../assets/images/logo.png'; this.onerror=null;" class="lazyload img-fluid" alt="فريق ثانوية حلوة">
    </a>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            @if(auth()->check() && auth()->user()->isTeamMember())
            @if(auth()->user()->isLangReviewer())
            <li class="nav-item {{ Route::currentRouteNamed('posts.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('posts.index') }}">View All Posts</a>
            </li>
            @elseif(auth()->user()->isAdmin())
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="AdminDropdown" data-bs-toggle="dropdown" aria-expanded="false">Admin Tools &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="AdminDropdown">
                    <a class="dropdown-item" href="{{ route('admins.all-posts') }}">View All Posts</a>
                    <a class="dropdown-item" href="{{ route('users.index') }}">View All Users</a>
                    @can('create',\App\Models\Team\Member::class)
                    <a class="dropdown-item" href="{{ route('members.index') }}">View All Members</a>
                    @endcan
                    <a class="dropdown-item" href="{{ route('admins.logs') }}">Logs</a>
                    <a class="dropdown-item" href="{{ route('admins.all-edges') }}">Edges Edits</a>
                    <a class="dropdown-item" href="{{ route('admins.email-sender') }}">Email Sender</a>
                </div>
            </li>
            @endif
            <li class="nav-item {{ Route::currentRouteNamed('tansik.edges.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tansik.edges.index') }}">مسابقة التنسيق</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="QuizzesDropdown" data-bs-toggle="dropdown" aria-expanded="false">Quizzes &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="QuizzesDropdown">
                    <a class="dropdown-item" href="{{ route('quiz.index') }}">All Quizzes</a>
                    <a class="dropdown-item" href="{{ route('quiz.create') }}">Create New Quiz</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="ExamsDropdown" data-bs-toggle="dropdown" aria-expanded="false">Ministry Exams &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="ExamsDropdown">
                    <a class="dropdown-item" href="{{ route('ministryExam.index') }}">All Exams</a>
                    <a class="dropdown-item" href="{{ route('ministryExam.create') }}">Add New Exam</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="PostsDropdown" data-bs-toggle="dropdown" aria-expanded="false">Posts & Tags &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="PostsDropdown">
                    <a class="dropdown-item"
                        href="{{ route('posts.view-member-posts',['member' => auth()->user()->member ]) }}">View & Edit
                        My Posts</a>
                    <a class="dropdown-item" href="{{ route('posts.create') }}">Create Post</a>
                    <a class="dropdown-item" href="{{ route('posts.index') }}">View All Posts</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('tags.index') }}">All Tags</a>
                    <a class="dropdown-item" href="{{ route('tags.create') }}">Create New Tag</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="MainWebsiteDropdown" data-bs-toggle="dropdown" aria-expanded="false">Main Website &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="MainWebsiteDropdown">
                    <a class="dropdown-item" href="{{ route('home') }}">الرئيسية</a>
                    <a class="dropdown-item" href="{{ route('search.index') }}">بحث بالاسم (جامعة / كلية)</a>
                    <a class="dropdown-item" href="{{ route('about-us') }}">عن الفريق</a>
                    <a class="dropdown-item" href="{{ route('contact') }}">تواصل معنا</a>
                    <a class="dropdown-item" href="{{ route('join-us') }}">انضم إلينا</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('tansik.previous_edges') }}">تنسيق السنوات السابقة</a>
                    <a class="dropdown-item" href="{{ route('tansik.geo_dist') }}">جدول التوزيع الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('tansik.geo_dist_info') }}">معلومات عن القبول الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('tansik.reduce_alienation') }}">معلومات عن تقليل
                        الاغتراب</a>
                    <a class="dropdown-item" href="{{ route('tansik.tzalom') }}">معلومات عن التظلم</a>
                    <a class="dropdown-item" href="{{ route('tansik.stages_info') }}">معلومات عن مراحل التنسيق</a>
                </div>
            </li>
            @else
            <li class="nav-item {{ Route::currentRouteNamed('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">الرئيسية</a>
            </li>
            <li class="nav-item {{ Route::currentRouteNamed('about-us') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('about-us') }}">عن الفريق</a>
            </li>
            <li class="nav-item {{ Route::currentRouteNamed('contact') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('contact') }}">تواصل معنا</a>
            </li>
            <li class="nav-item {{ Route::currentRouteNamed('join-us') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('join-us') }}">انضم إلينا</a>
            </li>
            <li class="nav-item {{ Route::currentRouteNamed('ministryExam.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ministryExam.index') }}">نماذج الوزارة</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://blog.thanawyahelwa.org">مدونة ثانوية حلوة</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="TansikDropdown" data-bs-toggle="dropdown" aria-expanded="false">دليلك في التنسيق &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="TansikDropdown">
                    <a class="dropdown-item" href="{{ route('search.index') }}">بحث بالاسم في الدليل</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('tansik.previous_edges') }}">تنسيق السنوات السابقة</a>
                    <a class="dropdown-item" href="{{ route('tansik.geo_dist') }}">جدول التوزيع الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('tansik.geo_dist_info') }}">معلومات عن القبول الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('tansik.reduce_alienation') }}">معلومات عن تقليل
                        الاغتراب</a>
                    <a class="dropdown-item" href="{{ route('tansik.tzalom') }}">معلومات عن التظلم</a>
                    <a class="dropdown-item" href="{{ route('tansik.stages_info') }}">معلومات عن مراحل التنسيق</a>
                </div>
            </li>
            @endif
        </ul>

        {{--End Right--}}
        <div class="mx-md-auto"></div>
        {{--Left: حساب + بحث الدليل على طرف الشريط (في RTL يظهر بعيد عن الروابط الرئيسية) --}}
        <ul class="navbar-nav align-items-lg-center flex-lg-row">
            <!-- Auth: no public login link (members use /admin). -->
            @auth

            {{-- Notifications --}}
            <li class="nav-item dropdown" id="NotifApp" dir="ltr">
                <a v-bind:class="[newNotifications.length ? 'unread nav-link dropdown-toggle' : 'nav-link dropdown-toggle']"
                    href="#" role="button" id="NotifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell" aria-hidden="true"></i>
                    <span class="d-inline d-md-none">Notifications</span>
                    <span class="badge rounded-pill bg-secondary"
                        v-html="newNotifications.length"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="NotifDropdown">
                    <h6 class="dropdown-header" style="cursor: pointer" @click="markAsRead">Mark As Read</h6>
                    <a class="dropdown-item bg-primary text-light" v-if="newNotifications.length"
                        v-for="notif in newNotifications" :href="notif.link" v-html="notif.text"
                        @click="markOneAsRead(notif.id)"></a>
                    <a class="dropdown-item bg-secondary text-light"
                        v-if="oldNotifications.length && newNotifications.length < 10" v-for="notif in oldNotifications"
                        :href="notif.link" v-html="notif.text"></a>
                    <p v-else="notifications" class="m-2">No Notifications</p>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('users.notifications',['user' => Auth::user()]) }}">View All
                        Notifications</a>

                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
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
                    <a class="dropdown-item {{ request()->is(route('users.edit',['user' => Auth::user()])) ? 'active' : '' }}"
                        href="{{ route('users.edit',['user' => Auth::user()]) }}">
                        تعديل بياناتك الشخصية
                    </a>
                    @if(auth()->user()->isTeamMember() && !is_null(auth()->user()->member))
                    <a class="dropdown-item {{ request()->is(route('members.edit',['member' => auth()->user()->member])) ? 'active' : '' }}"
                        href="{{ route('members.edit',['member' => auth()->user()->member]) }}">
                        تعديل بياناتك مع الفريق
                    </a>
                    @endif
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                        تسجيل خروج
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @endauth
            @include('partials.navbar-directory-search')
        </ul>

    </div>
</nav>
