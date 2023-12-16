<!-- Basic initialization -->
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">

            </h3>
            <div class="tile-body">
                <br>
                <hr>

                <div id="print_table" style="color:black">
                    <span class="text-center">
                        <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
                        <h5> {{ get_option('description') }} </h5>
                        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
                    
                    </span>
                    <div class="text-center col-md-12">
                        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
                            class="bg-success text-light">
                            <b>{{$report_type}}</b></h4>
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
                    <div class="tavle-responsice col-md-12">
                        <h6 class="text-center py-2">{{ formatDate($start_date) }}-{{ formatDate($end_date) }} </h6>
                        <table class="table table-bordered table-striped table-sm">
                            <thead class="table-info"> 
                                <tr>
                                    <th>ID</th>
                                    <th>Account</th>
                                    <th>Desc.</th>
                                    <th>Voucher Type</th>
                                    <th>Voucher No</th>
                                    <th class="text-right">Debit</th>
                                    <th class="text-right">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_debit = 0;
                                    $total_credit = 0;
                                @endphp
                                @if (count($data))
                                    @foreach ($data as $item)
                                        @php
                                            $total_debit += $item['Debit'];
                                            $total_credit += $item['Credit'];
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item['Account'] }}</td>
                                            <td>{{ $item['Description'] }}</td>
                                            <td>{{ toWord($item['voucher']) }}</td>
                                            <td>{{ $item['voucher_no'] }}</td>
                                            <td class="text-right">{{ get_option('currency_symbol') }} {{ number_format($item['Debit'], 2) }}</td>
                                            <td class="text-right">{{ get_option('currency_symbol') }} {{ number_format($item['Credit'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                @else 
                                    <tr>
                                        <td colspan="7" class="text-center">No Voucher Found !</td>
                                    </tr>
                                @endif
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="5">Total</th>
                                        <td class="text-right">{{ get_option('currency_symbol') }} {{ number_format($total_debit, 2) }}</td>
                                        <td class="text-right">{{ get_option('currency_symbol') }} {{ number_format($total_credit, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </tbody>
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


                {{-- </div> --}}

            </div>
        </div>
    </div>
</div>
<!-- /basic initialization -->


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
