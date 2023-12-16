@extends('layouts.main', ['title' => 'Homepage','modal'=>'xl'])
@push('admin.css')
    <style>
        #dashbord_bg {
            background-image: url('{{ asset('images/bg.png') }}');
            padding: 50px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .btn-app {
            min-width: 100% !important;
            height: 106px;
            font-size: 27px;
        }

    </style>
@endpush

@section('header')

    <div class="btn-group btn-group-justified ml-3">
        <a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i
                class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
        <a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club"
                                                                                       aria-hidden="true"></i>@lang('Today')
        </a>
        <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank"
           class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play"
                                                           aria-hidden="true"></i>@lang('Tutorial')</a>
        <a href="https://sattit.com/" target="_blank" class="btn btn-light border-right ml-2 py-0"><i
                class="fa fa-question-circle" aria-hidden="true"></i>@lang('Help')</a>
    </div>
    {{--
        <div class="content">
            <div class="bg-success py-2">
                <div class="btn-group btn-group-justified ml-3">
                    <a href="{{ route('admin.general.settings') }}" class="btn btn-info rounded ml-2 py-1 px-2 "><i
                            class="fa fa-cog fa-spin" aria-hidden="true"></i> &nbsp; @lang('Setting')</a>
                    <a href="{{ route('today') }}" class="btn btn-light  rounded ml-2 py-1 px-2"><i
                            class="fa fa-cc-diners-club"
                            aria-hidden="true"></i> &nbsp; @lang('Today')
                    </a>
                    <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank"
                       class="btn btn-warning  rounded ml-2 py-1 px-2"><i class="fa fa-youtube-play"
                                                                          aria-hidden="true"></i> &nbsp; @lang('Tutorial')
                    </a>
                    <a href="https://sattit.com/" target="_blank" class="btn btn-secondary  rounded ml-2 py-1 px-2 "><i
                            class="fa fa-question-circle" aria-hidden="true"></i> &nbsp; @lang('Help')</a>
                </div>
            </div>
        </div>--}}

@endsection
@section('content')
    <div id="dashbord_bg">
        <div class="box">

            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Sales</span>
                            <span
                                class="info-box-number total_sell">{{ get_option('currency_symbol') }} {{ number_format(App\Transaction::where('transaction_type', 'Sale')->sum('net_total'), 2)}} </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="ion ion-cash"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total purchase</span>
                            <span
                                class="info-box-number total_purchase">{{ get_option('currency_symbol') }} {{ number_format(App\Transaction::where('transaction_type', 'Purchase')->sum('net_total'), 2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                    <span class="info-box-icon bg-yellow">
                        <i class="fa fa-dollar"></i>
                        <i class="fa fa-exclamation"></i>
                    </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Purchase due</span>
                            <span
                                class="info-box-number purchase_due">{{ get_option('currency_symbol') }} {{ number_format(App\Transaction::where('transaction_type', 'Purchase')->sum('due'), 2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <!-- <div class="clearfix visible-sm-block"></div> -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                    <span class="info-box-icon bg-blue">
                        <i class="ion ion-ios-paper-outline"></i>
                        <i class="fa fa-exclamation"></i>
                    </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Invoice due</span>
                            <span
                                class="info-box-number invoice_due">{{ get_option('currency_symbol') }} {{number_format( App\Transaction::where('transaction_type', 'Sale')->sum('due'), 2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>


                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                    <span class="info-box-icon bg-warning">
                        <i class="fa fa-dollar"></i>
                    </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Income</span>


                            <span
                                class="info-box-number invoice_due">{{ get_option('currency_symbol') }} {{number_format(account_calculation('Direct_Income', 'Credit') - account_calculation('Direct_Income', 'Debit'), 2)}}</span>

                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>


                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="ion ion-cash"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Expence</span>

                            <span
                                class="info-box-number invoice_due">{{ get_option('currency_symbol') }} {{number_format(account_calculation('Direct_Expanses', 'Credit') - account_calculation('Direct_Expanses', 'Debit'), 2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>


                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                    <span class="info-box-icon bg-warning">
                        <i class="fa fa-dollar"></i>
                    </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Loan Received</span>

                            <span
                                class="info-box-number invoice_due">{{ get_option('currency_symbol') }} {{number_format(account_calculation('Unsecured_Loans', 'Credit'), 2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>


                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="ion ion-cash"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Loan Pay</span>

                            <span
                                class="info-box-number invoice_due">{{ get_option('currency_symbol') }} {{number_format(account_calculation('Unsecured_Loans', 'Debit'), 2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">

                <div class="col-md-12">
                    <h4 class="text-center bg-light">Vehicle Section</h4>
                </div>
                <div class="col-md-3 ">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Investment</span>
                            <span
                                class="info-box-number total_sell">{{ get_option('currency_symbol') }} {{ number_format(App\Models\Vehicle\Vehicle::sum('investment'), 2)}} </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 ">
                    <div class="info-box">
                     <span class="info-box-icon bg-yellow">
                        <i class="fa fa-dollar"></i>
                    </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Income</span>
                            <span
                                class="info-box-number ">{{ get_option('currency_symbol') }} {{ number_format(App\Models\Vehicle\VehicleTransaction::where('type', 'Income')->sum('amount'), 2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <!-- /.col -->
                <div class="col-md-3 ">
                    <div class="info-box">

                        <span class="info-box-icon bg-info"><i class="ion ion-cash"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Expence</span>
                            <span
                                class="info-box-number ">{{ get_option('currency_symbol') }} {{number_format(App\Models\Vehicle\VehicleTransaction::where('type', 'Expence')->sum('amount'), 2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <!-- <div class="clearfix visible-sm-block"></div> -->
                <div class="col-md-3 ">
                    <div class="info-box">
                    <span class="info-box-icon bg-blue">
                        <i class="ion ion-ios-paper-outline"></i>
                        <i class="fa fa-exclamation"></i>
                    </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Current Balance</span>
                            @php

                                $invest =  App\Models\Vehicle\Vehicle::sum('investment');
                                $income =  App\Models\Vehicle\VehicleTransaction::where('type', 'Income')->sum('amount');
                                $expence = App\Models\Vehicle\VehicleTransaction::where('type', 'Expence')->sum('amount');
                                $balance = $income -($invest + $expence);

                            @endphp
                            <span
                                class="info-box-number ">{{ get_option('currency_symbol') }} {{number_format($balance, 2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="sales_chart"></div>
                                    <div class="text-center">
                                        <a href="{{ route('admin.sale_voucher.sale.index') }}" class="btn btn-info"><i
                                                class="fa fa-list"></i>List</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="purchase_chart"></div>
                                    <div class="text-center">
                                        <a href="{{ route('admin.pur_voucher.purchase.index') }}"
                                           class="btn btn-warning"><i
                                                class="fa fa-list"></i>List</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="payment_chart"></div>
                                    <div class="text-center">
                                        <a href="{{ route('admin.Payment_account') }}" class="btn btn-success"><i
                                                class="fa fa-list"></i>List</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12 card" id="monthwise_chart"></div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12 card" id="hotproduct_chart"></div>
            </div>


            <div class="row">
                <!-- Recently Purchase -->
                <div class="col-md-12 table-responsive">
                    <h4 class="text-center bg-light">Recently Purchase Order</h4>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Ref. No</th>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        @php
                            $query = App\Transaction::where('transaction_type', 'Purchase')->orderBy('id',
                            'desc')->limit(5)->get();
                        @endphp
                        @if (count($query))
                            @foreach ($query as $item)
                                <tr>
                                    <td>{{ formatDate($item->date) }}</td>
                                     <td><a style="color: white; cursor: pointer;" data-url ="{{ route('admin.pur_voucher.purchase.show',$item->id) }}" id="btn_modal">{{ $item->reference_no }}</a>
                                    </td>
                                    <td>{{ $item->supplier->sup_name }}</td>
                                    <td>
                                        @if ($item->payment_status == 'paid')
                                            <span class="badge badge-success">Paid</span>
                                        @else
                                            <span class="badge badge-danger">Due</span>
                                        @endif
                                    </td>
                                    <td>{{ get_option('currency_symbol') }} {{ number_format($item->net_total) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="5">No Purchase Information Found !</td>
                            </tr>
                        @endif
                        <tfoot>
                        <tr>
                            <td class="text-center" colspan="5">
                                <a href="{{ route('admin.pur_voucher.purchase.create') }}">
                                    <button type="button"
                                            class="btn btn-sm btn-info"><i class="fa fa-plus mr-2"></i> ADD PURCHASE
                                    </button>
                                </a>
                                <a href="{{ route('admin.pur_voucher.purchase.index') }}">
                                    <button type="button"
                                            class="btn btn-sm btn-success"><i class="fa fa-list mr-2"></i> PURCAHSE
                                        LIST
                                    </button>
                                </a>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Recently Sell -->
                <div class="col-md-12 table-responsive">
                    <h4 class="text-center bg-light">Recently Sale Order</h4>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Ref. No</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        @php
                            $query = App\Transaction::where('transaction_type', 'Sale')->orderBy('id', 'desc')->limit(5)->get();
                        @endphp
                        @if (count($query))
                            @foreach ($query as $item)
                                <tr>
                                    <td>{{ formatDate($item->date) }}</td>
                                    <td><a style="color: white; cursor: pointer;" data-url ="{{ route('admin.sale_voucher.sale.show',$item->id) }}" id="btn_modal">{{ $item->reference_no }}</a>
                                    </td>
                                    <td>{{ $item->customer->customer_name }}</td>
                                    <td>
                                        @if ($item->payment_status == 'paid')
                                            <span class="badge badge-success">Paid</span>
                                        @else
                                            <span class="badge badge-danger">Due</span>
                                        @endif
                                    </td>
                                    <td>{{ get_option('currency_symbol') }} {{ number_format($item->net_total) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="5">No Sale Information Found !</td>
                            </tr>
                        @endif
                        <tfoot>
                        <tr>
                            <td class="text-center" colspan="5">
                                <a href="{{ route('admin.sale_voucher.sale.create',['sale_type'=>'retail']) }}">
                                    <button
                                        type="button" class="btn btn-sm btn-info"><i class="fa fa-plus mr-2"></i>
                                        Retail
                                        SALE
                                    </button>
                                </a>
                                <a href="{{ route('admin.sale_voucher.sale.create',['sale_type'=>'wholesale']) }}">
                                    <button
                                        type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i>
                                        Whole SALE
                                    </button>
                                </a>
                                <a href="{{ route('admin.sale_voucher.sale.index') }}">
                                    <button type="button"
                                            class="btn btn-sm btn-success"><i class="fa fa-list mr-2"></i> SALE LIST
                                    </button>
                                </a>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Stock Low Product -->
                <div class="col-md-12 table-responsive">
                    <h4 class="text-center bg-light">Low Stock Product</h4>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>P. Name</th>
                            <th>P. Code</th>
                            <th>C. Price</th>
                            <th>S. Price</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        @php
                            $query = App\Models\Products\Product::orderBy('stock', 'asc')->limit(5)->get();
                        @endphp
                        @if (count($query))
                            @foreach ($query as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->product_code }}
                                    </td>
                                    <td>{{ get_option('currency_symbol') }}{{ number_format($item->product_cost, 2) }}</td>
                                    <td>
                                        {{ get_option('currency_symbol') }} {{ number_format($item->product_price, 2) }}
                                    </td>
                                    <td>{{ $item->stock }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="5">No Product Information Found !</td>
                            </tr>
                        @endif
                    </table>
                </div>


            </div>

            {{-- <div class="row">

                <div class="col-md-4">
                    <div class="card py-4 px-3 text-center bg-light shadow">
                        <a href="{{ route('admin.account.index') }}" class="">
                            <p class="h2"> <i class="fa fa-id-card-o" aria-hidden="true"></i> </p>
                            @lang('All Account')
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card py-4 px-3 text-center bg-light shadow">
                        <a href="{{ route('admin.vaucher.index') }}" class="">
                            <p class="h2"> <i class="fa fa-credit-card-alt" aria-hidden="true"></i> </p>
                            @lang('Account Voucher')
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card py-4 px-3 text-center bg-light shadow">
                        <a href="{{ route('admin.customer.index') }}" class="">
                            <p class="h2"> <i class="fa fa-address-card-o" aria-hidden="true"></i> </p>
                            @lang('Customer')
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card py-4 px-3 text-center bg-light shadow">
                        <a href="{{ route('admin.supplier.index') }}" class=" ">
                            <p class="h2"> <i class="fa fa-address-card" aria-hidden="true"></i> </p> @lang('Supplier')
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card py-4 px-3 text-center bg-light shadow">
                        <a href="{{ route('admin.products.products.index') }}" class=" ">
                            <p class="h2"> <i class="fa fa-area-chart" aria-hidden="true"></i> </p> @lang('Items')
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card py-4 px-3 text-center bg-light shadow">
                        <a href="{{ route('admin.pur_voucher.purchase.create') }}" class=" ">
                            <p class="h2"> <i class="fa fa-bath" aria-hidden="true"></i> </p> @lang('Purchase Voucher')
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card py-4 px-3 text-center bg-light shadow">
                        <a href="{{ route('admin.sale_voucher.sale.create',['sale_type'=>'retail']) }}" class=" ">
                            <p class="h2"> <i class="fa fa-bath" aria-hidden="true"></i> </p> @lang('Retail Sale')
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card py-4 px-3 text-center bg-light shadow">
                        <a href="{{ route('admin.sale_voucher.sale.create',['sale_type'=>'wholesale']) }}" class=" ">
                            <p class="h2"> <i class="fa fa-bath" aria-hidden="true"></i> </p> @lang('Whole Sale')
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card py-4 px-3 text-center bg-light shadow">
                        <a href="{{ route('admin.sale_voucher.return.create') }}" class=" ">
                            <p class="h2"> <i class="fa fa-retweet" aria-hidden="true"></i> </p> @lang('Sale Return')
                        </a>
                    </div>
                </div>
            </div> --}}


        </div>


        @endsection

        {{--  --}}
        @php
            // find the first day of the month
            $start = Carbon\Carbon::parse('first day of this month');
            $first_day = $start->format('d');
            // $start = $start->format('Y-m-d');

            // find the last day of the month
            $end = Carbon\Carbon::parse('last day of this month');
            $last_day = $end->format('d');

            $date = [];
            $total_sale = [];
            $total_purchase = [];
            for ($first_day = $start->format('d'); $first_day <= $last_day; $first_day++) {
                $date[] = $first_day;
                $full_day = date('Y-m-').$first_day;

                $total_sale[] = App\Transaction::where('transaction_type', 'Sale')->whereDate('date', $full_day)->sum('net_total');
                $total_purchase[] = App\Transaction::where('transaction_type', 'Purchase')->whereDate('date', $full_day)->sum('net_total');
                // $amount[] = $total;
            }

            // dd($date);
            $sale_amount_string = implode(', ',$total_sale);
            // dd($sale_amount_string);
            $purchase_amount_string = implode(', ',$total_purchase);
            $date_string = implode(', ',$date);
        @endphp

        @push('admin.scripts')
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            <script>
                var options = {
                    series: [{
                        name: "Sale",
                        data: [{{ $sale_amount_string }}]
                    }, {
                        name: "Purchase",
                        data: [{{ $purchase_amount_string }}]
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    toolbar: {
                        show: true
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    title: {
                        text: 'SALE VS PURCHASE THIS MONTH - {{date("F")}}',
                        align: 'center'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'],
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: [{{ $date_string }}],
                    }
                };

                var chart = new ApexCharts(document.querySelector("#monthwise_chart"), options);
                chart.render();


                var options = {
                    series: [{
                        name: 'Sale Qty',
                        data: [{{ implode(',',$selling_quantity) }}]
                    }],
                    annotations: {
                        points: [{
                            x: 'Hot Product',
                            seriesIndex: 0,
                            label: {
                                borderColor: '#775DD0',
                                offsetY: 0,
                                style: {
                                    color: '#fff',
                                    background: '#775DD0',
                                },
                                // text: 'Bananas are good',
                            }
                        }]
                    },
                    chart: {
                        height: 350,
                        type: 'bar',
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '50%',
                            endingShape: 'rounded'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2
                    },

                    title: {
                        text: 'Hot Product - {{date("F")}}',
                        align: 'center'
                    },

                    grid: {
                        row: {
                            colors: ['#fff', '#f2f2f2']
                        }
                    },
                    xaxis: {
                        labels: {
                            rotate: -45
                        },
                        categories: [{!! implode(',',$top_product_name) !!}
                        ],
                        tickPlacement: 'on'
                    },
                    yaxis: {
                        title: {
                            text: 'Sale quantity',
                        },
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: "horizontal",
                            shadeIntensity: 0.25,
                            gradientToColors: undefined,
                            inverseColors: true,
                            opacityFrom: 0.85,
                            opacityTo: 0.85,
                            stops: [50, 0, 100]
                        },
                    }
                };

                var chart = new ApexCharts(document.querySelector("#hotproduct_chart"), options);
                chart.render();
                //.............

                var options = {
                    series: [{
                        name: "Sale Total",
                        data: [{{ $lastSevenDaySells }}]
                    }],
                    chart: {
                        height: 250,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    title: {
                        text: 'Last 7 Day Sale',
                        align: 'left'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: [{!! $daynames !!}],
                    }
                };

                var chart = new ApexCharts(document.querySelector("#sales_chart"), options);
                chart.render();

                //.............

                var options = {
                    series: [{
                        name: "Purchase Total",
                        data: [{{ $lastSevenDayPurchases }}]
                    }],
                    chart: {
                        height: 250,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    title: {
                        text: 'Last 7 Day Purchase',
                        align: 'left'
                    },
                    grid: {
                        row: {
                            colors: ['#32CD32', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: [{!! $daynames !!}],
                    }
                };

                var chart = new ApexCharts(document.querySelector("#purchase_chart"), options);
                chart.render();

                //.............

                var options = {
                    series: [{
                        name: "Payment Total",
                        data: [{{ $lastSevenDayTransactions }}]
                    }],
                    chart: {
                        height: 250,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    title: {
                        text: 'Last 7 Day Payment',
                        align: 'left'
                    },
                    grid: {
                        row: {
                            colors: ['#f00', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: [{!! $daynames !!}],
                    }
                };

                var chart = new ApexCharts(document.querySelector("#payment_chart"), options);
                chart.render();
            </script>
    @endpush



