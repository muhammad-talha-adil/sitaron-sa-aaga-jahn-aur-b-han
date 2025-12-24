@extends('layout.master')
@section('page_title','Account Settings')
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
                        <div class="card-px py-5 my-5">
                            <!--begin::Row-->
                            <div class="row mb-3">
                                <!--begin::Col-->
                                <div class="col-md-12 pe-lg-10">
                                    <!--begin::Form-->
                                    <form action="#" class="form mb-15" method="post">
                                        <!--begin::Row-->
                                        <div class="row g-3 mb-8 align-items-center justify-content-center">
                                            <!--begin::Col-->
                                            <div class="col-md-6 fv-row">
                                                <label class="fs-5 fw-semibold mb-2">
                                                    <span class="required">Name</span>
                                                </label>
                                                <input type="text" value="{{ $user->name }}" class="form-control form-control-solid"
                                                       placeholder="Enter Name" name="name"
                                                       id="name"/>
                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Col-->
                                            <div class="col-md-6 fv-row">
                                                <label class="fs-5 fw-semibold mb-2">
                                                    <span class="">Phone</span>
                                                </label>
                                                <input type="text" value="{{ $user->phone }}" class="form-control form-control-solid"
                                                       placeholder="Enter Phone" name="phone"
                                                       id="phone"/>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->


                                        <!--begin::Submit-->
                                        <div class="separator border-light my-10"></div>

                                        <div class="row">
                                            <div class="col-12">
                                                <!--begin::Actions-->
                                                <div class="text-center">
                                                    <button type="reset" id="reset_form"
                                                            class="btn btn-light me-3">Reset
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary submit-btn" id="account-settings-save-btn">
                                                        <span class="indicator-label submit-btn-label">Submit</span>
                                                        <span class="indicator-progress  submitted-processing-label">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                                                    </button>
                                                </div>
                                                <!--end::Actions-->
                                            </div>
                                        </div>
                                        <!--end::Submit-->
                                    </form>
                                    <!--end::Form-->

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
        $(document).on('click', '#account-settings-save-btn', function (e) {
            e.preventDefault();
            do_post_ajax({
                'api_hook': 'auth/update-account-settings',
                'data': getFormData(),
            });
        });

        function getFormData() {
            return {
                'name': $('#name').val(),
                'phone': $('#phone').val(),
            }
        }
    </script>

@endsection
