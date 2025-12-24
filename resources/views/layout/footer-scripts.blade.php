<!--begin::Javascript-->
<script type="text/javascript">
    var base_url = '{{env('BASE_URL')}}';
    var api_url = '{{env('API_URL')}}';
</script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendor (used for this page only)-->
<link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Vendor (used for this page only)-->
<script src="{{asset('assets/js/datatables_initialize.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
@yield('page_level_scripts')
<!--end::Javascript-->

