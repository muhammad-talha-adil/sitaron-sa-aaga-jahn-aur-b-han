@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
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

    /* Image upload box */
    .image-upload-box {
        border: 2px dashed #ccc;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.3s;
        background-color: #f9f9f9;
    }

    .image-upload-box:hover {
        border-color: #3b82f6;
    }

    .image-preview {
        max-width: 100%;
        max-height: 180px;
        margin-top: 10px;
        border-radius: 8px;
        display: none;
    }
</style>

<!--begin::Form-->
<form action="{{ url('students/' . $student->id . '/edit') }}" class="form mb-15" method="post" id="edit-student-form"
    enctype="multipart/form-data">
    @csrf
    @method('POST')
    <h1>Edit Student</h1>

    <!--begin::Row-->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2">School Name</label>
            <input type="text" class="form-control form-control-solid" placeholder="Enter School Name"
                name="school_name" id="school_name" value="{{ $student->school_name }}" />
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
            <label class="fs-5 fw-semibold mb-2"><span class="required">Age</span></label>
            <input type="number" class="form-control form-control-solid" name="age" id="age" readonly value="{{ $student->age }}" />
            <small style="color:red;" id="ageError"></small>
        </div>

        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Gender</span></label>
            <input type="text" class="form-control form-control-solid" name="gender" id="gender" value="male" readonly />
        </div>
    </div>

    <!-- Contact Field -->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Grade</span></label>
            <select class="form-control form-control-solid" name="grade" id="grade">
                <option value="8" {{ $student->grade == '8' ? 'selected' : '' }}>8th</option>
                <option value="9" {{ $student->grade == '9' ? 'selected' : '' }}>9th</option>
                <option value="10" {{ $student->grade == '10' ? 'selected' : '' }}>Matric</option>
            </select>
        </div>
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2">Contact (WhatsApp)</label>
            <input type="tel" class="form-control form-control-solid" placeholder="Enter WhatsApp Number"
                name="contact" id="contact" value="{{ $student->contact }}" />
        </div>
    </div>

    <!-- Receipt and Image -->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2">Upload Payment Receipt</label>
            <div class="receipt-upload-box" id="receiptBox">
                <p id="uploadText">Click here or choose file to upload receipt</p>
                <input type="file" name="payment_receipt" id="payment_receipt" accept="image/*"
                    style="display:none;">
                <img id="receiptPreview" class="receipt-preview" src="{{ $student->payment_receipt ? asset($student->payment_receipt) : '' }}" />
                <button type="button" class="btn btn-light-primary reselect-btn" id="reselectReceipt">Reselect</button>
            </div>
        </div>
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2">Student Image</label>
            <div class="image-upload-box" id="imageBox">
                <p id="imageUploadText">Click here or choose file to upload student image</p>
                <input type="file" name="student_image" id="student_image" accept="image/*"
                    style="display:none;">
                <img id="imagePreview" class="image-preview" src="{{ $student->student_image ? asset($student->student_image) : '' }}" />
                <button type="button" class="btn btn-light-primary reselect-btn" id="reselectImage">Reselect</button>
            </div>
        </div>
    </div>


    <!-- Submit -->
    <div class="separator border-light my-10"></div>
    <div class="row">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary submit-btn student-save-btn">
                <span class="indicator-label submit-btn-label">Update</span>
                <span class="indicator-progress submitted-processing-label">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </div>
</form>

@section('edit_form_js')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Receipt upload elements
            const receiptBox = document.getElementById("receiptBox");
            const fileInput = document.getElementById("payment_receipt");
            const preview = document.getElementById("receiptPreview");
            const reselectBtn = document.getElementById("reselectReceipt");
            const uploadText = document.getElementById("uploadText");

            // Show preview if exists
            if (preview.src) {
                preview.style.display = "block";
                reselectBtn.style.display = "inline-block";
                uploadText.style.display = "none";
            }

            // Upload logic
            if (receiptBox) {
                receiptBox.addEventListener("click", () => fileInput.click());
            }
            if (reselectBtn) {
                reselectBtn.addEventListener("click", () => fileInput.click());
            }

            if (fileInput) {
                fileInput.addEventListener("change", function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = "block";
                            reselectBtn.style.display = "inline-block";
                            uploadText.style.display = "none";
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Image upload elements
            const imageBox = document.getElementById("imageBox");
            const imageFileInput = document.getElementById("student_image");
            const imagePreview = document.getElementById("imagePreview");
            const imageReselectBtn = document.getElementById("reselectImage");
            const imageUploadText = document.getElementById("imageUploadText");

            // Show image preview if exists
            if (imagePreview.src) {
                imagePreview.style.display = "block";
                imageReselectBtn.style.display = "inline-block";
                imageUploadText.style.display = "none";
            }

            // Image upload logic
            if (imageBox) {
                imageBox.addEventListener("click", () => imageFileInput.click());
            }
            if (imageReselectBtn) {
                imageReselectBtn.addEventListener("click", () => imageFileInput.click());
            }

            if (imageFileInput) {
                imageFileInput.addEventListener("change", function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = "block";
                            imageReselectBtn.style.display = "inline-block";
                            imageUploadText.style.display = "none";
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Submit handler
            $(document).on('click', '.student-save-btn', function(e) {
                e.preventDefault();

                let formData = new FormData($("#edit-student-form")[0]);
                formData.append('id', {{ $student->id }});
                let params = {
                    'api_hook': 'students/update',
                    'data': formData
                };

                do_post_ajax_callback_formData(params, function(response) {
                    if (response && response.status) {
                        // Redirect to students list
                        window.location.href = '{{ url("students") }}';
                    }
                });
            });
        });

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

        // Format contact on load
        let contactValue = $('#contact').val();
        if (contactValue) {
            contactValue = contactValue.replace(/[^0-9]/g, '');
            if (contactValue.length > 4) {
                contactValue = contactValue.slice(0, 4) + '-' + contactValue.slice(4);
            }
            $('#contact').val(contactValue);
        }

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