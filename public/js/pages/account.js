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
                targets: [3]
            }],

            order: [0, 'asc'],
            processing: true,
            serverSide: true,

            ajax: $('.content_managment_table').data('url'),
            columns: [
                // { data: 'checkbox', name: 'checkbox' },
                {
                    data: 'DT_RowIndex',
                    name: 'id'
                }, {
                    data: 'category',
                    name: 'category'
                }, {
                    data: 'count',
                    name: 'count'
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
                    $('#customer_name').focus();
                    _modalFormValidation();
                    _componentDatePicker();
                    _componentSelect2Normal();
                })
                .fail(function(data) {
                    $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
                    $('#modal-loader').hide();
                });
        });
    };



    // Account Script

    $(document).on('change', '#category', function () {
        var value = $(this).val();
        if (value == 'Bank_Account') {

             $("#alias").val('');
             $("#phone").val('');
             $("#email").val('');
             $("#salary").val('');
             $("#address").val('');
             $("#display_name").val('');
             $("#account_no").val('');
             $("#check_form").val('');
             $("#check_to").val('');
             
            $('#display').show();
            $('#alias_show').hide();
            $('.bank_show').show(500);
            $('.customer_show').hide(500);
            $('#account').html('Bank Name');
            $("#bank_name").prop('required', true);
            $("#account_no").prop('required', true);
            $("#check_form").prop('required', true);
            $("#check_to").prop('required', true);
            $("#alias").prop('required', false);
            $("#opening_date").prop('required', false);
            $("#phone").prop('required', false);
            $("#email").prop('required', false);
        } else if (value == 'Employee') {

             $("#alias").val('');
             $("#phone").val('');
             $("#email").val('');
             $("#salary").val('');
             $("#address").val('');
             $("#display_name").val('');
             $("#account_no").val('');
             $("#check_form").val('');
             $("#check_to").val('');

            $('.bank_show').hide(500);
            $('.customer_show').show(500);
            $('#display').hide();
            $('#account').html('Employee Name');
            $('#alias_show').show();
            $("#phone").prop('required', true);
            // $("#email").prop('required', true);
            $("#display_name").prop('required', false);
            $("#account_no").prop('required', false);
            $("#check_form").prop('required', false);
            $("#check_to").prop('required', false);
        } else {

             $("#alias").val('');
             $("#phone").val('');
             $("#email").val('');
             $("#salary").val('');
             $("#address").val('');
             $("#display_name").val('');
             $("#account_no").val('');
             $("#check_form").val('');
             $("#check_to").val('');


            $('#display').show();
            $('#alias_show').show();
            $('.bank_show').hide(500);
            $('.customer_show').hide(500);
            $('#account').html('Account Name');
            $("#bank_name").prop('required', false);
            $("#account_no").prop('required', false);
            $("#check_form").prop('required', false);
            $("#check_to").prop('required', false);
            $("#phone").prop('required', false);
            $("#email").prop('required', false);

           
        }

    });



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

