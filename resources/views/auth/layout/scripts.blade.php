<!--begin::Javascript-->
<script>
    var hostUrl = "{{ asset('assets') }}";
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<script src="{{asset('assets/js/custom.js')}}"></script>
<!--end::Javascript-->
<script type="text/javascript">
    var base_url = '{{env('BASE_URL')}}';
    var api_url = '{{env('API_URL')}}';
    console.log("Api url" + base_url);
    console.log("Base url" +api_url);
    
</script>
