@extends('auth.layout.master')

@section('page_title', "Reset Password - " . env('APP_NAME'))

@section('content')
    <!--begin::Body-->
    <div
        class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
        <!--begin::Card-->
        <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
            <!--begin::Wrapper-->
            <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20" id="main-content-body">
                <!--begin::Form-->
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="#">
                    <input type="hidden" name="reset_password_token" id="reset_password_token" value="{{ $reset_password_token }}">
                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <!--begin::Title-->
                        <h1 class="text-dark fw-bolder mb-3">Reset Password</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <div class="text-gray-500 fw-semibold fs-6">Reset your password!
                        </div>
                        <!--end::Subtitle=-->
                    </div>
                    <!--begin::Heading-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="password" placeholder="Password" id="password" name="password" autocomplete="off"
                               class="form-control bg-transparent"/>
                        <!--end::Password-->
                    </div>
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="password" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation" autocomplete="off"
                               class="form-control bg-transparent"/>
                        <!--end::Email-->
                    </div>
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit" id="reset-btn" class="btn btn-primary submit-btn">
                            <!--begin::Indicator label-->
                            <span class="indicator-label submit-btn-label">Submit</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress submitted-processing-label">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                    <!--end::Submit button-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Wrapper-->
            <!--end::Wrapper-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Body-->
@endsection

@section('page_scripts')
    <script type="text/javascript">

        $(document).on('click', '#reset-btn', function (e) {
            e.preventDefault();
            disable_submit_btn();
            $.ajax({
                url: api_url + 'auth/reset-password',
                method: 'POST',
                data: JSON.stringify(getFormData()),
                dataType: "JSON",
                contentType: "application/json",
                success: function (response) {
                    enable_submit_btn();
                    if (response.status) {
                        success_toaster(response.message);

                        setTimeout(function () {
                            window.location.assign(base_url + 'auth/login');
                        }, 1000);

                    } else {
                        error_toaster(response.message);
                    }

                }
            });
        });

        function getFormData() {
            return {
                'reset_password_token': $('#reset_password_token').val(),
                'password': $('#password').val(),
                'password_confirmation': $('#password_confirmation').val(),
            }
        }

    </script>
@endsection
