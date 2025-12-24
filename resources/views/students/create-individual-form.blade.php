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
</style>

<!--begin::Form-->
<form action="{{ url('students/create-individual') }}" class="form mb-15" method="post" id="add-student-form"
    enctype="multipart/form-data">
    @csrf
    <h1>Register Student (Age Limit: 11-16)</h1>

    <!--begin::Row-->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">School Name</span></label>
            <input type="text" class="form-control form-control-solid" placeholder="Enter School Name"
                name="school_name" id="school_name" />
        </div>

        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Name</span></label>
            <input type="text" class="form-control form-control-solid" placeholder="Enter Student Name"
                name="name" id="name" />
        </div>

        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Father Name</span></label>
            <input type="text" class="form-control form-control-solid" placeholder="Enter Father Name" name="father"
                id="father" />
        </div>
    </div>

    <!--begin::Row-->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Date of Birth</span></label>
            <input type="date" class="form-control form-control-solid" name="dob" id="dob" />
        </div>

        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Age</span></label>
            <input type="number" class="form-control form-control-solid" name="age" id="age" readonly />
            <small style="color:red;" id="ageError"></small>
        </div>



        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Gender</span></label>
            <input type="string" class="form-control form-control-solid" name="male" id="male" value="male" readonly />
        </div>
    </div>

    <!-- Contact Field -->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Grade</span></label>
            <select class="form-control form-control-solid" name="grade" id="grade">
                <option value="">Select Grade</option>
                <option value="8">8th</option>
                <option value="9">9th</option>
                <option value="10">Matric</option>
            </select>
        </div>
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Contact (WhatsApp)</span></label>
            <input type="tel" class="form-control form-control-solid" placeholder="Enter WhatsApp Number"
                name="contact" id="contact" />
        </div>
    </div>

    <!-- Receipt Upload -->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Upload Payment Receipt</span></label>
            <div class="receipt-upload-box" id="receiptBox">
                <p id="uploadText">Click here or choose file to upload receipt</p>
                <input type="file" name="payment_receipt_individual" id="payment_receipt_individual" accept="image/*"
                    style="display:none;">
                <img id="receiptPreview" class="receipt-preview" />
                <button type="button" class="btn btn-light-primary reselect-btn" id="reselectReceipt">Reselect</button>
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="separator border-light my-10"></div>
    <div class="row">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary submit-btn student-save-btn">
                <span class="indicator-label submit-btn-label">Submit</span>
                <span class="indicator-progress submitted-processing-label">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </div>
</form>

@section('create_form_js')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
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

            // Submit handler
            $(document).on('click', '.student-save-btn', function(e) {
                e.preventDefault();

                let params = {
                    'api_hook': 'students/store-individual',
                    'data': new FormData($("#add-student-form")[0])
                };

                do_post_ajax_callback_formData(params, function(response) {
                    if (response && response.status) {
                        // Hide the form
                        const form = document.getElementById("add-student-form");
                        form.style.display = "none";

                        // Create thank you container
                        const message = document.createElement("div");
                        const studentName = response.data ? response.data.name : '';
                        const rollNumber = response.data ? response.data.roll_number : '';
                        message.innerHTML = `
            <h2 style="
                font-family: 'Arial', sans-serif;
                color: #1F2937;
                font-size: 2rem;
                margin-bottom: 10px;
            ">Thank You!</h2>
            <p style="
                font-family: 'Arial', sans-serif;
                color: #4B5563;
                font-size: 1.1rem;
                margin-bottom: 20px;
            ">Individual Student has been added successfully.<br><strong>Student Name:</strong> ${studentName}<br><strong>Roll Number:</strong> ${rollNumber}</p>
            <button type="button" onclick="redirectToStudents()" class="btn btn-primary btn-lg">
                <i class="bi bi-person-plus"></i> Add Another Individual Student
            </button>
        `;
                        message.style.textAlign = "center";
                        message.style.marginTop = "50px";
                        message.style.opacity = 0;
                        message.style.transition = "opacity 1s ease-in-out";

                        // Append to parent
                        form.parentNode.appendChild(message);

                        // Fade in effect
                        setTimeout(() => {
                            message.style.opacity = 1;
                        }, 100);
                    }
                });
            });

            function redirectToStudents() {
                window.location.href = '{{ url('students/create-individual') }}';
            }
        });

        function redirectToStudents(schoolId) {
            window.location.href = '{{ url('students/create-individual') }}';
        }
    </script>
@endsection
