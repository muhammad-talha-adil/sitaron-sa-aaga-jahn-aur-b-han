@extends('layout.master')
@section('page_title','Dashboard')
@section('content')
    <style>
        .widget-two {
            padding: 15px 15px;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            position: relative;
            overflow: hidden;
            align-items: center;
            height: 100%;
        }

        .widget-two__icon {
            width: 65px;
            height: 65px;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .widget-two__content {
            width: calc(100% - 65px);
            padding-left: 20px;
        }

        .widget-two .overlay-icon {
            position: absolute;
            bottom: -19px;
            right: -7px;
            font-size: 60px !important;
            -webkit-transform: rotate(-45deg) !important;
            -ms-transform: rotate(-45deg) !important;
            transform: rotate(-45deg) !important;
            opacity: 0.15 !important;
        }

        .widget-two__btn {
            position: absolute;
            top: 5px;
            right: 5px;
            border-radius: 4px;
            font-size: 10px;
            padding: 0 5px;
            transition: all 0.3s;
        }

        .btn-outline--success:hover {
            background-color: #28c76f;
            color: white;
        }

        .btn-outline--success {
            color: #28c76f;
            border-color: #28c76f !important;
        }

        .bg--warning {
            background-color: #ff9f43 !important;
        }

        .text--warning {
            color: #ff9f43 !important;
        }

        .btn-outline--warning {
            color: #ff9f43;
            border-color: #ff9f43;
        }

        .btn-outline--warning:hover {
            background-color: #ff9f43;
            color: white;
        }

        .btn-outline--danger {
            color: #ea5455;
            border-color: #ea5455;
        }

        .btn-outline--danger:hover {
            background-color: #ea5455;
            color: white;
        }

        .bg--primary {
            background-color: #4634ff !important;
        }

        .text--primary {
            color: #4634ff !important;
        }

        .btn-outline--primary {
            color: #4634ff;
            border-color: #4634ff;
        }

        .btn-outline--primary:hover {
            background-color: #4634ff;
            color: white;
        }

        .table:not(.table-bordered) tr:first-child,
        .table:not(.table-bordered) th:first-child,
        .table:not(.table-bordered) td:first-child {
            padding-left: 1rem !important
        }

        .table.g-5 th,
        .table.g-5 td {
            padding: 1rem !important
        }

        /*SELECT2  STYLE*/
        .select2-selection__rendered {
            line-height: 40px !important;
        }

        .select2-container .select2-selection--single {
            height: 45px !important;
        }

        .select2-selection__arrow {
            height: 34px !important;
        }

        .item_thead {
            background: #1e1e2d;
            color: white;
            text-align: center;
        }

        .select2-result-repository {
            padding-top: 4px;
            padding-bottom: 3px;
        }

        .select2-result-repository__avatar {
            float: left;
            width: 60px;
            margin-right: 10px;
        }

        .select2-result-repository__avatar img {
            width: 100%;
            height: auto;
            border-radius: 2px;
        }

        .select2-result-repository__meta {
            margin-left: 70px;
        }

        .select2-result-repository__title {
            color: black !important;
            font-weight: 700;
            word-wrap: break-word;
            line-height: 1.1;
            margin-bottom: 4px;
        }

        .select2-result-repository__phoneno,
        .select2-result-repository__contacts,
        .select2-result-repository__rate,
        .select2-result-repository__itemgroup,
        .select2-result-repository__start_date,
        .select2-result-repository__deadline_date,
        .select2-result-repository__customer {
            margin-right: 1em;
        }

        .select2-result-repository__phoneno,
        .select2-result-repository__contacts,
        .select2-result-repository__dogs,
        .select2-result-repository__rate,
        .select2-result-repository__itemgroup,
        .select2-result-repository__unit,
        .select2-result-repository__start_date,
        .select2-result-repository__deadline_date,
        .select2-result-repository__customer {
            display: inline-block;
            color: black !important;
            font-size: 11px;
        }

        .select2-result-repository__description {
            font-size: 13px;
            color: black !important;
            margin-top: 4px;
        }

        .select2-results__option--highlighted .select2-result-repository__title {
            color: white;
        }

        .select2-results__option--highlighted .select2-result-repository__phoneno,
        .select2-results__option--highlighted .select2-result-repository__contacts,
        .select2-results__option--highlighted .select2-result-repository__description,
        .select2-results__option--highlighted .select2-result-repository__dogs,
        .select2-results__option--highlighted .select2-result-repository__rate,
        .select2-results__option--highlighted .select2-result-repository__itemgroup,
        .select2-results__option--highlighted .select2-result-repository__unit,
        .select2-results__option--highlighted .select2-result-repository__start_date,
        .select2-results__option--highlighted .select2-result-repository__deadline_date,
        .select2-results__option--highlighted .select2-result-repository__customer {
            color: black !important;
        }

        li.select2-results__option:hover * {
            /*background: #2e365c;*/
            /*Custom background color*/
            color: black !important;
        }

        .select2-container--default .select2-results__option.select2-results__option--highlighted {
            background: black !important;
        }

        /*END - SELECT2  STYLE*/

        .theme-bg-row {
            background-color: #1e1e2d;
            color: white;
        }

        .theme-bg-green-row {
            background-color: #d0ffc5;
            font-weight: bold;
        }

        .subtotal-row {
            background-color: #fdfad0;
            font-weight: bold;
        }

        .grandtotal-row {
            background-color: #f1e975;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        @yield('page_title')</h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div id="main-content-body"></div><!--Just for blockui-->


                <div class="row mb-3 gy-4">
                    <div class="col-xxl-3 col-sm-6">
                        <!-- <div class="card card-stats mb-4 mb-xl-0"> -->
                        <a href="{{'#users?status=pending'}}">
                            <div class="card-body bg-primary rounded p-5">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <i class="fa-solid fa-person-circle-question fs-2hx text-white">
                                        </i>
                                    </div>
                                    <div class="col-8 text-end">
                                            <span class="text-capitalize fs-5 text-white mb-2">Students</span>
                                        <h2 class="font-weight-bold fs-2hx mb-0 text-white">{{ $students_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!-- </div> -->
                    </div>

                    <div class="col-xxl-3 col-sm-6">
                        <!-- <div class="card card-stats mb-4 mb-xl-0"> -->
                        <a href="{{'#users?status=pending'}}">
                            <div class="card-body bg-primary rounded p-5">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <i class="fa-solid fa-building-circle-arrow-right fs-2hx text-white">
                                        </i>
                                    </div>
                                    <div class="col-8 text-end">
                                            <span class="text-capitalize fs-5 text-white mb-2">Schools</span>
                                        <h2 class="font-weight-bold fs-2hx mb-0 text-white">{{ $schools_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <!-- </div> -->
                    </div>
                </div>
                <!--End of row-->

                {{--<div class="row gy-4 mt-2">
                    <div class="col-xxl-3 col-sm-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="bg-white shadow-sm rounded">
                                <div class="widget-two">
                                    <i class="overlay-icon bi bi-cash-coin text-success">
                                    </i>
                                    <div class="rounded bg-danger widget-two__icon justify-content-center align-items-center">
                                        <i class="bi bi-gender-male fs-2hx text-white">
                                        </i>
                                    </div>
                                    <div class="widget-two__content">
                                        <span class="h2 font-weight-bold text-dark mb-0">{{ $male_dogs_count }}</span>
                                        <h5 class="text-capitalize text-dark-emphasis mb-2">Male Dogs</h5>
                                    </div>
--}}{{--                                    <a class="widget-two__btn btn-outline--danger border border-danger-subtle" href="{{env('base_url').'dogs/investments'}}">View All</a>--}}{{--
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-sm-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="bg-white shadow-sm rounded">
                                <div class="widget-two">
                                    <i class="overlay-icon bi bi-wallet-fill fs-2hx text--warning">
                                    </i>
                                    <div class="rounded bg--warning widget-two__icon justify-content-center align-items-center">
                                        <i class="bi bi-gender-female fs-2hx text-white">
                                        </i>
                                    </div>
                                    <div class="widget-two__content">
                                        <span class="h2 font-weight-bold text-dark mb-0">{{ $female_dogs_count }}</span>
                                        <h5 class="text-capitalize text-dark-emphasis mb-2">Female Dogs</h5>
                                    </div>
--}}{{--                                    <a class="widget-two__btn btn-outline--warning border border-warning-subtle" href="{{env('base_url').'dogs/investments?status=pending'}}">View All</a>--}}{{--
                                </div>
                            </div>
                        </div>
                    </div>
                </div>--}}
                <!--End of row-->
                <!--begin::Row-->
                {{--<div class="row gy-5 g-xl-10 mb-5 mt-5">
                    <div class="col-12">
                        <div class="card">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <h4 class="card-title d-flex align-items-start flex-column">
                                    <span
                                        class="card-label fw-bold text-gray-800">Registeration in past 15 days</span>
                                </h4>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-6">
                                <div id="line-chart-div">
                                    <canvas id="line-chart" width="800" height="200"></canvas>
                                </div>
                            </div>
                        </div><!--End of card-->
                    </div>
                </div>--}}
                <!--end::Row-->

                <!--begin::Row-->
                {{--<div class="row gy-5 g-xl-10">
                    <div class="col-xl-4 mb-xl-10">
                        <div class="card">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <h4 class="card-title d-flex align-items-start flex-column">
                                    <span
                                        class="card-label fw-bold text-gray-800">Dogs</span>
                                </h4>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-6">
                                <div class="portlet-body" id="dogs-pie-div">
                                    <canvas id="dogs-pie" width="500" height="400"></canvas>
                                </div>
                            </div>
                            <!--End of card-->
                        </div>

                    </div>

                    <div class="col-xl-8 mb-xl-10">
                        <div class="card">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <!--begin::Title-->
                                <h4 class="card-title d-flex align-items-start flex-column">
                                    <span
                                        class="card-label fw-bold text-gray-800">Recent 20  Registerations </span>
                                </h4>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-6">
                                <table class="table align-middle border rounded table-row-dashed fs-6 g-5"
                                       id="datatable">
                                    <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase">
                                        <th class="min-w-50px">Name</th>
                                        <th>Dog Gender</th>
                                        <th>Preference</th>
                                        <th>Registration Date</th>
                                        <th>Breed</th>
                                    </tr>
                                    <!--end::Table row-->
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    @foreach($recent_users as $r_user)
                                        <tr>
                                            <td>{{$r_user->name}}</td>
                                            <td>{{$r_user->dog->gender ?? ""}}</td>
                                            <td>{{$r_user->dog->preference ?? ""}}</td>
                                            <td>{{$r_user->created_at_formatted ?? ""}}</td>
                                            <td>{{$r_user->dog->breed ?? ""}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--End of card-->
                        </div>

                    </div>
                </div>--}}
                <!--end::Row-->
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
    </div>
    <!--end::Content wrapper-->
@endsection
@section('page_level_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            lineChart();
            pieChart();
            initialize_datatable({document_title: 'Products Stock List'})
        });


        function lineChart() {
            $('#line-chart-div').html(`<canvas id="line-chart" width="800" height="200"></canvas>`);
            $.ajax({
                url: api_url + "dashboard/line-chart",
                method: 'POST',
                dataType: 'json',
                success: function (returnData) {
                    //Line Chart
                    new Chart(document.getElementById("line-chart"), {
                        type: 'line',
                        data: {
                            labels: returnData.labels,
                            datasets: returnData.data
                        },
                        options: {
                            title: {
                                display: true,
                                text: "Hover over any date to view the details"
                            }
                        }
                    });

                    //END OF LINE CHART
                },
                error: function (returnData) {
                    console.log("You must have sufficient data to show the Bar Chart");
                }
            });
        }

        function pieChart() {
            $('#dogs-pie-div').html(`<canvas id="dogs-pie" width="500" height="400"></canvas>`);
            $.ajax({
                url: api_url + "dashboard/pie-chart",
                method: 'POST',
                dataType: 'json',
                success: function (returnData) {

                    //PIE CHART[[[
                    new Chart(document.getElementById("dogs-pie"), {
                        type: 'pie',
                        data: {
                            labels: returnData.labels,
                            datasets: [{
                                label: "DOGS STATS",
                                backgroundColor: returnData.bg_colors,
                                data: returnData.quantity
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            title: {
                                display: true,
                                text: "DOGS STATS"
                            }
                        }
                    });

                    //END OF PIE CHART


                },
                error: function (returnData) {
                    console.log("You must have sufficient data to show the Bar Chart");
                }
            });
        }
    </script>
@endsection
