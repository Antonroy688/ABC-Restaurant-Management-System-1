<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                @if (Auth::user()->hasAnyPermission(['Dashboard View']))
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                @endif
                @if (Auth::user()->hasAnyPermission(['Users Create','Users View','Users Edit','Users Delete']))
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark {{Request::is('users/*')?'active':''}}" href="javascript:void(0)" aria-expanded="false">
                        <i class="ti-user"></i>
                        <span class="hide-menu">Employees</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @if (Auth::user()->hasAnyPermission(['Users Create','Users View','Users Edit','Users Delete']))
                        <li class="sidebar-item">
                            <a href="{{ route('users.index') }}" class="sidebar-link">
                                <i class="mdi mdi-emoticon"></i>
                                <span class="hide-menu">Employee List</span>
                            </a>
                        </li>
                        @if (Auth::user()->hasAnyPermission(['Users Create']))
                        <li class="sidebar-item">
                            <a href="{{ route('users.create') }}" class="sidebar-link">
                                <i class="mdi mdi-emoticon"></i>
                                <span class="hide-menu">Employee Create</span>
                            </a>
                        </li>
                        @endif
                        @endif
                    </ul>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(['Roles Create','Roles View','Roles Edit','Roles Delete','General Settings']))
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="ti-settings"></i>
                        <span class="hide-menu">Settings</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @if (Auth::user()->hasAnyPermission(['General Settings']))
                        <li class="sidebar-item">
                            <a href="{{ route('general-settings.index') }}" class="sidebar-link">
                                <i class="mdi mdi-emoticon"></i>
                                <span class="hide-menu">General Settings</span>
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasAnyPermission(['Roles Create','Roles View','Roles Edit','Roles Delete']))
                        <li class="sidebar-item">
                            <a class="has-arrow sidebar-link waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-emoticon-cool"></i>
                                <span class="hide-menu">Roles and Permissions</span>
                            </a>
                            <ul aria-expanded="false" class="collapse second-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('roles.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-account-key"></i>
                                        <span class="hide-menu">Roles and Permissions</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (Auth::user()->hasAnyPermission(['Active Users']))
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('users.activeUsers')}}" aria-expanded="false"><i class="mdi mdi-account-star-variant"></i><span class="hide-menu">Active Users</span></a></li>
                @endif
                @if (Auth::user()->hasAnyPermission(['Activity Log']))
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('activityLog.index')}}" aria-expanded="false"><i class="mdi mdi-eye"></i><span class="hide-menu">Activity Log</span></a></li>
                @endif
            </ul>
        </nav>
    </div>
</aside>