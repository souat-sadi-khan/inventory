@extends('layouts.main', ['title' => ('Unique Supplier Report'), 'modal' => 'xl',])

@push('admin.css')
<link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Unique Supplier Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fa fa-home"
                                aria-hidden="true"></i></a></li>
                    <li class="breadcrumb-item active">Unique Supplier Report</li>
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
            <h3 class="card-title">Unique Supplier Report</h3>
        </div>
        <!-- /.card-header -->
        <div id="print_table" class="card-body">
            <span class="text-center">
                <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
                <h5>  {{$supplier->sup_name}}  Report </h5>
                <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
            
            </span>
            <div class="text-center col-md-12">
                <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
                    class="bg-success text-light">
                    <b> {{$supplier->sup_name}}  Report</b></h4>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
        
                                <p style="margin:0px ; margin-top: -8px;">
        
                                    Report Of Date : <span class="ml-1">{{ formatDate(date('Y-m-d'))}}</span>
        
                                </p>
        
                            </td>
                            <td class="text-center">
        
                            </td>
                            <td class="text-right">
                                <p style="margin:0px ; margin-top: -8px;">Printing Date :
                                    <span></span> {{ date('d F, Y') }} </span></p>
                                <p style="margin:0px ; margin-top: -4px;">Time :
                                    <span></span>{{date('h:i:s A')}}</span></p>
                            </td>
                        </tr>
        
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered content_managment_table">
                    <thead class="table-info">
                        <tr>
                            <th width="15%">Reff. No</th>
                            <th width="15%" class="text-center">Date</th>
                            <th width="15%" class="text-right">Type</th>
                            <th width="25%" class="text-right">Debit</th>
                            <th width="25%" class="text-right">Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t_debit = 0;
                            $t_credit = 0;
                        @endphp
                        @foreach ($data as $model)
                        @php
                           $t_debit += $model['Debit'];
                           $t_credit += $model['Credit'];
                        @endphp
                            <tr>
                                <td>{{ $model['Ref'] }}</td>
                                <td>{{ $model['Date'] }}</td>
                                <td class="text-right">{{ $model['Type'] }}</td>
                                <td class="text-right">{{ get_option('currency_symbol') }}{{ number_format($model['Debit'], 2) }}</td>
                                <td class="text-right">{{ get_option('currency_symbol') }}{{ number_format($model['Credit'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="3">Total</th>
                            <th class="text-right">{{ get_option('currency_symbol') }}{{ number_format($t_debit, 2) }}</th>
                            <th class="text-right">{{ get_option('currency_symbol') }}{{ number_format($t_credit, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <br>
            {{-- <h5>In Words: {{ucwords($in_words)}} Taka Only.</h5> --}}
            <br><br><br>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-4 text-center">
                    <hr class="border-dark">
                    <p> Chief Cashier </p>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4 text-center">
                    <hr class="border-dark">
                    <p> Manager </p>
                </div>
                <div class="col-md-1"></div>


            </div>
        </div>
        
        <!-- /.card-body -->
    </div>

    <div class="text-center mb-3">


        @php
        $print_table = 'print_table';

        @endphp

        <a class="text-light btn-primary btn" onclick="printContent('{{ $print_table }}')" name="print"
            id="print_receipt">
            <i class="fa fa-print" aria-hidden="true"></i>
            Print Report

        </a>
    </div>
    <!-- /.card -->
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
