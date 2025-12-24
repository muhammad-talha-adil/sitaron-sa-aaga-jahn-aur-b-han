@extends('layout.master')
@section('page_title', 'Schools List')
@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        @yield('page_title') - (Total:{{ $school_count }})
                    </h1>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ env('BASE_URL') . 'schools/create' }}" class="btn btn-sm fw-bold btn-primary">
                        <i class="bi bi-plus-square"></i> Add School
                    </a>
                </div>
            </div>
        </div>

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card">
                    <div class="card-body p-0" id="main-content-body">
                        <div class="card-px">
                            <div class="row mb-3">
                                <div class="col-md-12 pe-lg-10">
                                    <div class="card card-p-0 card-flush">
                                        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                            <div class="card-title">
                                                <div class="d-flex align-items-center position-relative my-1">
                                                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-4"></i>
                                                    <input type="text" data-kt-filter="search"
                                                        class="form-control form-control-solid w-250px ps-14"
                                                        placeholder="Search Records" />
                                                </div>
                                            </div>
                                            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                                <div class="dropdown">
                                                        <button class="btn btn-sm fw-bold btn-primary dropdown-toggle" type="button" id="downloadAttendanceDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-arrow-down"></i> Download Attendance List
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="downloadAttendanceDropdown">
                                                            <li><a class="dropdown-item" href="#" id="download-all-attendance"><i class="bi bi-file-earmark-pdf"></i> ALL</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#" id="download-5th-boys"><i class="bi bi-file-earmark-pdf"></i> 5th Boys</a></li>
                                                            <li><a class="dropdown-item" href="#" id="download-5th-girls"><i class="bi bi-file-earmark-pdf"></i> 5th Girls</a></li>
                                                            <li><a class="dropdown-item" href="#" id="download-8th-boys"><i class="bi bi-file-earmark-pdf"></i> 8th Boys</a></li>
                                                            <li><a class="dropdown-item" href="#" id="download-8th-girls"><i class="bi bi-file-earmark-pdf"></i> 8th Girls</a></li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li><a class="dropdown-item" href="#" id="download-individual-students"><i class="bi bi-file-earmark-pdf"></i> Individual Students</a></li>
                                                        </ul>
                                                    </div>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <table class="table align-middle border rounded table-row-dashed fs-6 g-5"
                                                id="datatable">
                                                <thead>
                                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                                                        <th class="max-w-5px text-center">Sr#</th>
                                                        <th class="min-w-100px">School</th>
                                                        <th class="min-w-100px text-center">Receipt</th>
                                                        <th class="min-w-100px text-center">Students</th>
                                                        {{-- <th class="text-center" colspan="3">PDF Download</th> --}}
                                                        <th class="min-w-100px text-center">Actions</th>
                                                    </tr>
                                                    {{-- <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                                                        <th colspan="4"></th>
                                                        <th class="text-center">All</th>
                                                        <th class="text-center">5th Grade</th>
                                                        <th class="text-center">8th Grade</th>
                                                    </tr> --}}
                                                </thead>

                                                <tbody class="fw-semibold text-gray-600">
                                                    @foreach($schools as $index => $school)
                                                        <tr class="border-bottom-dotted border-bottom-5">
                                                            <td class="text-center">{{ $index + 1 }}</td>

                                                            <td>
                                                                <p><strong>Name:</strong> {{ $school->school_name }}</p>
                                                                <p><strong>Owner:</strong> {{ $school->owner_name }}</p>
                                                                <p><strong>Contact:</strong> {{ $school->phone }}</p>
                                                                <p><strong>Address:</strong> {{ $school->address }}</p>
                                                            </td>

                                                            <!-- 🧾 Receipt Column -->
                                                            <td class="text-center">
                                                                @if ($school->payment_receipt)
                                                                    <a href="{{ asset($school->payment_receipt) }}" target="_blank">
                                                                        <img src="{{ asset($school->payment_receipt) }}"
                                                                            alt="Receipt"
                                                                            style="width:70px; height:70px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                                                                    </a>
                                                                @else
                                                                    <span class="badge bg-light text-muted">No Receipt</span>
                                                                @endif
                                                            </td>

                                                            <!-- Students Column -->
                                                            <td class="text-center">
                                                                <a href="{{ url('students?school_id=' . $school->id) }}" class="btn btn-sm btn-primary">
                                                                    View Students ({{ $school->students->count() }})
                                                                </a>
                                                                <br>
                                                                <button type="button" class="btn btn-sm btn-success download-roll-slips-btn mt-1"
                                                                    data-school-id="{{ $school->id }}">
                                                                    <i class="bi bi-download"></i> Download Roll# Slip
                                                                </button>
                                                            </td>

                                                            <!-- PDF Download Columns -->
                                                            {{-- <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-success download-pdf-btn"
                                                                    data-school-id="{{ $school->id }}" data-grade="" data-gender="">
                                                                    <i class="bi bi-download"></i> All
                                                                </button>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="d-flex flex-column gap-1">
                                                                    <button type="button" class="btn btn-sm btn-primary download-pdf-btn"
                                                                        data-school-id="{{ $school->id }}" data-grade="5" data-gender="male">
                                                                        <i class="bi bi-download"></i> 5th (B)
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-secondary  download-pdf-btn"
                                                                        data-school-id="{{ $school->id }}" data-grade="5" data-gender="female">
                                                                        <i class="bi bi-download"></i> 5th (G)
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="d-flex flex-column gap-1">
                                                                    <button type="button" class="btn btn-sm btn-primary download-pdf-btn"
                                                                        data-school-id="{{ $school->id }}" data-grade="8" data-gender="male">
                                                                        <i class="bi bi-download"></i> 8th (B)
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-secondary download-pdf-btn"
                                                                        data-school-id="{{ $school->id }}" data-grade="8" data-gender="female">
                                                                        <i class="bi bi-download"></i> 8th (G)
                                                                    </button>
                                                                </div>
                                                            </td> --}}

                                                            <!-- Actions Column -->
                                                            <td class="text-center">
                                                                <a href="{{ url('schools/' . $school->id . '/edit') }}" class="btn btn-sm btn-icon btn-text-secondary rounded-pill" title="Edit">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-school" data-id="{{ $school->id }}" title="Delete">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
<script type="text/javascript">
    var api_base_url = '{{ env('API_URL') }}';

    $(document).ready(function () {
        initialize_datatable({ document_title: 'Schools List' });
        $(".school-select2").select2();
    });

    $(document).on('change', '.school-select2', function () {
        disable_submit_btn();
        $("#school-form").submit();
    });


    $(document).on('click', '.download-pdf-btn', function (e) {
        e.preventDefault();
        let schoolId = $(this).data('school-id');
        let grade = $(this).data('grade');
        let gender = $(this).data('gender');
        processStudentDownload(schoolId, grade, gender);
    });

    $(document).on('click', '.download-roll-slips-btn', function (e) {
        e.preventDefault();
        let schoolId = $(this).data('school-id');
        processRollSlipsDownload(schoolId);
    });

    $(document).on('click', '#download-all-attendance', function (e) {
        e.preventDefault();
        processAttendanceDownload('', '', 'all');
    });

    $(document).on('click', '#download-5th-boys', function (e) {
        e.preventDefault();
        processAttendanceDownload('5', 'male', '5th-boys');
    });

    $(document).on('click', '#download-5th-girls', function (e) {
        e.preventDefault();
        processAttendanceDownload('5', 'female', '5th-girls');
    });

    $(document).on('click', '#download-8th-boys', function (e) {
        e.preventDefault();
        processAttendanceDownload('8', 'male', '8th-boys');
    });

    $(document).on('click', '#download-8th-girls', function (e) {
        e.preventDefault();
        processAttendanceDownload('8', 'female', '8th-girls');
    });

    $(document).on('click', '#download-individual-students', function (e) {
        e.preventDefault();
        processAttendanceDownload('', '', 'individual-students');
    });

    $(document).on('click', '.delete-school', function (e) {
        e.preventDefault();
        let schoolId = $(this).data('id');
        if (confirm('Are you sure you want to delete this school?')) {
            $.ajax({
                url: api_base_url + 'schools/destroy',
                method: 'POST',
                data: { id: schoolId },
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
                    error_toaster('An error occurred while deleting the school.');
                }
            });
        }
    });


    function processStudentDownload(schoolId, grade, gender) {
        disable_submit_btn();
        $.ajax({
            url: api_base_url + "students/download-pdf",
            method: 'POST',
            data: JSON.stringify({
                school_id: schoolId,
                grade: grade,
                gender: gender
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

    function processRollSlipsDownload(schoolId) {
        disable_submit_btn();
        $.ajax({
            url: api_base_url + "students/download-roll-slips",
            method: 'POST',
            data: JSON.stringify({
                school_id: schoolId
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

    function processAttendanceDownload(grade, gender, type) {
        disable_submit_btn();
        let data = {
            grade: grade,
            gender: gender
        };

        // If downloading individual students, add participate_with filter
        if (type === 'individual-students') {
            data.participate_with = 'individual';
        }

        $.ajax({
            url: api_base_url + "students/download-pdf",
            method: 'POST',
            data: JSON.stringify(data),
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
