<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
@include('auth.layout.header')
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column">
        <!--begin::Aside-->
        {{--@include('auth.layout.aside')--}}
        <!--begin::Aside-->
        <!--begin::Body-->
        @yield('content')
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
@include('auth.layout.scripts')

@yield('page_scripts')
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
