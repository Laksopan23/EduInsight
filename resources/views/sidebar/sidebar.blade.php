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
                        <li><a href="{{ route('parent.dashboard') }}" class="{{ set_active(['parent/dashboard']) }}">Parent Dashboard</a></li>
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
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin' || Session::get('role_name') === 'Teachers')
                <li class="submenu {{ set_active(['subject/list/page', 'subject/add/page', 'subject/edit/*']) }}">
                    <a href="#">
                        <i class="fas fa-book-reader"></i>
                        <span> Subjects</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('guardian/list') }}" class="{{ set_active(['guardian/list']) }}">Guardian List</a></li>
                        <li><a href="{{ route('guardian/add') }}" class="{{ set_active(['guardian/add']) }}">Guardian Add</a></li>
                        <li><a href="#" class="{{ request()->is('guardian/edit/*') ? 'active' : '' }}">Guardian Edit</a></li>
                    </ul>
                </li>
                @endif

                <!-- Exams -->
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin' || Session::get('role_name') === 'Teachers')
                <li class="submenu {{ set_active(['exam/list', 'exams/create', 'exam/edit/*', 'exam/view/*']) }}">
                    <a href="#">
                        <i class="fas fa-clipboard-list"></i>
                        <span> Exams</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('exam.list') }}" class="{{ set_active(['exam/list']) }}">Exam List</a></li>
                        @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                        <li><a href="{{ route('exams.create') }}" class="{{ set_active(['exams/create']) }}">Create Exam</a></li>
                        <li><a href="#" class="{{ request()->is('exam/edit/*') ? 'active' : '' }}">Edit Exam</a></li>
                        @endif
                        <li><a href="#" class="{{ request()->is('exam/view/*') ? 'active' : '' }}">View Exam</a></li>
                    </ul>
                </li>
                @endif

                <!-- Invoices -->
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                <li class="submenu {{ set_active(['invoice/list/page', 'invoice/paid/page', 'invoice/overdue/page', 'invoice/draft/page', 'invoice/recurring/page', 'invoice/cancelled/page', 'invoice/grid/page', 'invoice/add/page', 'invoice/view/*', 'invoice/edit/*', 'invoice/settings/page', 'invoice/settings/tax/page', 'invoice/settings/bank/page']) }}">
                    <a href="#">
                        <i class="fas fa-clipboard"></i>
                        <span> Invoices</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('invoice/list/page') }}" class="{{ set_active(['invoice/list/page']) }}">Invoices List</a></li>
                        <li><a href="{{ route('invoice/grid/page') }}" class="{{ set_active(['invoice/grid/page']) }}">Invoices Grid</a></li>
                        <li><a href="{{ route('invoice/add/page') }}" class="{{ set_active(['invoice/add/page']) }}">Add Invoices</a></li>
                        <li><a href="#" class="{{ request()->is('invoice/edit/*') ? 'active' : '' }}">Edit Invoices</a></li>
                        <li><a href="#" class="{{ request()->is('invoice/view/*') ? 'active' : '' }}">Invoices Details</a></li>
                        <li><a href="{{ route('invoice/settings/page') }}" class="{{ set_active(['invoice/settings/page']) }}">Invoices Settings</a></li>
                    </ul>
                </li>
                @endif

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
                    </ul>
                </li>
                @endif

                <!-- Holiday -->
                <li class="{{ set_active(['holiday']) }}">
                    <a href="#">
                        <i class="fas fa-holly-berry"></i>
                        <span>Holiday</span>
                    </a>
                </li>

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