<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>

                <!-- Dashboard Menu -->
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                <li class="submenu {{ set_active(['home', 'teacher/dashboard', 'student/dashboard', 'parent/dashboard', 'guardian/dashboard']) }}">
                    <a href="#">
                        <i class="fas fa-tachometer-alt"></i>
                        <span> Dashboard</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('home') }}" class="{{ set_active(['home']) }}">Admin Dashboard</a></li>
                        <li><a href="{{ route('teacher.dashboard') }}" class="{{ set_active(['teacher/dashboard']) }}">Teacher Dashboard</a></li>
                        <li><a href="{{ route('student.dashboard') }}" class="{{ set_active(['student/dashboard']) }}">Student Dashboard</a></li>
                        <li><a href="{{ route('guardian.dashboard') }}" class="{{ set_active(['guardian/dashboard']) }}">Guardian Dashboard</a></li>
                    </ul>
                </li>
                @endif

                <!-- Teacher Dashboard -->
                @if (Session::get('role_name') === 'Teachers')
                <li class="submenu {{ set_active(['teacher/dashboard', 'student/dashboard']) }}">
                    <a href="#">
                        <i class="fas fa-tachometer-alt"></i>
                        <span> Dashboard</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('teacher.dashboard') }}" class="{{ set_active(['teacher/dashboard']) }}">Teacher Dashboard</a></li>
                        <li><a href="{{ route('student.dashboard') }}" class="{{ set_active(['student/dashboard']) }}">Student Dashboard</a></li>
                    </ul>
                </li>
                @endif

                <!-- Student Dashboard -->
                @if (Session::get('role_name') === 'Student')
                <li class="submenu {{ set_active(['student/dashboard']) }}">
                    <a href="#">
                        <i class="fas fa-tachometer-alt"></i>
                        <span> Dashboard</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('student.dashboard') }}" class="{{ set_active(['student/dashboard']) }}">Student Dashboard</a></li>
                    </ul>
                </li>
                @endif

                <!-- Parent Dashboard -->
                @if (Session::get('role_name') === 'Parent')
                <li class="submenu {{ set_active(['parent/dashboard']) }}">
                    <a href="#">
                        <i class="fas fa-tachometer-alt"></i>
                        <span> Dashboard</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('parent.dashboard') }}" class="{{ set_active(['parent/dashboard']) }}">Parent Dashboard</a></li>
                    </ul>
                </li>
                @endif

                <!-- Guardian Dashboard -->
                @if (Session::get('role_name') === 'Guardian')
                <li class="submenu {{ set_active(['guardian/dashboard']) }}">
                    <a href="#">
                        <i class="fas fa-tachometer-alt"></i>
                        <span> Dashboard</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('guardian.dashboard') }}" class="{{ set_active(['guardian/dashboard']) }}">Guardian Dashboard</a></li>
                    </ul>
                </li>
                @endif

                <!-- User Management -->
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                <li class="submenu {{ set_active(['list/users']) }}">
                    <a href="#">
                        <i class="fas fa-shield-alt"></i>
                        <span>User Management</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('list/users') }}" class="{{ set_active(['list/users']) }}">List Users</a></li>
                    </ul>
                </li>
                @endif

                <!-- Guardians -->
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                <li class="submenu {{ set_active(['guardian/list', 'guardian/add', 'guardian/edit/*']) }}">
                    <a href="#">
                        <i class="fas fa-user-shield"></i>
                        <span> Guardians</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('guardian/list') }}" class="{{ set_active(['guardian/list']) }}">Guardian List</a></li>
                        <li><a href="{{ route('guardian/add') }}" class="{{ set_active(['guardian/add']) }}">Guardian Add</a></li>
                        <li><a href="#" class="{{ request()->is('guardian/edit/*') ? 'active' : '' }}">Guardian Edit</a></li>
                    </ul>
                </li>
                @endif

                <!-- Students -->
                <li class="submenu {{ set_active(['student/list', 'student/grid', 'student/add/page', 'student/edit/*', 'student/profile/*']) }}">
                    <a href="#">
                        <i class="fas fa-graduation-cap"></i>
                        <span> Students</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('student/list') }}" class="{{ set_active(['student/list', 'student/grid']) }}">Student List</a></li>
                        @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                        <li><a href="{{ route('student/add/page') }}" class="{{ set_active(['student/add/page']) }}">Student Add</a></li>
                        <li><a href="#" class="{{ request()->is('student/edit/*') ? 'active' : '' }}">Student Edit</a></li>
                        @endif
                        <li><a href="#" class="{{ request()->is('student/profile/*') ? 'active' : '' }}">Student View</a></li>
                    </ul>
                </li>

                <!-- Teachers -->
                <li class="submenu {{ set_active(['teacher/add', 'teacher/list', 'teacher/grid', 'teacher/edit/*']) }}">
                    <a href="#">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span> Teachers</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('teacher/list') }}" class="{{ set_active(['teacher/list', 'teacher/grid']) }}">Teacher List</a></li>
                        @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                        <li><a href="{{ route('teacher/add') }}" class="{{ set_active(['teacher/add']) }}">Teacher Add</a></li>
                        <li><a href="#" class="{{ request()->is('teacher/edit/*') ? 'active' : '' }}">Teacher Edit</a></li>
                        @endif
                    </ul>
                </li>

                <!-- Communication -->
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin' || Session::get('role_name') === 'Teachers')
                <li class="submenu {{ set_active(['communication/list', 'communication/grid', 'communication/add/page', 'communication/edit/*', 'communication/profile/*']) }}">
                    <a href="#">
                        <i class="fas fa-comments"></i>
                        <span> Communication</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('communication/list') }}" class="{{ set_active(['communication/list', 'communication/grid']) }}">Communication List</a></li>
                        <li><a href="{{ route('communication/add/page') }}" class="{{ set_active(['communication/add/page']) }}">Add Communication</a></li>
                        <li><a href="#" class="{{ request()->is('communication/edit/*') ? 'active' : '' }}">Edit Communication</a></li>
                        <li><a href="#" class="{{ request()->is('communication/profile/*') ? 'active' : '' }}">View Communication</a></li>
                    </ul>
                </li>
                @endif

                <!-- Subjects -->
                <li class="submenu {{ set_active(['subject/list/page', 'subject/add/page', 'subject/edit/*']) }}">
                    <a href="#">
                        <i class="fas fa-book-reader"></i>
                        <span> Subjects</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('subject/list/page') }}" class="{{ set_active(['subject/list/page']) }}">Subject List</a></li>
                        @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers')
                        <li><a href="{{ route('subject/add/page') }}" class="{{ set_active(['subject/add/page']) }}">Subject Add</a></li>
                        <li><a href="#" class="{{ request()->is('subject/edit/*') ? 'active' : '' }}">Subject Edit</a></li>
                        @endif
                    </ul>
                </li>

                                <!-- Results -->
                                <li class="submenu {{ set_active(['results.list', 'results.add', 'results.edit/*', 'results.show/*']) }}">
                                    <a href="#">
                                        <i class="fas fa-chart-bar"></i>
                                        <span> Results</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li><a href="{{ route('results.list') }}" class="{{ set_active(['results.list']) }}">Results List</a></li>
                                        @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers')
                                        <li><a href="{{ route('results.add') }}" class="{{ set_active(['results.add']) }}">Add Result</a></li>
                                        <li><a href="#" class="{{ request()->is('results/edit/*') ? 'active' : '' }}">Edit Result</a></li>
                                        @endif
                                        <li><a href="#" class="{{ request()->is('results/show/*') ? 'active' : '' }}">View Result</a></li>
                                    </ul>
                                </li>

                <!-- Exam Schedules -->
                <li class="submenu {{ set_active(['exam_schedule/list', 'exam_schedule/add', 'exam_schedule/edit/*']) }}">
                    <a href="#">
                        <i class="fas fa-calendar-alt"></i>
                        <span> Exam Schedules</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('exam_schedule/list') }}" class="{{ set_active(['exam_schedule/list']) }}">Exam Schedule List</a></li>
                        @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Teachers')
                        <li><a href="{{ route('exam_schedule/add') }}" class="{{ set_active(['exam_schedule/add']) }}">Add Exam Schedule</a></li>
                        <li><a href="#" class="{{ request()->is('exam_schedule/edit/*') ? 'active' : '' }}">Edit Exam Schedule</a></li>
                        @endif
                    </ul>
                </li>

                <!-- Accounts -->
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                <li class="submenu {{ set_active(['account/fees/collections/page', 'add/fees/collection/page']) }}">
                    <a href="#">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span> Accounts</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('account/fees/collections/page') }}" class="{{ set_active(['account/fees/collections/page']) }}">Fees Collection</a></li>
                        <li><a href="{{ route('add/fees/collection/page') }}" class="{{ set_active(['add/fees/collection/page']) }}">Add Fees</a></li>
                        <li><a href="{{ route('account/fees/collections/page') }}" class="{{ set_active(['fees/collection/edit']) }}">Edit Fees</a></li>
                    </ul>
                </li>
                @endif

                <!-- Settings -->
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                <li class="submenu {{ set_active(['setting/page']) }}">
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        <span> Settings</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('setting/page') }}" class="{{ set_active(['setting/page']) }}">General Settings</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>