
    <div class="row">
        <div class="col-md-12 text-right">
            <p class="float-right"><b> @lang('Date'):</b></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <b> @lang('Invoice No'):</b> <br>
            <b> @lang('Payment status'):</b> {{ $model->payment_status }}<br>
        </div>
        <div class="col-sm-6">
            <b> @lang('Supplier name'):</b>{{ $model->supplier?$model->supplier->sup_name:''}}<br>
            <b> @lang('Phone') : {{ $model->supplier?$model->supplier->sup_mobile:'' }}</b><br>


            <br>

        </div>
    </div>
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