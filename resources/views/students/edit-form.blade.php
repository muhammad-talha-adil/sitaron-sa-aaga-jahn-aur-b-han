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
<form action="#" class="form mb-15" method="post" id="edit-student-form">
    @csrf
    <h1>Edit School Student</h1>

    <!--begin::Row-->
    <div class="row g-3 mb-8">
        <div class="col-md-4 fv-row">
            <label class="fs-5 fw-semibold mb-2"><span class="required">School</span></label>
            <select class="form-control form-control-solid" name="school_id" id="school_id">
                <option value="">Select School</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ $student->school_id == $school->id ? 'selected' : '' }}>{{ $school->school_name }}</option>
                @endforeach
            </select>
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

    <!-- Submit -->
    <div class="separator border-light my-10"></div>
    <div class="row">
        <div class="col-12 text-center">
            <input type="hidden" id="id" name="id" value="{{ $student->id }}">
            <input type="hidden" name="participate_with" value="school">
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
    document.addEventListener("DOMContentLoaded", function () {
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
</script>
@endsection