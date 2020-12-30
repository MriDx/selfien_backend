<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <!-- menu profile quick info -->
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><span>Owhlo Admin</span></a>
        </div>
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>{{ __('views.backend.section.navigation.sub_header_1') }}</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-dashboard" aria-hidden="true"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.profiles') }}">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                            User Profiles
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.posts') }}">
                            <i class="fa fa-tags" aria-hidden="true"></i>
                            Posts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}">
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                            Admin Users
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>
