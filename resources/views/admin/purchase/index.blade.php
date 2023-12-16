@extends('layouts.main', ['title' => ('Purchase List'), 'modal' => 'xl',])

@push('admin.css')
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}">
    <style>
        .table th, .table td {
         padding: 0.2rem 0.5rem;
        }
    </style>
@endpush

@section('header')
   <a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
    <a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club" aria-hidden="true"></i>@lang('Today')</a>
    <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play" aria-hidden="true"></i>@lang('Tutorial')</a>
    <a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle" aria-hidden="true"></i>@lang('Help')</a>
    <a href="{{ route('admin.pur_voucher.purchase.create') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-bath" aria-hidden="true"></i>@lang('Purchase')</a>
    <a href="{{ route('admin.pur_voucher.return.create') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-retweet" aria-hidden="true"></i>@lang('Return')</a>
    <a href="{{ route('admin.pur_voucher.return.index') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-list-alt" aria-hidden="true"></i>@lang('Return List')</a>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <label for="supplier_id">Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="form-control select" >
                         <option value="">All</option>
                         @foreach ($suppliers as $element)
                           <option value="{{ $element->id }}">{{ $element->sup_name }}</option>
                         @endforeach
                        
                        </select>
                </div>

                <div class="col-md-4">
                    <label for="created_by">Purchase By</label>
                        <select name="created_by" id="created_by" class="form-control select" >
                            <option value="">All</option>
                         @foreach ($user as $element)
                           <option value="{{ $element->id }}">{{ $element->email }}</option>
                         @endforeach
                        
                        </select>
                </div>

                <div class="col-md-4">
                    <label for="payment_status">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="form-control select" >
                            <option value="">All</option>
                         <option value="paid">Paid</option>
                         <option value="due">Due</option>
                         <option value="partial">Partial</option> 
                        </select>
                </div>

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="accordion">
                <div class="card card-primary">
                    <a class="bg-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Purchase List
                            </h4>
                        </div>
                    </a>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.pur_voucher.purchase.index') }}">
                                    <thead>
                                        <tr>
                                            <th>@lang('Date')</th>
                                            <th>@lang('Ref')</th>
                                            <th>@lang('Supplier')</th>
                                            <th style="width: 16%">@lang('Payment Status')</th>
                                            <th>@lang('Total Amount')</th>
                                            <th>@lang('Total Paid')</th>
                                            <th>@lang('Due')</th>
                                            <th>@lang('Balance')</th>
                                            <th>@lang('action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>@lang('Date')</th>
                                            <th>@lang('Ref')</th>
                                            <th>@lang('Supplier')</th>
                                            <th style="width: 16%">@lang('Payment Status')</th>
                                            <th>@lang('Total Amount')</th>
                                            <th>@lang('Total Paid')</th>
                                            <th>@lang('Due')</th>
                                            <th>@lang('Balance')</th>
                                            <th>@lang('action')</th>
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
    var emran = "";
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
                width: "80px",
                targets: [0]
            }, {
                orderable: false,
                targets: [7]
            }],

            order: [0, 'desc'],
            processing: true,
            serverSide: true,
           ajax: { 
            url: $('.content_managment_table').data('url'),
            data: function(d) {
                d.supplier_id = $('select#supplier_id').val();
                d.created_by = $('select#created_by').val();
                d.payment_status = $('select#payment_status').val();
            },
          },
              columns: [
                // { data: 'checkbox', name: 'checkbox' },
               {
                    data: 'date',
                    name: 'date'
                }, {
                    data: 'reference_no',
                    name: 'reference_no'
                }, {
                    data: 'supplier',
                    name: 'supplier'
                }, {
                    data: 'payment_status',
                    name: 'payment_status'
                }, {
                    data: 'net_total',
                    name: 'net_total'
                }, {
                    data: 'paid',
                    name: 'paid'
                }, {
                    data: 'due',
                    name: 'due'
                },{
                    data: 'return',
                    name: 'return'
                }, {
                    data: 'action',
                    name: 'action'
                }
            ]

        });

      $('select#supplier_id, select#created_by, select#payment_status').on(
        'change',
        function() {
            emran.ajax.reload();
        }
    );
 _componentSelect2Normal();
</script>
@endpush
