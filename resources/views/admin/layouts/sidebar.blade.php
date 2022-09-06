<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TEAM 5 - LMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><span>Xin chào: {{ Sentinel::getUser()->first_name }} </span></a>
                <div class="signup"><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i></a></div>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{  url()->current() == route('dashboard')  ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Trang chủ
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('students') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Học viên
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('class.index') }}" class="nav-link {{  url()->current() == route('class.index')  ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Lớp học
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('course.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            Khóa học
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('question.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Ngân hàng câu hỏi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('test.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Test
                        </p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="{{route('score.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Score
                        </p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link">
                        <i class="fas fa-user"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('roles.index')}}" class="nav-link">
                        <i class="fas fa-user-tag"></i>
                        <p>
                            Role
                        </p>
                    </a>

                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>