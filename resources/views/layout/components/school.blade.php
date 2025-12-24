<div class="modal fade" tabindex="-1" id="add-school-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add School</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="row">
                    <!--begin::Col-->
                    <div class="col-md-12 fv-row">
                        <label class="fs-5 fw-semibold mb-2">
                            Choose School
                        </label>
                        <select
                            data-control="select2"
                            data-placeholder="Select a school..."
                            id="school_id"
                            class="form-select form-select-solid">
                            <option value="">Choose any school...</option>
                            @foreach($schools as $school)
                                <option value="{{$school->id}}">{{$school->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Col-->

                    <!--begin::Col-->
{{--                    <div class="col-md-12 fv-row">--}}
{{--                        <label class="fs-5 fw-semibold mb-2">--}}
{{--                            Notes--}}
{{--                        </label>--}}
{{--                        <textarea name="school_type_notes" id="school_type_notes" rows="5"--}}
{{--                                  class="form-control form-control-solid school_type_notes"></textarea>--}}
{{--                    </div>--}}
                    <!--end::Col-->
                </div>
                <!--eND OF ROW-->
                <!--begin::Submit-->
                <div class="separator border-light my-10"></div>

                <div class="row">
                    <div class="col-12">
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button
                                class="btn btn-light me-3 close-modal">Close
                            </button>
                            <input type="hidden" class="callback-method-input" value="">
                            <button type="submit"
                                    class="btn btn-primary submit-btn" id="school-save-btn">
                                <span class="indicator-label submit-btn-label">Submit</span>
                                <span class="indicator-progress  submitted-processing-label">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                </div>
                <!--end::Submit-->
            </div>
        </div>
    </div>
</div>

@section('page_level_scripts')
    @parent
    <script type="text/javascript">

        var school_api_hook;
        var data_id;

        //handling event when user check multiple boxes in the list
        $(document).on('click', '.link-school-btn', function (e) {
            e.preventDefault();
            school_api_hook = $(this).attr('api-hook');
            data_id = $(this).data('id');
            $('#add-school-modal').modal('show');

        });

        $(document).on('click', '#school-save-btn', function () {
            disable_submit_btn();
            $.ajax({
                url: api_url + school_api_hook,
                method: 'POST',
                data: JSON.stringify({
                    'id': data_id,
                    'school_id': $('#school_id').val(),
                }),
                dataType: "JSON",
                contentType: "application/json",
                success: function (response) {
                    enable_submit_btn();

                    if (response.status) {
                        success_toaster(response.message);
                        $('#add-school-modal').modal('hide');
                    } else {
                        error_toaster(response.message);
                    }
                }
            });
        });
    </script>
@endsection
