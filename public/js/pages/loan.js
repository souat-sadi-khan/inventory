/* ------------------------------------------------------------------------------
 *
 *  # Select extension for Datatables
 *
 *  Demo JS code for datatable_extension_select.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------
var emran = "";
var DatatableSelect = function() {

    // Basic Datatable examples
    var _componentDatatableSelect = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend($.fn.dataTable.defaults, {
            autoWidth: false,
            responsive: true,
            dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            }
        });

        emran = $('.content_managment_table').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-clipboard" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-table" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
            ],
            columnDefs: [{
                width: "100px",
                targets: [0]
            }, {
                orderable: false,
                targets: [4]
            }],

            order: [0, 'desc'],
            processing: true,
            serverSide: true,

            ajax: $('.content_managment_table').data('url'),
            columns: [
                // { data: 'checkbox', name: 'checkbox' },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'date',
                    name: 'date'
                }, {
                    data: 'loan_from',
                    name: 'loan_from'
                }, {
                    data: 'amount',
                    name: 'amount'
                }, {
                    data: 'interest',
                    name: 'interest'
                }, {
                    data: 'payable',
                    name: 'payable'
                }, {
                    data: 'paid',
                    name: 'paid'
                }, {
                    data: 'due',
                    name: 'due'
                }, {
                    data: 'action',
                    name: 'action'
                }
            ]

        });


    };

    var _componentRemoteModalLoad = function() {
        $(document).on('click', '#content_managment', function(e) {
            
            e.preventDefault();
            //open modal
            $('#modal_remote').modal('toggle');
            // it will get action url
            var url = $(this).data('url');
            // leave it blank before ajax call
            $('.modal-body').html('');
            // load ajax loader
            $('#modal-loader').show();
            $.ajax({
                    url: url,
                    type: 'Get',
                    dataType: 'html'
                })
                .done(function(data) {
                    $('.modal-body').html(data).fadeIn(); // load response
                    $('#modal-loader').hide();
                    $('#ref_no').focus();
                    _modalFormValidation();
                })
                .fail(function(data) {
                    $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
                    $('#modal-loader').hide();
                });
        });
    };



    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatableSelect();
            _componentRemoteModalLoad();
            _componentSelect2Normal();
            _componentDatePicker();
            _formValidation();
            _classformValidation();
            _componentDropFile();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableSelect.init();
});

$('#close').click(function() {
    $('#content_form')[0].reset();
    $('#create').collapse("hide");
    $('#list').collapse("show");
});
$('#list').collapse("show");
$('#amount').val(0);
$('#interest').val(0);
$('#payable').val(0);
var amount = 0;
var interest = 0;
var per = 0;
$('#interest').keyup(function() {
    interest = parseInt($(this).val());
    amount = parseInt($('#amount').val());
    per = (amount * interest) / 100;
    var result = amount + per;
    $('#payable').val(result);
});

$('#amount').keyup(function() {
    amount = parseInt($(this).val());
    interest = parseInt($('#interest').val());
    per = (amount * interest) / 100 ;
    var result = amount + per;
    $('#payable').val(result);
});