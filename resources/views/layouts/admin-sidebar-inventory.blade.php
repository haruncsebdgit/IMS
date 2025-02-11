<aside class="sidebar sidebar-dark sidebar-expand-md" data-navtype="accordion">
    <div class="sidebar-content">
        <nav class="sidebar-nav">
            <ul class="nav flex-column nav-pills">
                <li class="nav-item">
                    <a class="nav-link @yield('admin_nav_dashboard')" href="{{ action('Admin\DashboardController@index') }}"><i class="icon-meter2" aria-hidden="true"></i> <span>{{ __('Dashboard') }}</span></a>
                </li>

                {{-- <div class="dropdown-divider"></div> --}}

                @if( hasUserCap(['view_item_category_sub_category_info']) )
                    <li class="nav-item">
                        <a class="nav-link  @yield('admin_menu_item_category_sub_category_info')" href="{{ action('Inventory\ItemCategorySubCategoryInformationController@index') }}">
                            <i class="icon-paragraph-justify2" aria-hidden="true"></i>
                            <span>{{ __('Item Category') }}</span>
                        </a>
                    </li>
                @endif
                @if( hasUserCap(['view_item_info']) )
                    <li class="nav-item">
                        <a class="nav-link  @yield('admin_menu_item_info')" href="{{ action('Inventory\ItemInformationController@index') }}">
                            <i class="icon-cube4" aria-hidden="true"></i>
                            <span>{{ __('Items') }}</span>
                        </a>
                    </li>
                @endif
                @if( hasUserCap(['view_item_receive_from_supplier_information']) )
                    <li class="nav-item">
                        <a class="nav-link  @yield('admin_menu_item_receive_from_supplier_info')" href="{{ action('Inventory\ItemReceiveFromSupplierInformationController@index') }}">
                            <i class="icon-cart" aria-hidden="true"></i>
                            <span>{{ __('Item Receive from Supplier') }}</span>
                        </a>
                    </li>
                @endif
                @if( hasUserCap(['view_item_request_information']) )
                    <li class="nav-item">
                        <a class="nav-link  @yield('admin_menu_item_allocation')" href="{{ action('Inventory\ItemAllocationController@index') }}">
                            <i class="icon-cart" aria-hidden="true"></i>
                            <span>{{ __('Item Allocation') }}</span>
                        </a>
                    </li>
                @endif
                @if( hasUserCap(['view_item_request_information']) )
                    <li class="nav-item">
                        <a class="nav-link  @yield('admin_menu_item_request')" href="{{ action('Inventory\RequestItemController@index') }}">
                            <i class="icon-cart" aria-hidden="true"></i>
                            <span>{{ __('Request Item') }}</span>
                        </a>
                    </li>
                @endif

                @if( hasUserCap(['view_item_request_information']) )
                    <li class="nav-item">
                        <a class="nav-link  @yield('admin_menu_item_return')" href="{{ action('Inventory\ReturnItemController@index') }}">
                            <i class="icon-arrow-left52" aria-hidden="true"></i>
                            <span>{{ __('Return Item') }}</span>
                        </a>
                    </li>
                @endif

                <div class="dropdown-divider"></div>

                <li class="nav-item has-submenu @yield('admin_menu_setup')">
                    <a class="nav-link" href="javascript:">
                        <i class="icon-gear" aria-hidden="true"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>

                    <ul class="submenu" data-submenu-title="{{ __('Supplier') }}">
                        @if( hasUserCap('view_supplier_info') )
                        <li>
                            <a class="dropdown-item  @yield('admin_menu_supplier_info')" href="{{ action('Inventory\SupplierController@index') }}">
                                {{-- <i class="icon-users4" aria-hidden="true"></i> --}}
                                <span>{{ __('Supplier') }}</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>


                @if( hasUserCap(['manage_reports']) )
                    <div class="dropdown-divider"></div>

                    <li class="nav-item has-submenu @yield('admin_menu_reports')">
                        <a class="nav-link" href="javascript:">
                            <i class="icon-file-text" aria-hidden="true"></i>
                            <span>{{ __('Reports') }}</span>
                        </a>

                        <ul class="submenu" data-submenu-title="{{ __('Reports') }}">

                            <li>
                                <a class="dropdown-item @yield('admin_menu_stock_reports')" href="{{ action('Reports\StockReportController@index') }}">
                                    {{ __('Stock') }}
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item @yield('admin_menu_room_wise_stock_reports')" href="{{ action('Reports\StockReportController@index', ['type'=>'room']) }}">
                                    {{ __('Room Wise Item') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <div class="dropdown-divider"></div>

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
