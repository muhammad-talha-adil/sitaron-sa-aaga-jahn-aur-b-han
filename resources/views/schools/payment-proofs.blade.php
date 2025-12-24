@extends('layout.master')
@section('page_title','Payment Proofs')
@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
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
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Primary button-->
                {{--<a href="{{env('BASE_URL').'schools/create'}}" class="btn btn-sm fw-bold btn-primary">
                    <i class="bi bi-plus-square"></i>
                    Create
                </a>--}}
                <!--end::Primary button-->
                </div>
                <!--end::Actions-->
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
                    <div class="card-body p-0" id="main-content-body">
                        <!--begin::Form-->
                        <div class="card-px">
                            <!--begin::Row-->
                            <div class="row mb-3">
                                <!--begin::Col-->
                                <div class="col-md-12 pe-lg-10">
                                {{--CONTENT HERE--}}
                                <!--begin::Table-->

                                    <div class="card card-p-0 card-flush">
                                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                            <div class="card-title">
                                                <!--begin::Search-->
                                                <div class="d-flex align-items-center position-relative my-1">
                                                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-4"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                    <input type="text" data-kt-filter="search"
                                                           class="form-control form-control-solid w-250px ps-14"
                                                           placeholder="Search Report"/>
                                                </div>
                                                <!--end::Search-->
                                                <!--begin::Export buttons-->
                                                <div id="kt_datatable_example_1_export" class="d-none"></div>
                                                <!--end::Export buttons-->
                                            </div>
                                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                                <!--begin::Export dropdown-->
                                                <button type="button" class="btn btn-light-primary"
                                                        data-kt-menu-trigger="click"
                                                        data-kt-menu-placement="bottom-end">
                                                    <i class="ki-duotone ki-exit-down fs-2"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                    Export Report
                                                </button>
                                                <!--begin::Menu-->
                                                <div id="datatable_export_menu"
                                                     class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                                     data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" data-kt-export="copy">
                                                            Copy to clipboard
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" data-kt-export="excel">
                                                            Export as Excel
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" data-kt-export="csv">
                                                            Export as CSV
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="#" class="menu-link px-3" data-kt-export="pdf">
                                                            Export as PDF
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu-->
                                                <!--end::Export dropdown-->

                                                <!--begin::Hide default export buttons-->
                                                <div id="datatable_export_buttons" class="d-none"></div>
                                                <!--end::Hide default export buttons-->
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table align-middle border rounded table-row-dashed fs-6 g-5"
                                                   id="datatable">
                                                <thead>
                                                <!--begin::Table row-->
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                                                    <th class="max-w-5px text-center">Sr#</th>
                                                    <th class="min-w-50px">Screenshot</th>
                                                    <th class="min-w-100px">School</th>
                                                    <th class="text-center min-w-100px">Action</th>
                                                </tr>
                                                <!--end::Table row-->
                                                </thead>
                                                <tbody class="fw-semibold text-gray-600">
                                                @foreach($schools as $index => $school)
                                                    <tr>
                                                        <td class="text-center">
                                                            {{ $index+1 }}
                                                        </td>
                                                        <td class="d-flex align-items-center">
                                                            <!--begin:: Avatar -->
                                                            <div
                                                                class="symbol symbol-square symbol-50px overflow-hidden me-3">
                                                                <a href="{{ $school->screenshot_url }}" target="_blank">
                                                                    <div class="symbol-label">
                                                                        <img src="{{ $school->screenshot_url }}"
                                                                             alt="{{ $school->school }}" class="w-100"
                                                                             style="object-fit: cover;width: 50px;height: 50px;"/>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <!--end::Avatar-->
                                                        </td>
                                                        <td>
                                                            {{$school->school}}
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-flex gap-3 justify-content-center">
                                                                <div class="">
                                                                    <a class="btn btn-icon btn-primary btn-sm"
                                                                       download="{{ $school->school }}"
                                                                       href="{{ $school->screenshot_url }}"
                                                                       title="Download Screenshot">
                                                                        <i class="bi bi-arrow-down"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!--end::Table-->
                                    {{--END- CONTENT HERE--}}

                                </div>
                                <!--end::Col-->
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->

                        </div>
                        <!--end::Form-->
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

@section('page_level_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            initialize_datatable({document_title: 'Payment Proofs'})
        });
    </script>
@endsection
