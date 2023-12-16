@extends('layouts.main', ['title' => ('Purchase Return'), 'modal' => 'xl',])
@push('admin.css')
@endpush
@section('header')
  <a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
    <a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club" aria-hidden="true"></i>@lang('Today')</a>
    <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play" aria-hidden="true"></i>@lang('Tutorial')</a>
    <a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle" aria-hidden="true"></i>@lang('Help')</a>
    <a href="{{ route('admin.pur_voucher.purchase.create') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-bath" aria-hidden="true"></i>@lang('Purchase')</a>
    <a href="{{ route('admin.pur_voucher.purchase.index') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-list-alt" aria-hidden="true"></i>@lang('Purchase List')</a>
    <a href="{{ route('admin.pur_voucher.return.index') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-list-alt" aria-hidden="true"></i>@lang('Return List')</a>
@endsection
@section('content')
<div class="card">
	<div class="card-body">
     <form action="{{ route('admin.pur_voucher.return.store') }}" method="post" id="content_form">
     	<input type="hidden" name="transaction_id" value="{{ $purchases->id }}">
     		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-4">
						<h4>Parent Purchase</h4>
						<strong>@lang('Reference'):</strong> {{ $purchases->reference_no }} <br>
						<strong>@lang('Date'):</strong> {{$purchases->date}}
					</div>
					<div class="col-sm-4">
						<strong>@lang('Supplier'):</strong> {{ $purchases->supplier->sup_name }} <br>
						<strong>@lang('Mobile'):</strong> {{ $purchases->supplier->sup_mobile }}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
					<label for="reference_no">Reference No</label>
					<input type="text" name="reference_no" id="reference_no" class="form-control" value="{{ !empty($purchases->return_parent->reference_no) ? $purchases->return_parent->reference_no : null }}" readonly>
				</div>
			</div>
			<div class="clearfix"></div>
			<hr>
			<div class="col-sm-12">
				<div class="table-responsive">
				<table class="table" id="purchase_return_table" style="background: #eee">
					<thead>
						<tr class="bg-green">
							<th>#</th>
							<th>@lang('Product Name')</th>
							<th>@lang('Unit Price')</th>
							<th>@lang('Purchase Qty')</th>
							<th>@lang('	Quantity Remaining')</th>
							<th>@lang('Return Quantity')</th>
							<th>@lang('Return Subtotal')</th>
						</tr>
					</thead>
					<tbody>
						@foreach($purchases->purchase as $purchase_line)
						@php
						$qty_available = $purchase_line->qty
						@endphp
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>
								{{ $purchase_line->product->product_name }}
							</td>
							<td><span class="display_currency" data-currency_symbol="true">{{ $purchase_line->price }}</span></td>
							<td><span class="display_currency" data-is_quantity="true" data-currency_symbol="false">{{ $purchase_line->qty }}</span></td>
							<td><span class="display_currency" data-currency_symbol="false" data-is_quantity="true">{{ $qty_available-$purchase_line->quantity_returned }}</span> 
								<input type="hidden" class="qty_available" value="{{ $qty_available }}">
							</td>
							<td>
								<input type="text" name="returns[{{$purchase_line->id}}]" value="{{$purchase_line->quantity_returned}}"
								class="form-control input-sm input_number return_qty input_quantity">
								<span class="text-danger return_error"></span>
								<input type="hidden" class="unit_price" value="{{$purchase_line->price}}">
							</td>
							<td>
								<div class="return_subtotal">{{ $purchase_line->quantity_returned*$purchase_line->price }}</div>
								
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			  </div>
			</div>
		</div>
		<div class="row">
				   <div class="col-md-4">
                    <div class="form-group">
                        <label for="account_id">Account </label>
                        <select name="account_id" class="form-control select" id="account_id" required>
                            <option value="">Select Account</option>
                            @foreach ($accounts as $element)
                               <option {{ $account_id==$element->id?'selected':'' }} value="{{ $element->id }}">{{ $element->name }}({{ toWord($element->category) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
			<div class="col-sm-12 text-right">
				<strong>@lang('ReturnTotal'): </strong>&nbsp;
				<span id="net_return">0</span>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-12">
				<button type="submit" class="btn btn-primary pull-right" id="submit">@lang('Return')</button>
				<button type="button" class="btn pull-right btn-info" id="submiting" style="display: none;">
				<i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
			</div>
		</div>
     </form>
	</div>
</div>
@endsection
@push('admin.scripts')
<script>
	_componentSelect2Normal();
	update_purchase_return_total();
   $(document).on('change', 'input.return_qty', function(){
		update_purchase_return_total()
	});

	function update_purchase_return_total(){
		var net_return = 0;
		$('table#purchase_return_table tbody tr').each( function(){
			var qty =$(this).find('input.return_qty');
			 if (isNaN(qty.val())) {
			    toastr.error('Please Enter Valid Quantity');
			    qty.val("");

			  }
			  else{
			    if ((qty.val() -0) > ($(this).find('input.qty_available').val()-0)) {
			      toastr.error('Sorry! this much not quantity is not available');
			      $(this).find('.return_error').text('quantity is not available')
			      qty.val($(this).find('input.qty_available').val());
			    }
			  }
			var quantity = $(this).find('input.return_qty').val();
			var unit_price = $(this).find('input.unit_price').val();
			var subtotal = quantity * unit_price;
			$(this).find('.return_subtotal').text(subtotal);
			net_return += subtotal;
		});
		var net_return_inc_tax =  net_return;
		$('span#net_return').text(net_return_inc_tax);
	}

	_formValidation();
</script>
@endpush