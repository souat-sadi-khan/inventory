@extends('layouts.main', ['title' => ('Product Purchase'), 'modal' => 'xl',])
@push('admin.css')
<style>
    .bg-gray {
        color: #000 !important;
        background-color: #d2d6de !important;
    }

    .bg-green,
    .callout.callout-success,
    .alert-success,
    .label-success,
    .modal-success .modal-body {
        background-color: #00a65a !important;
    }

    .table th,
    .table td {
        padding: 0.2rem 0.5rem;
    }

    .pos_product_div .form-control {
        padding: 0.1rem 0.65rem;
    }

    .btn-sm,
    .btn-group-sm>.btn {
        padding: 0rem 0.5rem;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #797979;
    }

</style>
@endpush
@section('content')
<div id="print_table">
    <div class="container">
        <div class="row">
            <div class="col-md-2 my-auto">
                <img src="Logo2.png" class="w-100" alt="">
            </div>
            <div class="col-md-12 text-center">
                <p class="h1 mb-0"> মেসার্স জনতা অটো রাইস মিল </p>
                <p class="h1 mb-0"> M/S. Janota Auto Rice Mill</p>
            </div>
            <div class="col-md-12 text-center">
                <div class="border-one">
                    <p class="mb-0 py-1"> লিংক রোড, প্রধান সড়ক, কক্সবাজার । ফোনঃ 01856442024 , মোবাইলঃ 01856442024</p>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <p> ভাউচার নং ঃ {{ $model->reference_no }} </p>
            </div>
            <div class="col-md-4 text-center">
                <span class="h3 border-two rounded-pill py-1 px-2"> Purchase </span>
            </div>
            <div class="col-md-4 text-right">
                <div>
                    <span class="mb-2"> তারিখঃ </span>
                    <table class="table table-bordered d-inline border-0">
                        <tbody>
                            <tr>
                                <td class="py-1">{{ date('d') }}</td>
                                <td class="py-1">{{ date('m') }}</td>
                                <td class="py-1">{{ date('Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-1">
                    <span class=""> বারঃ </span>
                    <table class="table table-bordered d-inline border-0">
                        <tbody>
                            <tr>
                                <td class="py-1"> {{ date('D') }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered border-0">
                    <tbody>
                        <tr>
                            <th class="py-1" scope="row"> খরচের খাত <span class="float-right"> : </span> </th>
                            <td class="py-1"> Opening Balance</td>
                        </tr>
                        <tr>
                            <th class="py-1" scope="row"> নাম / মেসার্স <span class="float-right"> : </span> </th>
                            <td class="py-1">{{ $model->supplier?$model->supplier->sup_name:''}} </td>
                        </tr>
                        <tr class="my-1">
                            <th class="py-1" scope="row"> মোবাইল <span class="float-right"> : </span> </th>
                            <td class="py-1">{{ $model->supplier?$model->supplier->sup_mobile:'' }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-12 text-right">
            <p class="float-right"><b> @lang('Date'):</b> {{ $model->date }}</p>
        </div>
    </div> --}}
    {{-- <div class="row">
        <div class="col-sm-6">
            <b> @lang('Invoice No'):</b> <br>
            <b> @lang('Payment status'):</b> {{ $model->payment_status }}<br>
        </div>
        <div class="col-sm-6">
            <b> @lang('Supplier name'):</b>{{ $model->supplier?$model->supplier->sup_name:''}}<br>
            <b> @lang('Phone') : {{ $model->supplier?$model->supplier->sup_mobile:'' }}</b><br>
    
    
            <br>
    
        </div>
    </div> --}}
    <br>
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h4> @lang('Products') :</h4>
        </div>
        <div class="col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table bg-gray">
                    <tbody>
                        <tr class="bg-green text-light">
                            <th>#</th>
                            <th> @lang('Product')</th>
                            <th> @lang('Quantity')</th>
                            <th> @lang('Unit Price')</th>
                            <th> @lang('Subtotal')</th>
                        </tr>
                        @foreach ($model->purchase as $product)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $product->product->product_name }}</td>
                            <td>{{ $product->qty }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->line_total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h4> @lang('Payment info'):</h4>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table bg-gray">
                    <tbody>
                        <tr class="bg-green text-light">
                            <th>#</th>
                            <th> @lang('Date')</th>
                            <th> @lang('Reference No')</th>
                            <th> @lang('Amount')</th>
                            <th> @lang('Payment mode')</th>
                            <th> @lang('Payment note')</th>
                        </tr>
                        @foreach ($model->payment as $pay)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $pay->payment_date }}</td>
                            <td>{{ $pay->transaction_no }}</td>
                            <td>{{ $pay->amount }}</td>
                            <td>{{ $pay->method }}</td>
                            <td>{{ $pay->note }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table bg-gray">
                    <tbody>
                        <tr>
                            <th> @lang('Total'): </th>
                            <td></td>
                            <td><span class="display_currency pull-right"
                                    data-currency_symbol="true">{{ $model->sub_total }}</span></td>
                        </tr>
                        <tr>
                            <th> @lang('Discount'):</th>
                            <td><b>(-)</b></td>
                            <td><span class="pull-right">{{ $model->discount_amount }} </span></td>
                        </tr>
                        <tr>
                            <th> @lang('Tax'):</th>
                            <td><b>(+)</b></td>
                            <td class="text-right">
                                {{ $model->tax }}
                            </td>
                        </tr>
                        <tr>
                            <th> @lang('Shipping'): </th>
                            <td><b>(+)</b></td>
                            <td><span class="display_currency pull-right"
                                    data-currency_symbol="true">{{ $model->shipping_charges }}</span></td>
                        </tr>
    
                        <tr>
                            <th> @lang('Total Payable'): </th>
                            <td></td>
                            <td><span class="display_currency pull-right">{{ $model->net_total }}</span></td>
                        </tr>
                        <tr>
                            <th> @lang('Total paid'):</th>
                            <td></td>
                            <td><span class="display_currency pull-right"
                                    data-currency_symbol="true">{{ $model->paid }}</span></td>
                        </tr>
                        <tr>
                            <th> @lang('Total remaining'):</th>
                            <td></td>
                            <td><span class="display_currency pull-right"
                                    data-currency_symbol="true">{{ $model->due }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <strong> @lang('Sell note'):</strong><br>
            <p class="well well-sm no-shadow bg-gray p-2">
                {{ $model->transaction_note }}
            </p>
        </div>
        <div class="col-sm-6">
            <strong> @lang('Staff note'):</strong><br>
            <p class="well well-sm no-shadow bg-gray p-2">
                {{ $model->stuff_note }}
            </p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <p> টাকা = <span class="border rounded-pill" style="width: 200px; height: 10px">{{ convert_number_to_words($model->net_total)}}</span></p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-3">
                <span class="font-weight-bold border-three"> হিসাব রক্ষক </span>
            </div>
            <div class="col-md-3 text-center">
                <span class="font-weight-bold border-three"> সুপার ভাইজার </span>
            </div>
            <div class="col-md-3 text-center">
                <span class="font-weight-bold border-three"> ম্যানেজার </span>
            </div>
            <div class="col-md-3 text-right">
                <span class="font-weight-bold border-three"> প্রোপাইটার </span>
            </div>
        </div>
    </div>
</div>

<div class="text-center my-5">


    @php
    $print_table = 'print_table';

    @endphp

    <a class="text-light btn-primary btn" onclick="printContent('{{ $print_table }}')" name="print"
        id="print_receipt">
        <i class="fa fa-print" aria-hidden="true"></i>
        Print Report

    </a>
</div>
@endsection
@push('admin.scripts')
<script>
    function printContent(el) {
        console.log('print clicked');

        var a = document.body.innerHTML;
        var b = document.getElementById(el).innerHTML;
        document.body.innerHTML = b;
        window.print();
        document.body.innerHTML = a;

        return window.location.reload(true);

    }
</script>
@endpush
