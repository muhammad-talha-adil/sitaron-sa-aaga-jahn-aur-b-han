@extends('layout.master')
@section('page_title','Edit User')
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
                    <a href="{{env('BASE_URL').'users'}}" class="btn btn-sm fw-bold btn-primary">
                        <i class="bi bi-list-check"></i>
                        Users List
                    </a>
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
                        <div class="card-px py-5 my-5">
                            <!--begin::Row-->
                            <div class="row mb-3">
                                <!--begin::Col-->
                                <div class="col-md-12 pe-lg-10">
                                    <!--begin::Form-->
                                    <form action="#" class="form mb-15" method="post">
                                        <!--begin::Row-->
                                        <div class="row g-3 mb-8">
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2">
                                                    <span class="required">Name</span>
                                                </label>
                                                <input type="text" class="form-control form-control-solid"
                                                       placeholder="Enter name" name="name" id="name"
                                                       value="{{$user->name}}"/>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2">
                                                    <span class="required"> Email</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                          title="Email should be valid and unique">
                                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </span>
                                                </label>
                                                <input type="email" class="form-control form-control-solid"
                                                       placeholder="Enter email" name="email" id="email"
                                                       value="{{$user->email}}"/>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <!--begin::Main wrapper-->
                                                <div class="fv-row" data-kt-password-meter="true">
                                                    <!--begin::Wrapper-->
                                                    <div class="mb-1">
                                                        <!--begin::Label-->
                                                        <label class="form-label fw-semibold fs-6 mb-2">
                                                            Password
                                                        </label>
                                                        <!--end::Label-->
                                                        <!--begin::Input wrapper-->
                                                        <div class="position-relative mb-3">
                                                            <input
                                                                class="form-control form-control-lg form-control-solid"
                                                                type="password"
                                                                placeholder="Leave empty if not to change"
                                                                name="password"
                                                                id="password"
                                                                autocomplete="off"
                                                                onfocus="this.removeAttribute('readonly');" readonly/>
                                                            <!--begin::Visibility toggle-->
                                                            <span
                                                                class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                                data-kt-password-meter-control="visibility">
                                                                    <i class="ki-duotone ki-eye-slash fs-1"><span
                                                                            class="path1"></span><span
                                                                            class="path2"></span><span
                                                                            class="path3"></span><span
                                                                            class="path4"></span></i>
                                                                    <i class="ki-duotone ki-eye d-none fs-1"><span
                                                                            class="path1"></span><span
                                                                            class="path2"></span><span
                                                                            class="path3"></span></i>
                                                            </span>
                                                            <!--end::Visibility toggle-->
                                                        </div>
                                                        <!--end::Input wrapper-->
                                                    </div>
                                                    <!--begin::Hint-->
                                                    <div class="text-muted">
                                                        Use 6 or more characters. (Leave empty if not to change)
                                                    </div>
                                                    <!--end::Hint-->
                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Main wrapper-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row g-3 mb-8">
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2">
                                                    Phone
                                                </label>
                                                <input type="text" class="form-control form-control-solid"
                                                       placeholder="Enter phone" name="phone" id="phone"
                                                       value="{{$user->phone}}"/>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-8 fv-row">
                                                <label class="fs-5 fw-semibold mb-2">
                                                    Address
                                                </label>
                                                <input type="text" class="form-control form-control-solid"
                                                       placeholder="Enter address" name="address" id="address"
                                                       value="{{$user->address}}"/>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row g-3 mb-8">
                                            <!--begin::Col-->
                                            <div class="col-md-12 fv-row">
                                                <label class="fs-5 fw-semibold mb-2">
                                                    Notes
                                                </label>
                                                <textarea class="form-control form-control-solid" rows="6"
                                                          name="notes" id="notes"
                                                          placeholder="Type any additional information here...">{{$user->notes}}</textarea>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Submit-->
                                        <div class="separator border-light my-10"></div>

                                        <div class="row">
                                            <div class="col-12">
                                                <!--begin::Actions-->
                                                <input type="hidden" id="id" value="{{$user->id}}">
                                                <div class="text-center">
                                                    <button type="reset" id="reset_form"
                                                            class="btn btn-light me-3">Reset
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary submit-btn" id="user-save-btn">
                                                        <span class="indicator-label submit-btn-label">Submit</span>
                                                        <span class="indicator-progress  submitted-processing-label">Please wait...
									                        <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
        $(document).on('click', '#user-save-btn', function (e) {
            e.preventDefault();
            do_post_ajax({
                'api_hook': 'users/update',
                'data': getFormData(),
            });
        });

        function getFormData() {
            return {
                'id': $('#id').val(),
                'name': $('#name').val(),
                'email': $('#email').val(),
                'password': $('#password').val(),
                'phone': $('#phone').val(),
                'address': $('#address').val(),
                'notes': $('#notes').val(),
            }
        }
    </script>
@endsection
