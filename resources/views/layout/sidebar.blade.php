<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
     data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start"
     data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <img alt="Logo" src="{{asset('assets/media/logo.png')}}"
             class="h-40px app-sidebar-logo-minimize"/>
        <a href="{{ env('BASE_URL') }}">
            <img alt="Logo" src="{{asset('assets/media/logo.png')}}"
                 class="h-50px app-sidebar-logo-default"/>
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle"
             class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
             data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
             data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-double-left fs-2 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <style type="text/css">
        i.bi, i[class^=fonticon-], i[class*=" fonticon-"], i[class^=fa-], i[class*=" fa-"], i[class^=la-], i[class*=" la-"] {
            color: var(--custom-bg-secondary);
        }

        .menu-link.active > i.bi,
        .menu-link.active [class^=fonticon-],
        .menu-link.active [class*=" fonticon-"],
        .menu-link.active [class^=fa-],
        .menu-link.active [class*=" fa-"],
        .menu-link.active [class^=la-],
        .menu-link.active [class*=" la-"] {
            color: var(--bs-primary-inverse);
        }

        /*.menu-item.menu-accordion.here.show i.bi {*/
        /*    color: var(--bs-primary-inverse);*/
        /*}*/
    </style>
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
             data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
             data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
             data-kt-scroll-save-state="true">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                 data-kt-menu="true" data-kt-menu-expand="false">

                <!--begin:Menu item-->
            {{--<div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link {{ isset($menu) && $menu == 'dashboard' ? 'active' : '' }}"
                   href="{{env('BASE_URL').'dashboard'}}">
                    <i class="bi bi-bar-chart-line fs-3 mx-2"></i>
                    <span class="menu-title fw-bold">Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>--}}
            <!--end:Menu item-->

                <!--begin:Menu item-->
                {{-- <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ isset($menu) && ($menu == 'add_school' || $menu == 'schools_list') ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="">
                            <i class="bi bi-stack fs-3 mx-2"></i>
                        </span>
                        <span class="menu-title fw-bold">Schools</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ isset($menu) && $menu == 'add_school' ? 'active' : '' }}"
                               href="{{env('BASE_URL').'schools/create'}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fw-bold">Add School</span>
                            </a>
                            <!--end:Menu link-->

                            <!--begin:Menu link-->
                            <a
                                style="display: {{ session()->get('role')->code == 'admin'|| session()->has("school") ? "" : "none" }}"
                                class="menu-link schools-list-link {{ isset($menu) && $menu == 'schools_list' ? 'active' : '' }}"
                                href="{{env('BASE_URL').'schools'}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fw-bold">Schools List</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div> --}}
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ isset($menu) && ($menu == 'add_student' || $menu == 'students_list') ? 'here show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="">
                            <i class="bi bi-person fs-3 mx-2"></i>
                        </span>
                        <span class="menu-title fw-bold">Students</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            {{-- <a class="menu-link {{ isset($menu) && $menu == 'add_student' ? 'active' : '' }}"
                               href="{{env('BASE_URL').'students/create'}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fw-bold">Add Student</span>
                            </a> --}}
                            <!--end:Menu link-->

                            <!--begin:Menu link-->
                            <a class="menu-link"
                               href="{{env('BASE_URL').'students/create-individual'}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fw-bold">Register Student</span>
                            </a>
                            <!--end:Menu link-->

                            <!--begin:Menu link-->
                            <a class="menu-link {{ isset($menu) && $menu == 'students_list' ? 'active' : '' }}"
                                href="{{env('BASE_URL').'students'}}"
                                style="display: {{ session()->get('role')->code == 'admin'|| session()->has("school") ? "" : "none" }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title fw-bold">Students List</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->

            @if(session()->get('role')->code == 'admin')
                <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{ isset($menu) && $menu == 'change_password' ? 'active' : '' }}"
                           href="{{env('BASE_URL').'auth/change-password'}}">
                            <i class="bi bi-lock fs-3 mx-2"></i>
                            <span class="menu-title fw-bold">Change Password</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                @endif
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
    <!--begin::Footer-->
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <a href="#"
           class="logout btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
           data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click"
           title="Click here to Logout">
            <span class="btn-label">Logout</span>
            <i class="ki-duotone ki-document btn-icon fs-2 m-0">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </a>
    </div>
    <!--end::Footer-->
</div>
<!--end::Sidebar-->
