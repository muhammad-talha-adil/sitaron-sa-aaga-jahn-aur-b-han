@extends('layout.master')
@section('page_title', 'Students List')
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
                    @yield('page_title')
                    @if(isset($selected_school) && $selected_school)
                        - {{ $selected_school->school_name }} - (Total:{{ $school_student_count }})
                    @else
                    - (Total:{{$student_count}})
                    @endif
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Primary button-->
                <a href="{{ url('students/create') }}" class="btn btn-sm fw-bold btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    Add Student
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
                    <div class="card-px">
                        <div class="row mb-3">
                            <div class="col-md-12 pe-lg-10">
                                <div class="card card-p-0 card-flush">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0 pt-6">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <!--begin::Search-->
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <input type="text" data-kt-user-table-filter="search"
                                                    class="form-control form-control-solid w-250px ps-12" placeholder="Search Students" />
                                            </div>
                                            <!--end::Search-->
                                        </div>
                                        <!--begin::Card title-->
                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                            <!--begin::Filters-->
                                            <div class="d-flex align-items-center gap-3">
                                                <!-- School Filter -->
                                                <select class="form-select form-select-solid fw-bold school-filter" id="school_filter" style="width: 150px;">
                                                    <option value="">All Schools</option>
                                                    @foreach($schools as $school)
                                                        <option value="{{ $school->id }}" {{ $selected_school_id == $school->id ? 'selected' : '' }}>{{ $school->school_name }}</option>
                                                    @endforeach
                                                </select>

                                                <!-- Grade Filter -->
                                                <select class="form-select form-select-solid fw-bold grade-filter" id="grade_filter" style="width: 120px;">
                                                    <option value="">All Grades</option>
                                                    <option value="5" {{ request('grade') == '5' ? 'selected' : '' }}>5th Grade</option>
                                                    <option value="8" {{ request('grade') == '8' ? 'selected' : '' }}>8th Grade</option>
                                                </select>

                                                <!-- Gender Filter -->
                                                <select class="form-select form-select-solid fw-bold gender-filter" id="gender_filter" style="width: 120px;">
                                                    <option value="">All Genders</option>
                                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                </select>

                                                <!-- Participation Filter -->
                                                <select class="form-select form-select-solid fw-bold participation-filter" id="participation_filter" style="width: 160px;">
                                                    <option value="" {{ !request('participate_with') ? 'selected' : '' }}>All Students</option>
                                                    <option value="school" {{ request('participate_with') == 'school' ? 'selected' : '' }}>School Students</option>
                                                    <option value="individual" {{ request('participate_with') == 'individual' ? 'selected' : '' }}>Individual Students</option>
                                                </select>
                                            </div>
                                            <!--end::Filters-->
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body py-4">
                                        <!--begin::Table-->
                                        <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="datatable">
                                            <thead>
                                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="min-w-50px">#</th>
                                                    <th class="min-w-125px">Roll Number</th>
                                                    <th class="min-w-250px">Student Details</th>
                                                    <th class="min-w-125px">School</th>
                                                    <th class="min-w-125px">Grade & Gender</th>
                                                    <!-- Individual Student Columns -->
                                                    <th class="min-w-100px text-center individual-column" style="display: none;">Receipt</th>
                                                    <th class="min-w-125px text-center">Roll Slip</th>
                                                    <th class="text-end min-w-100px">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                @foreach($students as $index => $student)
                                                <tr class="border-bottom-dotted border-bottom-5">
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $student->roll_number }}</td>
                                                    <td>
                                                        <div><strong>{{ $student->display_name }}</strong></div>
                                                        <div class="text-muted fs-7">Father: {{ $student->father }}</div>
                                                        <div class="text-muted fs-7">DOB: {{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}</div>
                                                        @if($student->participate_with === 'individual')
                                                            <div class="text-muted fs-7">Contact: {{ $student->contact }}</div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $student->participate_with === 'school' ? ($student->school ? $student->school->school_name : 'N/A') : $student->school_name }}</td>
                                                    <td>
                                                        <div>{{ $student->grade }}th Grade</div>
                                                        <div class="text-muted fs-7">{{ ucfirst($student->gender) }}</div>
                                                    </td>
                                                    <!-- Individual Student Columns -->
                                                    <td class="text-center individual-column" style="display: none;">
                                                        @if($student->participate_with === 'individual' && $student->payment_receipt_individual)
                                                            <a href="{{ asset($student->payment_receipt_individual) }}" target="_blank">
                                                                <img src="{{ asset($student->payment_receipt_individual) }}"
                                                                    alt="Receipt"
                                                                    style="width:50px; height:50px; object-fit:cover; border-radius:6px; border:1px solid #ddd;">
                                                            </a>
                                                        @elseif($student->participate_with === 'individual')
                                                            <span class="badge bg-light text-muted">No Receipt</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-info download-roll-slip"
                                                            data-student-id="{{ $student->id }}">
                                                            <i class="bi bi-download"></i> Roll Slip
                                                        </button>
                                                    </td>
                                                    <td class="text-end">
                                                        @if($student->participate_with === 'school')
                                                            <a href="{{ url('students/' . $student->id . '/edit') }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        @else
                                                            <a href="{{ url('students/' . $student->id . '/edit-individual') }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        @endif
                                                            <i class="ki-duotone ki-pencil fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                        </a>
                                                        <button type="button" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm delete-student" data-id="{{ $student->id }}">
                                                            <i class="ki-duotone ki-trash fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                            </i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
@endsection

@section('page_level_scripts')
<script type="text/javascript">
    var api_base_url = '{{ env('API_URL') }}';
    $(document).ready(function () {
        initialize_datatable({ document_title: 'Students List' });

        // Show/hide individual columns based on participation filter
        if ($('#participation_filter').val() === 'individual') {
            $('.individual-column').show();
        } else {
            $('.individual-column').hide();
        }
    });

    // Filter change handlers - reload page with query params
    $(document).on('change', '.school-filter, .grade-filter, .gender-filter, .participation-filter', function () {
        let params = {
            school_id: $('#school_filter').val(),
            grade: $('#grade_filter').val(),
            gender: $('#gender_filter').val(),
            participate_with: $('#participation_filter').val()
        };

        // Build query string
        let queryString = $.param(params);

        // Reload page with filters
        window.location.href = '{{ url("students") }}' + (queryString ? '?' + queryString : '');
    });

    $(document).on('click', '.download-roll-slip', function (e) {
        e.preventDefault();
        let studentId = $(this).data('student-id');
        processRollSlipDownload(studentId);
    });

    $(document).on('click', '.delete-student', function (e) {
        e.preventDefault();
        let studentId = $(this).data('id');
        if (confirm('Are you sure you want to delete this student?')) {
            $.ajax({
                url: api_base_url + 'students/destroy',
                method: 'POST',
                data: { id: studentId },
                dataType: 'JSON',
                success: function (response) {
                    if (response.status) {
                        success_toaster(response.message);
                        location.reload();
                    } else {
                        error_toaster(response.message);
                    }
                },
                error: function () {
                    error_toaster('An error occurred while deleting the student.');
                }
            });
        }
    });

    function processRollSlipDownload(studentId) {
        disable_submit_btn();
        $.ajax({
            url: api_base_url + "students/download-single-roll-slip",
            method: 'POST',
            data: JSON.stringify({
                student_id: studentId
            }),
            dataType: "JSON",
            contentType: "application/json",
            success: function (response) {
                enable_submit_btn();
                if (response.status) {
                    openPrintWindow(response.download_path);
                } else {
                    error_toaster(response.message);
                }
            }
        });
    }

    function openPrintWindow(url) {
        let printWindow = window.open(url);
        printWindow.onload = function () {};
    }
</script>
@endsection