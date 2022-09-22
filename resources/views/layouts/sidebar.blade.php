<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{route('admin.index')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/logo_line.png') }}" alt="" height="62">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/logo_line.png') }}" alt="" height="60">
            </span>
        </a>

        <a href="{{route('admin.index')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/logo_dark.png') }}" alt="" height="52">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/logo_dark.png') }}" alt="" height="50">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{route('admin.index')}}">
                        <i class=""></i><span class="badge rounded-pill bg-primary float-end"></span>
                        <span>@lang('translation.Dashboard')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.users.index')}}" class="waves-effect">
                        <i class=""></i>
                        <span>@lang('translation.Manage_Member')</span>
                    </a>
                    
                </li>

                <li>
                    <a href="{{route('admin.coins.log.index')}}" class="waves-effect">
                        <i class=""></i>
                        <span>@lang('translation.Log_coin_management')</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.coins.log.witdrawConfirmList')}}" class="waves-effect">
                        <i class=""></i>
                        <span>@lang('translation.Witdraw_confirm')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class=""></i>
                        <span>@lang('translation.Status_Coins')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.coins.index')}}">@lang('translation.Manage_Coin')</a></li>
                        <li><a href="{{route('admin.coins.coin_swap_settings')}}">@lang('translation.Coin_swap_settings')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class=""></i>
                        <span>@lang('translation.Product_management')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.products.orders.index')}}">@lang('translation.Product_purchase_status')</a></li>
                        <li><a href="{{route('admin.products.index')}}">@lang('translation.Product_List')</a></li>
                        <li><a href="{{route('admin.products.register')}}">@lang('translation.Product_registration')</a></li>
                        <li><a href="{{route('admin.products.orders.status.sales')}}">@lang('translation.Sales_status')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class=""></i>
                        <span>@lang('translation.Advertising_Management')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.advertisements.index')}}">@lang('translation.Advertisement_List')</a></li>
                        <li><a href="{{route('admin.advertisements.register')}}">@lang('translation.Register_Advertisement')</a></li>
                        <li><a href="{{route('admin.advertisements.monitoring')}}">@lang('translation.Advertising_monitoring')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class=""></i>
                        <span>@lang('translation.Service_center')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.services.notices.index')}}">@lang('translation.Notice')</a></li>
                        <li><a href="{{route('admin.services.qa.index')}}">@lang('translation.Q&A')</a></li>
                        <li><a href="{{route('admin.services.banners.index')}}">@lang('translation.Banner_Settings')</a></li>
                        <li><a href="{{route('admin.services.alerts.index')}}">@lang('translation.Alert_Settings')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class=""></i>
                        <span>@lang('translation.Admin_Menu')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('admin.admins.index')}}">@lang('translation.Admin_Manager')</a></li>
                    </ul>
                </li>


                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
