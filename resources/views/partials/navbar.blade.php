<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
            @if(auth()->check() && auth()->user()->isTeamMember())
            @if(auth()->user()->isAdmin())
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="AdminDropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">Admin Tools &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="AdminDropdown">
                    <a class="dropdown-item" href="{{ route('admins.logs') }}">Logs</a>
                    <a class="dropdown-item" href="{{ route('admins.all-posts') }}">View All Posts</a>
                    <a class="dropdown-item" href="{{ route('users.index') }}">View All Users</a>
                    @can('create',\App\Models\Team\Member::class)
                    <a class="dropdown-item" href="{{ route('members.index') }}">View All Members</a>
                    @endcan
                    <a class="dropdown-item" href="{{ route('admins.all-members') }}">View All Members</a>
                </div>
            </li>
            @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="QuizzesDropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">Quizzes &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="QuizzesDropdown">
                    <a class="dropdown-item" href="{{ route('quiz.index') }}">All Quizzes</a>
                    <a class="dropdown-item" href="{{ route('quiz.create') }}">Create New Quiz</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="ExamsDropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">Ministry Exams &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="ExamsDropdown">
                    <a class="dropdown-item" href="{{ route('ministryExam.index') }}">All Exams</a>
                    <a class="dropdown-item" href="{{ route('ministryExam.create') }}">Add New Exam</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="PostsDropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">Posts & Tags &nbsp;</a>
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
                <a class="nav-link dropdown-toggle" id="MainWebsiteDropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">Main Website &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="MainWebsiteDropdown">
                    <a class="dropdown-item" href="{{ route('home') }}">الرئيسية</a>
                    <a class="dropdown-item" href="{{ route('about-us') }}">عن الفريق</a>
                    <a class="dropdown-item" href="{{ route('contact') }}">تواصل معنا</a>
                    <a class="dropdown-item" href="{{ route('join-us') }}">انضم إلينا</a>
                    <hr>
                    <a class="dropdown-item" href="{{ route('tansik.previous_edges') }}">تنسيق السنوات السابقة</a>
                    <a class="dropdown-item" href="{{ route('tansik.geo_dist') }}">جدول التوزيع الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('tansik.geo_dist_info') }}">معلومات عن القبول الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('tansik.reduce_alienation') }}">معلومات عن تقليل الاغتراب</a>
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
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="TansikDropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">دليلك في التنسيق &nbsp;</a>
                <div class="dropdown-menu" aria-labelledby="TansikDropdown">
                    <a class="dropdown-item" href="{{ route('tansik.previous_edges') }}">تنسيق السنوات السابقة</a>
                    <a class="dropdown-item" href="{{ route('tansik.geo_dist') }}">جدول التوزيع الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('tansik.geo_dist_info') }}">معلومات عن القبول الجغرافي</a>
                    <a class="dropdown-item" href="{{ route('tansik.reduce_alienation') }}">معلومات عن تقليل الاغتراب</a>
                    <a class="dropdown-item" href="{{ route('tansik.tzalom') }}">معلومات عن التظلم</a>
                    <a class="dropdown-item" href="{{ route('tansik.stages_info') }}">معلومات عن مراحل التنسيق</a>
                </div>
            </li>
            @endif
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
            @else

            {{-- Notifications --}}
            <li class="nav-item dropdown" id="NotifApp" dir="ltr">
                <a v-bind:class="[newNotifications.length ? 'unread nav-link dropdown-toggle' : 'nav-link dropdown-toggle']"
                    id="NotifDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell" aria-hidden="true"></i>
                    <span class="d-inline d-md-none">Notifications</span> <span class="badge badge-pill badge-secondary"
                        v-html="newNotifications.length"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="NotifDropdown">
                    <h6 class="dropdown-header" style="cursor: pointer" @click="markAsRead">Mark As Read</h6>
                    <a class="dropdown-item bg-primary text-light" v-if="newNotifications.length"
                        v-for="notif in newNotifications" :href="notif.link" v-html="notif.text" @click="markOneAsRead(notif.id)"></a>
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
            @endguest
        </ul>

    </div>
</nav>
