@if ($model->transaction_type=='Sale')
	<a class="btn btn-danger btn-sm text-light" onclick="myFunction('{{ route('admin.sale_voucher.sale.printpayment',$model->id) }}')" class="dropdown-item" style="cursor: pointer;"><i class="fa fa-print" aria-hidden="true"></i>@lang('Print')</a>
@elseif($model->transaction_type=='sale_return')
  	<a class="btn btn-danger btn-sm text-light" onclick="myFunction('{{ route('admin.sale_voucher.return_print',$model->parent) }}')" class="dropdown-item" style="cursor: pointer;"><i class="fa fa-print" aria-hidden="true"></i>@lang('Print')</a>
  	@else
  	<a class="btn btn-danger btn-sm text-light" onclick="myFunction('{{ route('admin.customer_opening_payment_print',$model->id) }}')" class="dropdown-item" style="cursor: pointer;"><i class="fa fa-print" aria-hidden="true"></i>@lang('Print')</a>
@endif