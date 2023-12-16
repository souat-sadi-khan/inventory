@extends('layouts.main', ['title' => ( 'Vehicle'. $type. ' Report'), 'modal' => 'xl',])

@push('admin.css')

@endpush

@section('header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Vehicle {{$type}} Report</h1>
            </div>
            <div class="col-sm-6">
                
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
           <h3>Vehicle {{$type}} Report</h3>
        </div>
        
        <!-- /.card-header -->
        <div id="print_table" class="card-body">
            <span class="text-center">
                <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
                <h5> {{ get_option('description') }} </h5>
                <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
            
            </span>
            <div class="text-center col-md-12">
                <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
                    class="bg-success text-light">
                    <b>Vehicle {{$type}} Report</b></h4>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-sm">
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
                <table class="table table-hover table-bordered table-sm">
                    <thead class="table-info">
                        <tr>
                            <th >S/L</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Vehicle</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Description</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($total_income as  $model)
                            @php
                                $amt = $model->amount ;
                                $total += $amt;
                            @endphp
                            <tr>
                                <td >{{ $loop->index + 1 }}</td>
                                <td >{{ formatDate($model->date) }}</td>
                                <td > {{ $model->name }} </td>
                                <td class="text-center"> {{  $model->truck->type->name }}</td>
                                <td class="text-center">  {{ $model->description }}</td>
                                <td class="text-right"> {{ get_option('currency_symbol') }} {{ number_format($amt, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="5">Total</th>
                            <th class="text-right">{{ get_option('currency_symbol') }} {{ number_format($total, 2) }}</th>
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
