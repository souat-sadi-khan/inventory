@extends('layouts.main', ['title' => ('Sale Return List'), 'modal' => 'xl',])
@push('admin.css')
<link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}">
<style>
.table th, .table td {
padding: 0.2rem 0.5rem;
}

.btn_modal{
    cursor: pointer !important;
}

</style>
@endpush
@section('header')
    <a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
    <a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club" aria-hidden="true"></i>@lang('Today')</a>
    <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play" aria-hidden="true"></i>@lang('Tutorial')</a>
    <a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle" aria-hidden="true"></i>@lang('Help')</a>
    <a href="{{ route('admin.sale_voucher.sale.index') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-list-alt" aria-hidden="true"></i>@lang('Sale List')</a>
    <a href="{{ route('admin.sale_voucher.sale.create',['sale_type'=>'wholesale']) }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-bath" aria-hidden="true"></i>@lang('Whole Sale')</a>
    <a href="{{ route('admin.sale_voucher.sale.create',['sale_type'=>'retail']) }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-bath" aria-hidden="true"></i>@lang('Retail Sale')</a>
    <a href="{{ route('admin.sale_voucher.return.create') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-retweet" aria-hidden="true"></i>@lang('Return')</a>
    <a href="{{ route('admin.sale_voucher.return.index') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-list-alt" aria-hidden="true"></i>@lang('Return List')</a>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <div id="accordion">
                <div class="card card-primary">
                    <a class="bg-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                            Sale Return List
                            </h4>
                        </div>
                    </a>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.sale_voucher.return.index') }}">
                                <thead>
                                    <tr>
                                        <th>@lang('Date')</th>
                                        <th>@lang('Reference')</th>
                                        <th>@lang('Parent Sale')</th>
                                        <th>@lang('Customer')</th>
                                        <th>@lang('Payment Status')</th>
                                        <th>@lang('Total')</th>
                                        <th>@lang('Due') </th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                <tr class="bg-gray font-17 text-center footer-total">
                                    <td colspan="4"><strong>@lang('Total'):</strong></td>
                                    <td id="footer_payment_status_count"></td>
                                    <td><span class="display_currency" id="footer_purchase_return_total" data-currency_symbol ="true"></span></td>
                                    <td><span class="display_currency" id="footer_total_due" data-currency_symbol ="true"></span></td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection
@push('admin.scripts')
<script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.html5.min.js') }}"></script>
<script>
_componentSelect2Normal();
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
  purchase_return_table = $('.content_managment_table').DataTable({
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
                width: "80px",
                targets: [0]
            }, {
                orderable: false,
                targets: [6,7]
            }],

            order: [0, 'desc'],
            processing: true,
            serverSide: true,
            aaSorting: [[0, 'desc']],
            ajax: $('.content_managment_table').data('url'),
          
            columns: [
                { data: 'date', name: 'date'  },
                { data: 'reference_no', name: 'reference_no'},
                { data: 'parent_purchase', name: 'parent_purchase'},
                { data: 'customer', name: 'customer'},
                { data: 'payment_status', name: 'payment_status'},
                { data: 'net_total', name: 'net_total'},
                { data: 'payment_due', name: 'payment_due'},
                { data: 'action', name: 'action'}
            ],
            "fnDrawCallback": function (oSettings) {
                var total_purchase = sum_table_col($('.content_managment_table'), 'net_total');
                $('#footer_purchase_return_total').text(total_purchase);
                
                $('#footer_payment_status_count').html(__sum_status_html($('.content_managment_table'), 'payment-status-label'));

                var total_due = sum_table_col($('.content_managment_table'), 'payment_due');
                $('#footer_total_due').text(total_due);
                
            },
             createdRow: function( row, data, dataIndex ) {
                $( row ).find('td:eq(4)').attr('class', 'clickable_td');
            }
        });

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
</script>
@endpush