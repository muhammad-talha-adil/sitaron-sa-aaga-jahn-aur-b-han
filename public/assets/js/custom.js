$(document).ready(function () {
    $.ajaxSetup({
        dataType: 'json'
    });

    $(document).ajaxStart(function () {
        toggle_block_page();
    });
    $(document).ajaxComplete(function () {
        toggle_block_page();
    });

    initialize_datepicker();
    initialize_datetimepicker();
    initialize_quill();
    $(".jquery-select2").select2();
});

function do_post_ajax(params) {
    disable_submit_btn();
    $.ajax({
        url: api_url + params.api_hook,
        method: params.method || 'POST',
        data: JSON.stringify(params.data),
        dataType: "JSON",
        contentType: "application/json",
        success: function (response) {
            enable_submit_btn();
            if (response.status) {
                success_toaster(response.message);
                return true;
            } else {
                error_toaster(response.message);
                return false;
            }
        }
    });
}

function do_post_ajax_callback_formData(params, callback) {
    disable_submit_btn();
    $.ajax({
        url: api_url + params.api_hook,
        method: params.method || 'POST',
        data: params.data,
        processData: false, // Important for FormData
        contentType: false, // Important for FormData
        success: function (response) {
            enable_submit_btn();
            if (response.status) {
                success_toaster(response.message);
                callback(response); // Pass response to the callback
            } else {
                error_toaster(response.message);
                callback(response); // Pass response to the callback
            }
        },
        error: function (xhr, status, error) {
            enable_submit_btn();
            error_toaster('An error occurred: ' + error);
            callback(false); // Pass false to the callback
        }
    });
}

function do_post_ajax_callback(params, callback) {
    disable_submit_btn();
    $.ajax({
        url: api_url + params.api_hook,
        method: params.method || 'POST',
        data: JSON.stringify(params.data),
        dataType: "JSON",
        contentType: "application/json",
        success: function (response) {
            enable_submit_btn();
            if (response.status) {
                success_toaster(response.message);
                callback(true); // Pass true to the callback
            } else {
                error_toaster(response.message);
                callback(false); // Pass false to the callback
            }
        }
    });
}


/**
 * DELETE A RECORD WITH CONFIRMATION BOX
 * ....
 * */
$(document).on('click', '.delete-record-btn', function () {
    delete_confirmation_ajax({
        'api_hook': $(this).attr('api-hook'),
        'target_element': $(this),
        'data': {
            'id': $(this).attr('data-id')
        }
    })
});

function delete_confirmation_ajax(params) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: api_url + params.api_hook,
                method: params.method || 'POST',
                data: JSON.stringify(params.data),
                dataType: "JSON",
                contentType: "application/json",
                success: function (response) {
                    $(params.target_element).parents('tr').remove();
                    if (response.status) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        )
                    }
                }
            });
        }
    })
}

/**
 * END - DELETE A RECORD WITH CONFIRMATION BOX
 * ....
 * */


/**
 * TOGGLE BLOCK /UNBLOCK PAGE
 * ....
 * */
var target = document.querySelector('#main-content-body');
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Processing...</div>',
});

function toggle_block_page() {
    if (blockUI.isBlocked()) {
        blockUI.release();
    } else {
        blockUI.block();
    }
}

/**
 * END- TOGGLE BLOCK /UNBLOCK PAGE
 * ....
 * */

function disable_submit_btn() {
    $('.submit-btn').attr('disabled', true);
    $('.submit-btn-label').hide();
    $('.submitted-processing-label').show();
}

function enable_submit_btn() {
    $('.submit-btn').attr('disabled', false);
    $('.submit-btn-label').show();
    $('.submitted-processing-label').hide();
}

function initialize_datatable(params) {
    let table_selector = params.table_selector || '#datatable';
    let buttons_selector = params.buttons_selector || '#datatable_export_buttons';
    let export_menu_selector = params.export_menu_selector || '#datatable_export_menu';
    let document_title = params.document_title || '#document_title';
    KTDatatablesExample.init(table_selector, buttons_selector, export_menu_selector, document_title);
}

function initialize_datepicker(selector = '.date_picker') {
    $(selector).flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
    });
}

function initialize_datetimepicker(selector = '.datetime_picker') {
    $(selector).flatpickr({
        enableTime: true,
        dateFormat: "d, M Y, H:i",
    });
}

function initialize_quill(selector = '.text-editor') {
    let quill = $(selector).length;

    // Break if element not found
    if (!quill) {
        return;
    }
    quill = new Quill(selector, {
        modules: {
            toolbar: [
                [{
                    header: [1, 2, false]
                }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block']
            ]
        },
        placeholder: 'Type your text here...',
        theme: 'snow' // or 'bubble'
    });
}

function success_toaster(message = 'Everything is cool') {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toastr-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    toastr.success(message, "Success");
}

function error_toaster(message = 'Something happend wrong') {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toastr-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    toastr.error(message, "Error");
}

$(document).on('click', '.logout', function (e) {
    e.preventDefault();
    $.ajax({
        url: base_url + 'logout',
        type: "POST",
        dataType: "JSON",
        success: function (response) {
            if (response.status) {
                window.location = base_url + 'login';
            }

        }
    });
});

function ifChecked(selector) {
    if ($(selector).is(':checked')) {
        return "on";
    } else {
        return "off";
    }
}


$(document).on('click', '.close-modal', function () {
    $(this).parents('.modal').modal('hide');
});

function refresh_page(link = "") {
    if (link == "") {
        window.location.assign(window.location.href);
    } else {
        window.location.assign(link);
    }
}
