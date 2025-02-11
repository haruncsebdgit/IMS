<aside class="sidebar sidebar-dark sidebar-expand-md" data-navtype="accordion">
    <div class="sidebar-content">
        <nav class="sidebar-nav">
            <ul class="nav flex-column nav-pills">
                <li class="nav-item">
                    <a class="nav-link @yield('admin_nav_dashboard')" href="{{ action('Admin\DashboardController@index') }}"><i class="icon-meter2" aria-hidden="true"></i> <span>{{ __('Dashboard') }}</span></a>
                </li>

                {{-- <div class="dropdown-divider"></div> --}}

                @if( hasUserCap(['manage_reports']) )
                    {{-- <div class="dropdown-divider"></div> --}}

                    <li class="nav-item has-submenu @yield('admin_menu_reports')">
                        <a class="nav-link" href="javascript:">
                            <i class="icon-file-text" aria-hidden="true"></i>
                            <span>{{ __('Reports') }}</span>
                        </a>

                        <ul class="submenu" data-submenu-title="{{ __('Reports') }}">

                            @if( hasUserCap('view_user_activity_log_reports') )
                            <li>
                                <a class="dropdown-item @yield('admin_menu_use_activity_log_reports')" href="{{ action('Reports\UserActivityLogController@index') }}">
                                    {{ __('User Activity Log') }}
                                </a>
                            </li>
                            @endif

                        </ul>
                    </li>
                @endif

                <div class="dropdown-divider"></div>

                @if( hasUserCap(["view_users","view_roles_permissions"]) )
                    <li class="nav-item has-submenu @yield('admin_menu_users')">
                        <a class="nav-link" href="javascript:">
                            <i class="icon-users" aria-hidden="true"></i>
                            <span>{{ __('Access Management') }}</span>
                        </a>

                        <ul class="submenu" data-submenu-title="{{ __('Access Management') }}">
                            @if( hasUserCap("view_users") )
                                <li>
                                    <a class="dropdown-item @yield('admin_menu_users_list')" href="{{ action('Users\UserController@index') }}">
                                        <span>{{ __('Users') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if( hasUserCap("view_roles_permissions") )
                                <li>
                                    <a class="dropdown-item @yield('admin_menu_roles')" href="{{ action('Users\RoleController@index') }}">
                                        <span>{{ __('Roles & Permissions') }}</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if( hasUserCap(['manage_options','view_common_labels']) )
                    <li class="nav-item has-submenu  @yield('admin_menu_settings')">
                        <a class="nav-link" href="javascript:">
                            <i class="icon-cog" aria-hidden="true"></i>
                            <span>{{ __('Settings') }}</span>
                        </a>

                        <ul class="submenu" data-submenu-title="{{ __('Settings') }}">

                            @if( hasUserCap('view_common_labels') )
                                <li>
                                    <a class="dropdown-item @yield('admin_menu_settings_common_labels')" href="{{ action('Settings\CommonLabelController@index') }}">
                                        <span>{{ __('Common Labels') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if( hasUserCap('view_financial_year') )
                                <li class="d-none">
                                    <a class="dropdown-item @yield('admin_menu_settings_financial_year')" href="{{ action('Settings\FinancialYearController@index') }}">
                                        <span>{{ __('Financial Year') }}</span>
                                    </a>
                                </li>
                            @endif

                            @if( hasUserCap('view_employees') )
                                <li>
                                    <a class="dropdown-item @yield('admin_menu_settings_employee')" href="{{ action('Settings\EmployeeController@index') }}">
                                        <span>{{ __('Employees') }}</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif

                {{-- Framework Reserved Item : Sidebar Collapse/Expand --}}
                <li class="nav-item mt-3 d-none d-md-block">
                    <?php
                    $_is_sidebar_mini = getUserMeta(Auth::id(), '_sidebar_mini');
                    $_collapse_icon   = $_is_sidebar_mini ? 'icon-circle-right2' : 'icon-circle-left2';
                    $_collapse_text   = $_is_sidebar_mini ? __('Expand Sidebar') : __('Collapse Sidebar');
                    ?>
                    <a class="nav-link" id="toggle-sidebar-mini" href="#" role="button" data-user-id="{{ Auth::id() }}">
                        <i class="toggle-sidebar-icon {{ $_collapse_icon }}" aria-hidden="true"></i> <span>{{ $_collapse_text }}</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
