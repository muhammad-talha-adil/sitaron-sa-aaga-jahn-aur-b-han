@extends('layout.master')
@section('page_title', 'Edit Individual Student')
@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

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
        display: none;
        margin-top: 8px;
    }
</style>

<!--begin::Form-->
<form action="#" class="form mb-15" method="post" id="edit-student-form" enctype="multipart/form-data">
    @csrf
    <h1>Edit Individual Student</h1>

    <!--begin::Row-->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">School Name</span></label>
            <input type="text" class="form-control form-control-solid" placeholder="Enter School Name" name="school_name" id="school_name" value="{{ $student->school_name }}" />
        </div>

        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Name</span></label>
            <input type="text" class="form-control form-control-solid" placeholder="Enter Student Name"
                name="name" id="name" value="{{ $student->name }}" />
        </div>

        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Father Name</span></label>
            <input type="text" class="form-control form-control-solid" placeholder="Enter Father Name" name="father"
                id="father" value="{{ $student->father }}" />
        </div>
    </div>

    <!--begin::Row-->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Date of Birth</span></label>
            <input type="date" class="form-control form-control-solid" name="dob" id="dob" value="{{ $student->dob }}" />
        </div>

        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Grade</span></label>
            <select class="form-control form-control-solid" name="grade" id="grade">
                <option value="">Select Grade</option>
                <option value="5" {{ $student->grade == '5' ? 'selected' : '' }}>5th</option>
                <option value="8" {{ $student->grade == '8' ? 'selected' : '' }}>8th</option>
            </select>
        </div>

        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Gender</span></label>
            <select class="form-control form-control-solid" name="gender" id="gender">
                <option value="">Select Gender</option>
                <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>
    </div>

    <!-- Contact Field -->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Contact (WhatsApp)</span></label>
            <input type="number" class="form-control form-control-solid" placeholder="Enter WhatsApp Number" name="contact" id="contact" value="{{ $student->contact }}" />
        </div>
    </div>

    <!-- Receipt Upload -->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Upload Payment Receipt</span></label>
            <div class="receipt-upload-box" id="receiptBox">
                <p id="uploadText">{{ $student->payment_receipt_individual ? 'Receipt uploaded' : 'Click here or choose file to upload receipt' }}</p>
                <input type="file" name="payment_receipt_individual" id="payment_receipt_individual" accept="image/*" style="display:none;">
                <img id="receiptPreview" class="receipt-preview" src="{{ $student->payment_receipt_individual ? asset($student->payment_receipt_individual) : '' }}" {{ $student->payment_receipt_individual ? 'style="display: block;"' : '' }} />
                <button type="button" class="btn btn-light-primary reselect-btn" id="reselectReceipt" {{ $student->payment_receipt_individual ? 'style="display: inline-block;"' : '' }}>Reselect</button>
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="separator border-light my-10"></div>
    <div class="row">
        <div class="col-12 text-center">
            <input type="hidden" id="id" value="{{ $student->id }}">
            <input type="hidden" name="participate_with" value="individual">
            <button type="submit" class="btn btn-primary submit-btn student-save-btn">
                <span class="indicator-label submit-btn-label">Update</span>
                <span class="indicator-progress submitted-processing-label">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </div>
</form>

@endsection

@section('page_level_scripts')
@endsection

@section('create_form_js')
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        // Receipt upload elements
        const receiptBox = document.getElementById("receiptBox");
        const fileInput = document.getElementById("payment_receipt_individual");
        const preview = document.getElementById("receiptPreview");
        const reselectBtn = document.getElementById("reselectReceipt");
        const uploadText = document.getElementById("uploadText");

        // Upload logic
        if (receiptBox) {
            receiptBox.addEventListener("click", () => fileInput.click());
        }
        if (reselectBtn) {
            reselectBtn.addEventListener("click", () => fileInput.click());
        }

        if (fileInput) {
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
        }

        // Show reselect button and preview if there's an existing receipt
        if (preview.src && preview.src !== window.location.href) {
            preview.style.display = "block";
            reselectBtn.style.display = "inline-block";
            uploadText.style.display = "none";
        }

        // Submit handler
        $(document).on('click', '.student-save-btn', function (e) {
            e.preventDefault();
            let formData = new FormData($("#edit-student-form")[0]);

            let params = {
                'api_hook': 'students/update',
                'data': formData
            };

            do_post_ajax_callback_formData(params, function (response) {
                if (response.status) {
                    success_toaster(response.message);
                    setTimeout(function () {
                        window.location.href = "{{ url('students') }}";
                    }, 1500);
                }
            });
        });
    });

    function redirectToStudents(schoolId) {
        window.location.href = '{{ url('students/create-individual') }}';
    }
</script>
@endsection