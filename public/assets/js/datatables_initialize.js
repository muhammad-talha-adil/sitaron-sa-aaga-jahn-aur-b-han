"use strict";
// Class definition
var KTDatatablesExample = function () {
    // Shared variables
    var table;
    var datatable;

    // Private functions
    var initDatatable = function () {
        datatable = $(table).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'lengthMenu': [10, 25, 50, 100],
        });
    }

    // Hook export buttons
    var exportButtons = (buttons_selector, export_menu_selector, document_title) => {
        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'copyHtml5',
                    title: document_title,
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: document_title,
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'csvHtml5',
                    title: document_title,
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: document_title,
                    exportOptions: {
                        columns: ':not(:last-child)',
                    }
                }
            ]
        }).container().appendTo($(buttons_selector));

        // Hook dropdown menu click event to datatable export buttons
        const exportButtons = document.querySelectorAll(`${export_menu_selector} [data-kt-export]`);
        exportButtons.forEach(exportButton => {
            exportButton.addEventListener('click', e => {
                e.preventDefault();

                // Get clicked export value
                const exportValue = e.target.getAttribute('data-kt-export');
                const target = document.querySelector('.dt-buttons .buttons-' + exportValue);

                // Trigger click event on hidden datatable export buttons
                target.click();
            });
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Public methods
    return {
        init: function (table_selector = '#kt_datatable_example', buttons_selector = '#kt_datatable_example_buttons', export_menu_selector = '#kt_datatable_example_export_menu', document_title = 'Report') {
            table = document.querySelector(table_selector);

            if (!table) {
                return;
            }

            initDatatable();
            exportButtons(buttons_selector, export_menu_selector, document_title);
            handleSearchDatatable();
        }
    };
}();
