      <div class="row">
        @if(!empty($model->return_parent))
        <div class="col-sm-6 col-xs-6">
            <h4>@lang('Sale Return Details'):</h4>
            <strong>@lang('Return Date'):</strong> {{$model->return_parent->date}}<br>
            <strong>@lang('Customer'):</strong> {{ $model->customer->customer_name??'' }} <br>
        </div>
        <div class="col-sm-6 col-xs-6">
            <h4>@lang('Sale Details'):</h4>
            <strong>@lang('Reference'):</strong> {{ $model->reference_no }} <br>
            <strong>@lang('date'):</strong> {{$model->date}}
        </div>
        @else
            <div class="col-sm-6 col-xs-6">
                <h4>@lang('Sale Return Details'):</h4>
                <strong>@lang('Return Date'):</strong> {{$model->date}}<br>
                <strong>@lang('Customer'):</strong> {{ $model->customer->customer_name ?? '' }} <br>
            </div>
        @endif
      </div>
      <br>
      <div class="row">
        <div class="col-sm-12">
          <br>
          <table class="table bg-gray">
            <thead>
              <tr class="bg-green">
                  <th>#</th>
                  <th>@lang('Product')</th>
                  <th>@lang('Unit Price')</th>
                  <th>@lang('Return Qty')</th>
                  <th>@lang('Return SubTotal')</th>
              </tr>
          </thead>
          <tbody>
              @php
                $total_before_tax = 0;
              @endphp
              @foreach($model->sell_lines as $sale_line)
              @if($sale_line->quantity_returned == 0)
                @continue
              @endif
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    {{ $sale_line->product->product_name }}
                  </td>
                  <td><span class="display_currency" data-currency_symbol="true">{{ $sale_line->unit_price }}</span></td>
                  <td>{{$sale_line->quantity_returned}}</td>
                  <td>
                    @php
                      $line_total = $sale_line->unit_price * $sale_line->quantity_returned;
                      $total_before_tax += $line_total ;
                    @endphp
                    <span class="display_currency" data-currency_symbol="true">{{$line_total}}</span>
                  </td>
              </tr>
              @endforeach
            </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6"></div>
      <div class="col-sm-6">
        <table class="table">
          <tr>
            <th>@lang('Sub Total'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $total_before_tax }}</span></td>
          </tr>
          <tr>
            <th>@lang('Discount'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->return_parent->discount_amount ??  $model->discount_amount }}</span></td>
          </tr>

            <tr>
            <th>@lang('Tax'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->return_parent->tax ??  $model->tax }}</span></td>
          </tr>
          <tr>
            <th>@lang('Net Total'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $model->return_parent->net_total ??  $model->net_total }}</span></td>
          </tr>
    
          <tr>
            <th>@lang('Return Total'):</th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true" >{{ $model->return_parent->net_total ??  $model->net_total }}</span></td>
          </tr>
        </table>
      </div>
    </div>