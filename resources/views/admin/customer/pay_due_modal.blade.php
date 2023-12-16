<div class="card">
	<div class="card-body">
		<div class="row">
			@if($due_payment_type == 'Sale')
			<div class="col-md-6">
				<div class="card-body">
					<strong>@lang('Customer'): </strong>{{ $contact_details->customer_name }}
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-body">
					<strong>@lang('Total Sale'): </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_sale }}</span><br>
					<strong>@lang('Total Paid'): </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_paid }}</span><br>
					<strong>@lang('Total Sale Due'): </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_sale - $contact_details->total_paid }}</span><br>
					@if(!empty($contact_details->opening_balance) || $contact_details->opening_balance != '0.00')
					<strong>@lang('Opening Balance'): </strong>
					<span class="display_currency" data-currency_symbol="true">
					{{ $contact_details->opening_balance }}</span><br>
					<strong>@lang('Opening Balance Due'): </strong>
					<span class="display_currency" data-currency_symbol="true">
					{{ $ob_due }}</span>
					@endif
				</div>
			</div>
			@elseif($due_payment_type == 'sale_return')
			<div class="col-md-6">
				<div class="card-body">
					<strong>@lang('Customer'): </strong>{{ $contact_details->customer_name }}<
				</div>
			</div>
			<div class="col-md-6">
				<div class="card-body">
					<strong>@lang('Total Sale Return'): </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_sale_return }}</span><br>
					<strong>@lang('Sale Return Paid'): </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_return_paid }}</span><br>
					<strong>@lang('Sale Return Due'): </strong><span class="display_currency" data-currency_symbol="true">{{ $contact_details->total_sale_return - $contact_details->total_return_paid }}</span>
				</div>
			</div>
   @endif
		</div>
		<form action="{{ route('admin.postPayCustomerDue') }}" method="post" enctype="multipart/form-data" id="modal_form">
			<input type="hidden" name="customer_id" value="{{ $contact_details->customer_id }}">
			<input type="hidden" name="due_payment_type" value="{{ $due_payment_type }}">
			<input type="hidden" name="hidden_amount" value="{{ $payment_line->amount }}">
			<div class="row">
				 <div class="col-md-12">
                    <label for="payment_date">
                        @lang('Reference')
                    </label>
                    <input type="text" class="form-control" name="payment_ref_no" value="{{ random_num('Payment') }}" readonly>
                </div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="amount">@lang('Amount')</label>
						
						<input type="text" class="form-control" name="amount" id="amount" data-rule-max-value="{{ $payment_line->amount }}" value="{{ $payment_line->amount }}" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="payment_date">@lang('Payment Date')</label>
						
						<input type="text" class="form-control date" name="payment_date" id="payment_date" value="{{ date('Y-m-d') }}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="method">@lang('Payment Method')</label>
						
						<select class="form-control payment_types_dropdown" id="method"
							name="method">
							<option value="cash">Cash</option>
							<option value="card">Card</option>
							<option value="cheque">Cheque</option>
							<option value="bank_transfer">Bank Transfer</option>
							<option value="other">Other</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="transaction">Transaction No.</label>
						<input class="form-control" placeholder="Transaction No." id="transaction" name="transaction_no" type="text" value="">
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label for="note_0">Payment note:</label>
						<textarea class="form-control" rows="3" id="note_0" name="note" cols="50"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 mx-auto text-center">
					<input type="submit" class="btn btn-primary btn-lg w-100" id="submit" value="Paid">
					<button type="button" class="btn btn-primary btn-lg w-100" id="submiting" style="display: none;" disabled="">@lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
				</div>
			</div>
		</form>
	</div>
</div>