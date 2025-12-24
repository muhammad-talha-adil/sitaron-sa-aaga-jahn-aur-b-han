<!--begin::Head-->
<head>
    <title>@yield('page_title')</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="{{asset('assets/media/favicon.ico')}}"/>
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <!--begin::Page bg image-->
    <style type="text/css">
        body {
            background-image: url('{{asset("assets/media/auth/bg4.jpg")}}');
        }


    </style>
    <!--end::Page bg image-->
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
