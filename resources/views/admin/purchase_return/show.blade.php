      <div class="row">
        @if(!empty($model->return_parent))
        <div class="col-sm-6 col-xs-6">
            <h4>@lang('Purchase Return Details'):</h4>
            <strong>@lang('Return Date'):</strong> {{$model->return_parent->date}}<br>
            <strong>@lang('Supplier'):</strong> {{ $model->supplier->sup_name??'' }} <br>
        </div>
        <div class="col-sm-6 col-xs-6">
            <h4>@lang('Purchase Details'):</h4>
            <strong>@lang('Reference'):</strong> {{ $model->reference_no }} <br>
            <strong>@lang('date'):</strong> {{$model->date}}
        </div>
        @else
            <div class="col-sm-6 col-xs-6">
                <h4>@lang('Purchase Return Details'):</h4>
                <strong>@lang('Return Date'):</strong> {{$model->date}}<br>
                <strong>@lang('Supplier'):</strong> {{ $model->supplier->sup_name ?? '' }} <br>
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
              @foreach($model->purchase as $purchase_line)
              @if($purchase_line->quantity_returned == 0)
                @continue
              @endif
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    {{ $purchase_line->product->product_name }}
                  </td>
                  <td><span class="display_currency" data-currency_symbol="true">{{ $purchase_line->price }}</span></td>
                  <td>{{$purchase_line->quantity_returned}}</td>
                  <td>
                    @php
                      $line_total = $purchase_line->price * $purchase_line->quantity_returned;
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
            <th>@lang('Net Total'): </th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true">{{ $total_before_tax }}</span></td>
          </tr>
    
          <tr>
            <th>@lang('Return Total'):</th>
            <td></td>
            <td><span class="display_currency pull-right" data-currency_symbol="true" >{{ $model->return_parent->net_total ??  $model->net_total }}</span></td>
          </tr>
        </table>
      </div>
    </div>