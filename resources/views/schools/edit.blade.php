@extends('layout.master')
@section('page_title', 'Edit School')
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
                <a href="{{ url('schools') }}" class="btn btn-sm fw-bold btn-secondary">
                    <i class="bi bi-list-check"></i>
                    Schools List
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
                            <div class="col-md-12 pe-lg-10 text-center">
                                <!--begin::Form-->
                                <form action="#" class="form mb-15" method="post" enctype="multipart/form-data"
                                    id="edit-school-form">
                                        <!--begin::Row-->
                                        <div class="row g-3 mb-8">
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2"><span class="required">School
                                                        Name</span></label>
                                                <input type="text" class="form-control form-control-solid" autofocus
                                                    placeholder="Enter School Name" name="school_name" id="school_name"
                                                    value="{{ $school->school_name }}" />
                                            </div>

                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2"><span
                                                        class="required">Address</span></label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Enter Address" name="address" id="address"
                                                    value="{{ $school->address }}" />
                                            </div>

                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2"><span class="required">Owner
                                                        Name</span></label>
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Enter Owner Name" name="owner_name" id="owner_name"
                                                    value="{{ $school->owner_name }}" />
                                            </div>
                                        </div>

                                        <!--begin::Row-->
                                        <div class="row g-3 mb-8">
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2"><span
                                                        class="required">Phone</span></label>
                                                <input type="tel" class="form-control form-control-solid"
                                                    placeholder="Enter Phone Number" name="phone" id="phone"
                                                    value="{{ $school->phone }}" />
                                            </div>


                                        </div>

                                        <!-- Receipt Upload Box -->
                                        <div class="row g-3 mb-8" id="receipt_upload_row" >
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2"><span class="required">Upload Payment Receipt</span></label>
                                                <div class="receipt-upload-box" id="receiptBox">
                                                    <p id="uploadText">Click here or choose file to upload receipt</p>
                                                    <input type="file" name="payment_receipt" id="payment_receipt" accept="image/*" style="display:none;">
                                                    <img id="receiptPreview" class="receipt-preview" src="{{ $school->payment_receipt ? asset($school->payment_receipt) : '' }}" />
                                                    <button type="button" class="btn btn-light-primary reselect-btn" id="reselectReceipt">Reselect</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit -->
                                        <div class="separator border-light my-10"></div>
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <input type="hidden" id="id" value="{{ $school->id }}">
                                                <button type="submit"
                                                    class="btn btn-primary submit-btn school-save-btn">
                                                    <span class="indicator-label submit-btn-label">Update</span>
                                                    <span class="indicator-progress submitted-processing-label">Please
                                                        wait...
                                                        <span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_level_scripts')
                                        <style type="text/css">
                                            .image-input-placeholder {
                                                background-image: url({{ asset('/assets/media/blank-image.svg') }});
                                                background-size: cover;
                                                background-position: center;
                                            }

                                            #option_box {
                                                margin-left: 70px;
                                            }

                                            /* Receipt upload box */
                                            .receipt-upload-box {
                                                border: 2px dashed #ccc;
                                                border-radius: 8px;
                                                padding: 15px;
                                                text-align: center;
                                                cursor: pointer;
                                                transition: border-color 0.3s;
                                                background-color: #f9f9f9;
                                            }

                                            .receipt-upload-box:hover {
                                                border-color: #3b82f6;
                                            }

                                            .receipt-preview {
                                                max-width: 100%;
                                                max-height: 180px;
                                                margin-top: 10px;
                                                border-radius: 8px;
                                                display: none;
                                            }

                                            .reselect-btn {
                                                display: block;
                                                margin-top: 8px;
                                            }
                                        </style>

                                        <script type="text/javascript">
                                            document.addEventListener("DOMContentLoaded", function () {
                                                // Receipt upload elements
                                                const receiptBox = document.getElementById("receiptBox");
                                                const fileInput = document.getElementById("payment_receipt");
                                                const preview = document.getElementById("receiptPreview");
                                                const reselectBtn = document.getElementById("reselectReceipt");
                                                const uploadText = document.getElementById("uploadText");

                                                // Upload logic
                                                receiptBox.addEventListener("click", () => fileInput.click());
                                                reselectBtn.addEventListener("click", () => fileInput.click());

                                                fileInput.addEventListener("change", function () {
                                                    const file = this.files[0];
                                                    if (file) {
                                                        const reader = new FileReader();
                                                        reader.onload = function (e) {
                                                            preview.src = e.target.result;
                                                            preview.style.display = "block";
                                                            reselectBtn.style.display = "inline-block";
                                                            uploadText.style.display = "none";
                                                        };
                                                        reader.readAsDataURL(file);
                                                    }
                                                });

                                                // Show reselect button and preview if there's an existing receipt
                                                if (preview.src && preview.src !== window.location.href) {
                                                    preview.style.display = "block";
                                                    reselectBtn.style.display = "inline-block";
                                                    uploadText.style.display = "none";
                                                }
                                            });

                                            // Submit handler
                                            $(document).on('click', '.school-save-btn', function (e) {
                                                e.preventDefault();
                                                let formData = new FormData($("#edit-school-form")[0]);
                                                formData.append('id', $('#id').val());

                                                let params = {
                                                    'api_hook': 'schools/update',
                                                    'data': formData
                                                };

                                                do_post_ajax_callback_formData(params, function (response) {
                                                    if (response.status) {
                                                        success_toaster(response.message);
                                                        setTimeout(function () {
                                                            window.location.href = "{{ url('schools') }}";
                                                        }, 1500);
                                                    }
                                                    // else {
                                                    //     error_toaster(response.message || 'Something went wrong');
                                                    // }
                                                });
                                            });
                                        </script>
                                    @endsection