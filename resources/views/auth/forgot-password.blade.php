@extends('auth.layout.master')

@section('page_title', "Forgot Password - " . env('APP_NAME'))

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
                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <!--begin::Title-->
                        <h1 class="text-dark fw-bolder mb-3">Forgot Password</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <div class="text-gray-500 fw-semibold fs-6">Enter your email!
                        </div>
                        <!--end::Subtitle=-->
                    </div>
                    <!--begin::Heading-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="email" placeholder="Email" id="email" name="email" autocomplete="off"
                               class="form-control bg-transparent"/>
                        <!--end::Email-->
                    </div>
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit" id="forgot-btn" class="btn btn-primary submit-btn">
                            <!--begin::Indicator label-->
                            <span class="indicator-label submit-btn-label">Generate Code</span>
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
                <div class="d-flex justify-content-end align-items-end flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                    <div></div>
                    <!--begin::Link-->
                    <a href="{{ env('BASE_URL') . 'auth/login'}}" class="link-primary">Login</a>
                    <!--end::Link-->
                </div>
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

        $(document).on('click', '#forgot-btn', function (e) {
            e.preventDefault();
            disable_submit_btn();
            $.ajax({
                url: api_url + 'auth/forgot-password-check',
                method: 'POST',
                data: JSON.stringify(getFormData()),
                dataType: "JSON",
                contentType: "application/json",
                success: function (response) {
                    enable_submit_btn();
                    if (response.status) {
                        success_toaster(response.message);
                    } else {
                        error_toaster(response.message);
                    }

                }
            });
        });

        function getFormData() {
            return {
                'email': $('#email').val(),
            }
        }

    </script>
@endsection
