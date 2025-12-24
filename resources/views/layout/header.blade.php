<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <title>@yield('page_title') - {{env('APP_NAME')}}</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('assets/media/favicon.ico')}}"/>
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <!--end::Global Stylesheets Bundle-->
    <style type="text/css">
        .form-switch.form-check-solid.form-check-custom-color .form-check-input:not(:checked) {
            background-color: #f1416c !important;
        }

        .form-check-custom-color .form-check-input {
            cursor: pointer !important;
        }
    </style>
</head>
<!--end::Head-->
