@extends('layouts.main', ['title' => ('Supplier Manage'), 'modal' => 'xl',])
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
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Supplier Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fa fa-home"
                    aria-hidden="true"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('admin.supplier.index') }}">Supplier</a></li>
                    <li class="breadcrumb-item active">{{ $model->sup_name }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Supplier Full View Information :: {{ $model->sup_name }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                {{-- Profile --}}
                <div class="col-md-12">
                    <div class="card card-widget widget-user">
                        <div class="bg-success p-2 rounded-top">
                            <div class="row">
                                <div class="col-md-3 text-">
                                    <div class="img-box rounded-circle">
                                        <img style="height: 70px; width:70px " class="img-circle elevation-2"
                                             src="{{ asset('images/supp.png') }}" alt="Supplier Image">
                                    </div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <p class="widget-user-username">{{ $model->sup_name }}</p>
                                    <h6 class="widget-user-desc">Since {{ formatDate($model->created_at) }}</h6>
                                </div>
                                <div class="col-md-3 text-right">
                                    <h5 class="description-header">{{ $model->transaction()->where('transaction_type','Purchase')->count() }}</h5>
                                    <span class="description-text">INVOICE</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4>Contact Information</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light p-1 py-2">

                                    <h6 class="text-center">Mobile : {{ $model->sup_mobile }} </h6>

                                    <h6 class="text-center">Email : {{ $model->sup_email }} </h6>

                                    <h6 class="text-center">Address : {{ $model->sup_address }} </h6>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light p-1 py-2">
                                    <h6 class="text-center">City : {{ $model->sup_city }} </h6>
                                    <h6 class="text-center">State : {{ $model->sup_state }} </h6>
                                    <h6 class="text-center">Country : {{ $model->sup_country }} </h6>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                {{-- Balance --}}
                <div class="col-md-12">
                    <div class="info-box p-0">

                        <div class="info-box-content">
                            <h4 class="info-box-text text-center bg-success py-2">CURRENT BALANCE</h4>

                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="card bg-success py-3">
                                        <strong>@lang('Total Purchase')</strong>
                                        <p class="text-light mb-0">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $model->total_purchase }} {{ get_option('currency_symbol') }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info py-3">
                                        <strong>@lang('Total Purchase Paid')</strong>
                                        <p class="text-light mb-0">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $model->purchase_paid }} {{ get_option('currency_symbol') }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-primary py-3">
                                        <strong>@lang('Purchase Due')</strong>
                                        <p class="text-light mb-0">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $model->total_purchase -$model->purchase_paid }} {{ get_option('currency_symbol') }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning py-3">
                                        <strong>@lang('Total Sale Return')</strong>
                                        <p class="text-light mb-0">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $model->purchase_return }} {{ get_option('currency_symbol') }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-danger py-3">
                                        <strong>@lang('Purchase Return Paid')</strong>
                                        <p class="text-light mb-0">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $model->return_paid }} {{ get_option('currency_symbol') }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-secondary py-3">
                                        <strong>@lang('Purchase Return Due')</strong>
                                        <p class="text-light mb-0">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $model->purchase_return -$model->return_paid }} {{ get_option('currency_symbol') }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success py-3">

                                        @if(!empty($model->opening_balance) && $model->opening_balance != '0.00')
                                            <strong>@lang('Opening Balance')</strong>
                                            <p class="text-light mb-0">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $model->opening_balance }} {{ get_option('currency_symbol') }}</span>
                                            </p>
                                            <strong>@lang('Opening Balance Due')</strong>
                                            <p class="text-light mb-0">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $model->opening_balance - $model->opening_balance_paid }} {{ get_option('currency_symbol') }}</span>
                                            </p>
                                        @endif
                                        @php
                                            $opening =$model->opening_balance - $model->opening_balance_paid;
                                            $sale =$model->total_purchase -$model->purchase_paid;
                                            $return =$model->purchase_return -$model->return_paid;
                                            $balance =$opening+$sale-$return;
                                        @endphp
                                        <strong>@lang('Available Balance')</strong>
                                        <p class="text-light mb-0">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $balance}} {{ get_option('currency_symbol') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>


                            <h6 class="info-box-number text-center">

                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Purchase related Transaction</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped ajax_view" id="purchase_table">
                <thead>
                    <tr>
                        <th>@lang('Date')</th>
                        <th>@lang('Ref')</th>
                        <th>@lang('Supplier')</th>
                        <th style="width: 16%">@lang('Payment Status')</th>
                        <th>@lang('Total Amount')</th>
                        <th>@lang('Total Paid')</th>
                        <th>@lang('Due')</th>
                        <th>@lang('action')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Purchase Return related Transaction</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="purchase_return_datatable">
                <thead>
                    <tr>
                        <th>@lang('Date')</th>
                        <th>@lang('Reference')</th>
                        <th>@lang('Parent Purchase')</th>
                        <th>@lang('Supplier')</th>
                        <th>@lang('Payment Status')</th>
                        <th>@lang('Total')</th>
                        <th>@lang('Due') </th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

        <div class="card">
        <div class="card-header">
            <h3 class="card-title">Payment Related</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped ajax_view" id="ob_payment_table">
                 <thead>
                    <tr>
                        <th>@lang('Reference')</th>
                        <th>@lang('Supplier')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Payment Method')</th>
                        <th>@lang('T.Type')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@push('admin.scripts')
<script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/pages/edit_supplier.js') }}"></script>
<script>

        //Purchase table
    purchase_table = $('#purchase_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'desc']],
        responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
        ajax: '/admin/purchase-voucher/purchase?supplier_id={{ $model->id }}',
        columnDefs: [ {
            "targets": 7,
            "orderable": false,
            "searchable": false
            } ],

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
                }, {
                    data: 'action',
                    name: 'action'
                }
            ]

    });


        //Purchase return table
    purchase_return_table = $('#purchase_return_datatable').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'desc']],
        responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
        ajax: {
            url: '/admin/purchase-voucher/return?supplier_id={{ $model->id }}',

        },
        columnDefs: [ {
            "targets": [7],
            "orderable": false,
            "searchable": false
        } ],
          columns: [
                { data: 'date', name: 'date'  },
                { data: 'reference_no', name: 'reference_no'},
                { data: 'parent_purchase', name: 'parent_purchase'},
                { data: 'suppiler', name: 'supplier'},
                { data: 'payment_status', name: 'payment_status'},
                { data: 'net_total', name: 'net_total'},
                { data: 'payment_due', name: 'payment_due'},
                { data: 'action', name: 'action'}
            ],
    });



    //Opening balance payment
    ob_payment_table = $('#ob_payment_table').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'desc']],
        responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
        ajax: '/admin/supplier/payment-list/{{ $model->id }}',
        columns: [
            { data: 'payment_ref_no', name: 'payment_ref_no'  },
            { data: 'payment_date', name: 'payment_date'  },
            { data: 'amount', name: 'transaction_payments.amount'  },
            { data: 'method', name: 'method' },
            { data: 'transaction_type', name: 'transaction_type' },
            { data: 'action', "orderable": false, "searchable": false },
        ]
    });

</script>
@endpush
