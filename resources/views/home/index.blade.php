@extends('layout.master')
@section('page_title','Home')
@section('content')
    <!--begin::Content wrapper-->
    <div id="main-content-body" class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        @yield('page_title')</h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body p-0">
                        <!--begin::Wrapper-->
                        <div class="card-px text-center py-3 mt-10">
                        @php
                            $lang  =  substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

                            $text = "Into Education";

                            if ($lang == 'de'){
                                $text = "Into Schüleraustausch";
                            }

                            if ($lang == 'it') {
                                $text = "Into Anno";
                            }

                        @endphp
                        <!--begin::Title-->
                            <h2 class="fs-2x fw-bold mb-5">Welcome to {{$text}}</h2>
                        <!--end::Title-->

                            <!--begin::Description-->
                            <!-- <p class="text-gray-400 fs-4 fw-semibold mb-10"></p> -->
                        <!--end::Description-->
                        </div>
                        <!--end::Wrapper-->
                        <!--begin::Illustration-->
                        <div class="text-center px-4">
                            <img class="mw-100 mh-300px" alt="" src="{{asset('assets/media/logo.png')}}"/>
                        </div>
                        <!--end::Illustration-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
@endsection
