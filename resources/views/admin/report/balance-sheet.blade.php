@extends('layouts.main', ['title' => (' Balance Sheet Report'), 'modal' => 'xl',])

@push('admin.css')

@endpush

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Balance Sheet Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fa fa-home"
                                                                                    aria-hidden="true"></i></a></li>
                        <li class="breadcrumb-item active"> Balance Sheet Report</li>
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
                <h3 class="card-title">Balance Sheet Report Show</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div id="print_table" style="color:black">
                <span class="text-center">
                    <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
                    <h5> {{ get_option('description') }} </h5>
                    <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>

                </span>
                    <div class="text-center col-md-12">
                        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
                            class="bg-success text-light">
                            <b>Balance Sheet Report</b></h4>
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

                    <div class="row">

                        {{-- Liabilities --}}
                        <div class="col-md-6">
                            <h3 class="text-center">Liabilities</h3>
                            <hr style="border: 1px solid green">

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-sm">
                                    <tbody>
                                    @php
                                        $total_liabilites = 0;
                                    @endphp
                                    @foreach($liabilities as $key=>$v)
                                        @php

                                            $total_liabilites += $v;
                                        @endphp
                                        <tr>
                                            <td>{{ toWord($key) }}</td>
                                            <td class="text-right">{{ number_format($v, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>&nbsp</td>
                                        <td>&nbsp</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp</td>
                                        <td>&nbsp</td>
                                    </tr>
                                    {{--<tr>
                                        <td>&nbsp</td>
                                        <td>&nbsp</td>
                                    </tr>--}}
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Liabilities (Total)</th>
                                        <th class="text-right"> {{ number_format($total_liabilites, 2) }}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                        {{-- Assets --}}
                        <div class="col-md-6">
                            <h3 class="text-center">Assets</h3>
                            <hr style="border: 1px solid green">

                            <div class="table-responsive ">
                                <table class="table table-hover table-bordered table-sm">
                                    <tbody>
                                    @php
                                        $total_asset = 0;
                                    @endphp
                                    @foreach($asset as $key=>$v)
                                        @php
                                            $total_asset += $v;
                                        @endphp
                                        <tr>
                                            <td>{{ toWord($key) }}</td>
                                            <td class="text-right">{{ number_format($v, 2) }}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Assets (Total)</th>
                                        <th class="text-right">{{number_format($total_asset, 2)}}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
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
