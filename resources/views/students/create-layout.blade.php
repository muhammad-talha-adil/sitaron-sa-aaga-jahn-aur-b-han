@extends('layout.master')
@section('page_title', 'Register Student')
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
                    {{-- <a href="{{ url('schools/create') }}" class="btn btn-sm fw-bold btn-success"
                >
                    <i class="bi bi-list-check"></i>
                    Register Your School
                </a> --}}
                    @if($is_admin)
                    <a href="{{ url('students') }}" class="btn btn-sm fw-bold btn-secondary">
                        <i class="bi bi-list-check"></i>
                        Students List
                    </a>
                    @endif
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
                                    @include('students.create-form')
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('page_level_scripts')
        @yield('create_form_js')
        <script>
            $('#dob').on('change', function() {
                const today = new Date();
                const birthDate = new Date(this.value);
                let age = today.getFullYear() - birthDate.getFullYear();
                const m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                $('#age').val(age);

                const ageLimit = 11;
                if (age < ageLimit || age > 16) {
                    $('#ageError').text('Age Limit: 11-16');
                } else {
                    $('#ageError').text('');
                }

            });

            $('#contact').on('input', function() {
                let value = $(this).val();

                // keep only digits
                value = value.replace(/[^0-9]/g, '');

                // max 11 digits
                if (value.length > 11) {
                    value = value.slice(0, 11);
                }

                // apply format 0321-1111111
                let formatted;
                if (value.length <= 4) {
                    formatted = value;
                } else {
                    formatted = value.slice(0, 4) + '-' + value.slice(4);
                }

                if ($(this).val() !== formatted) {
                    $(this).val(formatted);
                }
            });
        </script>
    @endsection
