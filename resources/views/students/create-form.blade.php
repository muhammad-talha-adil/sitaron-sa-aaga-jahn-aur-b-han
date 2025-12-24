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

</style>

<!--begin::Form-->
<form action="{{ url('students/create') }}" class="form mb-15" method="post" id="add-student-form">
    @csrf
    <h1>Add New Student</h1>

    <!--begin::Row-->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">School</span></label>
            <select class="form-control form-control-solid" name="school_id" id="school_id">
                <option value="">Select School</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ $selected_school_id == $school->id ? 'selected' : '' }}>{{ $school->school_name }}</option>
                @endforeach
            </select>
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
            <label class="fs-5 fw-semibold mb-2"><span class="required">Grade</span></label>
            <select class="form-control form-control-solid" name="grade" id="grade">
                <option value="">Select Grade</option>
                {{-- <option value="5">5th</option>
                <option value="8">8th</option> --}}
            </select>
        </div>

        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">Gender</span></label>
            <select class="form-control form-control-solid" name="gender" id="gender">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
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
    document.addEventListener("DOMContentLoaded", function () {
        // Submit handler
        $(document).on('click', '.student-save-btn', function (e) {
            e.preventDefault();

            let params = {
                'api_hook': 'students/store',
                'data': new FormData($("#add-student-form")[0])
            };

            do_post_ajax_callback_formData(params, function (response) {
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
            ">Student has been added successfully.<br><strong>Student Name:</strong> ${studentName}<br><strong>Roll Number:</strong> ${rollNumber}</p>
            <button type="button" onclick="redirectToStudents()" class="btn btn-primary btn-lg">
                <i class="bi bi-person-plus"></i> Add Another Student
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
            window.location.href = '{{ url('students/create') }}';
        }
    });

    function redirectToStudents(schoolId) {
        window.location.href = '{{ url('students/create') }}?school_id=' + schoolId;
    }
</script>
@endsection