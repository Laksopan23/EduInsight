<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>

                <!-- Dashboard Menu -->
                <li class="submenu {{ set_active(['home', 'teacher/dashboard', 'student/dashboard', 'parent/dashboard']) }}">
                    <a href="#">
                        <i class="fas fa-tachometer-alt"></i>
                        <span> Dashboard</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('home') }}" class="{{ set_active(['home']) }}">Admin Dashboard</a></li>
                        <li><a href="{{ route('teacher/dashboard') }}" class="{{ set_active(['teacher/dashboard']) }}">Teacher Dashboard</a></li>
                        <li><a href="{{ route('student/dashboard') }}" class="{{ set_active(['student/dashboard']) }}">Student Dashboard</a></li>
                        <li><a href="{{ route('parent/dashboard') }}" class="{{ set_active(['parent/dashboard']) }}">Parent Dashboard</a></li>
                    </ul>
                </li>

                <!-- User Management Menu for Admin and Super Admin -->
                @if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
                <li class="submenu {{ set_active(['list/users']) }} {{ request()->is('view/user/edit/*') ? 'active' : '' }}">
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


                <!-- Student Management Menu -->
                <li class="submenu {{set_active(['student/list','student/grid','student/add/page'])}} {{ (request()->is('student/edit/*')) ? 'active' : '' }} {{ (request()->is('student/profile/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-graduation-cap"></i>
                        <span> Students</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('student/list') }}" class="{{set_active(['student/list','student/grid'])}}">Student List</a></li>
                        <li><a href="{{ route('student/add/page') }}" class="{{set_active(['student/add/page'])}}">Student Add</a></li>
                        <li><a class="{{ (request()->is('student/edit/*')) ? 'active' : '' }}">Student Edit</a></li>
                        <li><a href="" class="{{ (request()->is('student/profile/*')) ? 'active' : '' }}">Student View</a></li>
                    </ul>
                </li>

                <!-- Teacher Management Menu -->
                <li class="submenu  {{set_active(['teacher/add/page','teacher/list/page','teacher/grid/page','teacher/edit'])}} {{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">
                    <a href="#"><i class="fas fa-chalkboard-teacher"></i>
                        <span> Teachers</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('teacher/list/page') }}" class="{{set_active(['teacher/list/page','teacher/grid/page'])}}">Teacher List</a></li>
                        <li><a href="teacher-details.html">Teacher View</a></li>
                        <li><a href="{{ route('teacher/add/page') }}" class="{{set_active(['teacher/add/page'])}}">Teacher Add</a></li>
                        <li><a class="{{ (request()->is('teacher/edit/*')) ? 'active' : '' }}">Teacher Edit</a></li>
                    </ul>
                </li>

                <!-- Communication Menu -->
                <li class="submenu {{ set_active(['communication/list', 'communication/grid', 'communication/add/page']) }} {{ request()->is('communication/edit/*') ? 'active' : '' }} {{ request()->is('communication/profile/*') ? 'active' : '' }}">
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


                <!-- Subject Management Menu -->
                <li class="submenu {{ set_active(['subject/list/page', 'subject/add/page']) }} {{ request()->is('subject/edit/*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-book-reader"></i>
                        <span> Subjects</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('subject/list/page') }}" class="{{ set_active(['subject/list/page']) }}">Subject List</a></li>
                        <li><a href="{{ route('subject/add/page') }}" class="{{ set_active(['subject/add/page']) }}">Subject Add</a></li>
                        <li><a href="#">Subject Edit</a></li>
                    </ul>
                </li>

                <!-- Exam -->
                <li class="submenu {{ set_active(['exam/list', 'exams/create', 'exam/edit/*']) }} {{ request()->is('exam/view/*') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fas fa-clipboard-list"></i>
                        <span> Exams</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('exam.list') }}" class="{{ set_active(['exam/list']) }}">Exam List</a></li>
                        <li><a href="{{ route('exams.create') }}" class="{{ set_active(['exams/create']) }}">Create Exam</a></li>
                        <li><a class="{{ request()->is('exam/edit/*') ? 'active' : '' }}">Edit Exam</a></li>
                        <li><a href="#" class="{{ request()->is('exam/view/*') ? 'active' : '' }}">View Exam</a></li>
                    </ul>
                </li>




                <!-- Invoice Management Menu -->
                <li class="submenu {{ set_active(['invoice/list/page', 'invoice/paid/page', 'invoice/overdue/page', 'invoice/draft/page', 'invoice/recurring/page', 'invoice/cancelled/page', 'invoice/grid/page', 'invoice/add/page', 'invoice/view/page', 'invoice/settings/page', 'invoice/settings/tax/page', 'invoice/settings/bank/page']) }}" {{ request()->is('invoice/edit/*') ? 'active' : '' }}">
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

                <!-- Accounts Management Menu -->
                <li class="submenu {{ set_active(['account/fees/collections/page', 'add/fees/collection/page']) }}">
                    <a href="#">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span> Accounts</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('account/fees/collections/page') }}" class="{{ set_active(['account/fees/collections/page']) }}">Fees Collection</a></li>
                        <li><a href="#">Expenses</a></li>
                        <li><a href="#">Salary</a></li>
                        <li><a href="{{ route('add/fees/collection/page') }}" class="{{ set_active(['add/fees/collection/page']) }}">Add Fees</a></li>
                        <li><a href="#">Add Expenses</a></li>
                        <li><a href="#">Add Salary</a></li>
                    </ul>
                </li>

                <!-- Other Menus -->
                <li>
                    <a href="holiday.html"><i class="fas fa-holly-berry"></i> <span>Holiday</span></a>
                </li>
                <!-- <li>
                    <a href="fees.html"><i class="fas fa-comment-dollar"></i> <span>Fees</span></a>
                </li>
                <li>
                    <a href="exam.html"><i class="fas fa-clipboard-list"></i> <span>Exam list</span></a>
                </li>
                <li>
                    <a href="event.html"><i class="fas fa-calendar-day"></i> <span>Events</span></a>
                </li>
                <li>
                    <a href="library.html"><i class="fas fa-book"></i> <span>Library</span></a>
                </li> -->

                <!-- Settings Menu -->
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
            </ul>
        </div>
    </div>
</div>