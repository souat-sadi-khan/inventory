@extends('layouts.main', ['title' => ( $account->name . ' Register'), 'modal' => 'xl',])

@push('admin.css')

@endpush

@section('header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $account->name }} Register</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fa fa-home"
                                aria-hidden="true"></i></a></li>
                    <li class="breadcrumb-item active">{{ $account->name }} Register</li>
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
           <h3>{{ $account->name }} Register Report</h3>
        </div>
        
        <!-- /.card-header -->
        <div id="print_table" class="card-body">
            <span class="text-center">
                <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
                <h5> Company Address Here </h5>
                <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
            
            </span>
            <div class="text-center col-md-12">
                <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
                    class="bg-success text-light">
                    <b>{{ $account->name }} Register Report</b></h4>
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
                <table class="table table-hover table-bordered ">
                    <thead class="table-info">
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Vou Type</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $t_debit = 0;
                            $t_credit = 0;
                        @endphp
                        @foreach ($data as  $item)
                            @php
                                $t_debit += $item['Debit'];
                                $t_credit += $item['Credit'];
                            @endphp
                            <tr>
                                <td class="text-center" >{{ formatDate($item['Date']) }}</td>
                                <td>{{ $item['note'] }} </td>
                                <td class="text-center"> {{  toWord($item['Type']) }}</td>
                                <td class="text-right"> {{ get_option('currency_symbol') }} {{ number_format($item['Debit'], 2) }}</td>
                                <td class="text-right"> {{ get_option('currency_symbol') }} {{ number_format($item['Credit'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="3">Total</th>
                            <th class="text-right">{{ get_option('currency_symbol') }} {{ number_format($t_debit, 2) }}</th>
                            <th class="text-right">{{ get_option('currency_symbol') }} {{ number_format($t_credit, 2) }}</th>
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
        <!-- /.card-body -->
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
