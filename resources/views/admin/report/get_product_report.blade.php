    <div id="print_table" class="card-body">
        <span class="text-center">
            <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
            <h5> {{ get_option('description') }} </h5>
            <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
        
        </span>
        <div class="text-center col-md-12">
            <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
                class="bg-success text-light">
                <b>@lang('Product') Report</b></h4>
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
            <table class="table table-hover table-bordered content_managment_table table-sm">
                <thead class="table-info">
                    <tr>
                        <th width="12%">Product Name</th>
                        <th width="10%" >Cost Price</th>
                        {{-- <th>Opening Balance</th> --}}
                        <th width="10%">Sale Price</th>
                        <th width="12%">Opening Stock</th>
                        <th width="15%">Total Purchase</th>
                        <th width="12%">Total Sale</th>
                        <th width="12%">Sale Return</th>
                        <th width="12%">Purchase Return</th>
                        <th width="12%">Stock</th>
                        {{-- <th>Colsing Balance</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @if ($product_id=='all')
                    @foreach ($products as $element)
                    <tr>
                        <td>{{ $element->product_name }}</td>
                        <td>{{ get_option('currency_symbol') }} {{ number_format($element->product_cost,2) }}</td>
                        <td>{{ get_option('currency_symbol') }}{{ number_format($element->product_price, 2) }}</td>
                        <td>{{ $element->opening }}</td>
                        <td>{{ $element->purchase->sum('qty') }}</td>
                        <td>{{ $element->sale_line->sum('quantity') }}</td>
                        <td>{{ $element->sale_line->sum('quantity_returned') }}</td>
                        <td>{{ $element->purchase->sum('quantity_returned') }}</td>
                        <td>{{ $element->stock }}</td>
                    </tr>
                    @endforeach
                    @else
                       <tr>
                        <td>{{ $products->product_name }}</td>
                        <td>{{ get_option('currency_symbol') }} {{ number_format($products->product_cost, 2) }}</td>
                        <td>{{ get_option('currency_symbol') }} {{ number_format($products->product_price, 2) }}</td>
                        <td>{{ $products->opening }}</td>
                        <td>{{ $products->purchase->sum('qty') }}</td>
                        <td>{{ $products->sale_line->sum('quantity') }}</td>
                        <td>{{ $products->stock }}</td>
                    </tr>
                    @endif
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