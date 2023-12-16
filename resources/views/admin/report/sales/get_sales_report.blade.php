    <div id="print_table" class="card-body">
        <span class="text-center">
            <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
            <h5> {{ get_option('description') }} </h5>
            <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
        
        </span>
        <div class="text-center col-md-12">
            <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
                class="bg-success text-light">
                <b>@lang('Sale Register Report')</b></h4>
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
            <h6 class="text-center">{{formatDate($sdate)}} -  {{formatDate($edate)}} </h6>
            <table class="table table-hover table-bordered content_managment_table table-sm">
                <thead class="table-info">
                    <tr>
                        <th width="15%">Customer</th>
                        <th width="13%" >Reference</th>
                        <th width="12%">Date</th>
                        <th width="12%">Total</th>
                        <th width="12%">Discount Amt</th>
                        <th width="12%">Net Total</th>
                        <th width="12%">Paid</th>
                        <th width="12%">Due</th>
                        {{-- <th>Colsing Balance</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($models as $element)
                    <tr>
                        <td>{{ $element->customer?$element->customer->customer_name:'' }}</td>
                        <td><a data-url ="{{ route('admin.sale_voucher.sale.show',$element->id) }}" id="btn_modal" style="cursor: pointer;">{{ $element->reference_no }}</a></td>
                        <td>{{ $element->date }}</td>
                        <td>{{ number_format($element->sub_total, 2) }} {{ get_option('currency_symbol') }}</td>
                        <td>{{ number_format($element->discount_amount, 2) }} {{ get_option('currency_symbol') }}</td>
                        <td>{{ number_format($element->net_total) }} {{ get_option('currency_symbol') }}</td>
                        <td>{{ number_format($element->paid, 2) }} {{ get_option('currency_symbol') }}</td>
                        <td>{{ number_format($element->due, 2) }} {{ get_option('currency_symbol') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th class="text-right" colspan="3">Total</th>
                    <th>{{ get_option('currency_symbol') }} {{ $models->sum('sub_total') }}</th>
                    <th>{{ get_option('currency_symbol') }} {{ $models->sum('discount_amount') }}</th>
                    <th>{{ get_option('currency_symbol') }} {{ $models->sum('net_total') }}</th>
                    <th>{{ get_option('currency_symbol') }} {{ $models->sum('paid') }}</th>
                    <th>{{ get_option('currency_symbol') }} {{ $models->sum('due') }}</th>
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

    <script>
        function printContent(el) {
            console.log('print clicked');
    
            var a = document.body.innerHTML;
            var b = document.getElementById(el).innerHTML;
            document.body.innerHTML = b;
            window.print();
            document.body.innerHTML = a;
    
        }
    </script>
    