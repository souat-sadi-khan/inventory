<div id="print_table" class="card-body">
    <span class="text-center">
        <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
        <h5> {{ get_option('description') }} </h5>
        <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
    
    </span>
    <div class="text-center col-md-12">
        <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
            class="bg-success text-light">
            <b>@lang('Supplier Report')</b></h4>
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
        {{-- <h6 class="text-center">{{formatDate($sdate)}} -  {{formatDate($edate)}} </h6> --}}
        <table class="table table-hover table-bordered content_managment_table table-sm">
            <thead class="table-info">
                <tr>
                    <th class="text-center" width="20%">Supplier</th>
                    <th class="text-center" width="10%">Invoice</th>
                    <th class="text-center" width="20%">Payable</th>
                    <th class="text-center" width="20%">Paid</th>
                    <th class="text-right" width="10%">Due</th>
                    <th class="text-right" width="10%">Return</th>
                    <th class="text-right" width="10%">Balance</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_balance = 0;
                @endphp
                @foreach ($data as $item)
                @php
                    $balance = $item['Amount'] - $item['Return'];
                    $total_balance += $balance;
                @endphp
                <tr>
                    <td class="text-center"><a target="_blank" href="{{ route('admin.report.supplier-due.unique-supplier', $item['ID'])}} ">{{ $item['Name'] ?$item['Name']:'' }}</a></td>
                    <td class="text-right">{{ $item['Invoice'] }}</td>
                    <td class="text-right">{{ get_option('currency_symbol') }} {{ number_format($item['Payable'], 2) }}</td>
                    <td class="text-right">{{ get_option('currency_symbol') }} {{ number_format($item['Paid'], 2) }}</td>
                    <td class="text-right">{{ get_option('currency_symbol') }} {{ number_format($item['Amount'], 2) }}</td>
                    <td class="text-right">{{ get_option('currency_symbol') }} {{ number_format($item['Return'], 2) }}</td>
                    <td class="text-right">{{ get_option('currency_symbol') }} {{ number_format($item['Return'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="text-right" colspan="2">Total</th>
                <th class="text-right">{{ get_option('currency_symbol') }} {{ number_format($total, 2) }}</th>
                <th class="text-right">{{ get_option('currency_symbol') }} {{ number_format($total_paid, 2) }}</th>
                <th class="text-right">{{ get_option('currency_symbol') }} {{ number_format($total_due, 2) }}</th>
                <th class="text-right">{{ get_option('currency_symbol') }} {{ number_format($total_return, 2) }}</th>
                <th class="text-right">{{ get_option('currency_symbol') }} {{ number_format($total_balance, 2) }}</th>
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

        return window.location.reload(true);

    }
</script>