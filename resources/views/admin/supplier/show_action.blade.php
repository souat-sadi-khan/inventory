@if ($model->transaction_type=='Purchase')
	<a class="btn btn-danger btn-sm text-light" onclick="myFunction('{{ route('admin.pur_voucher.purchase.printpayment',$model->id) }}')" class="dropdown-item" style="cursor: pointer;"><i class="fa fa-print" aria-hidden="true"></i>@lang('Print')</a>
@elseif($model->transaction_type=='purchase_return')
  	<a class="btn btn-danger btn-sm text-light" onclick="myFunction('{{ route('admin.pur_voucher.return_print',$model->parent) }}')" class="dropdown-item" style="cursor: pointer;"><i class="fa fa-print" aria-hidden="true"></i>@lang('Print')</a>
  	@else
  	<a class="btn btn-danger btn-sm text-light" onclick="myFunction('{{ route('admin.supplier_opening_payment_print',$model->id) }}')" class="dropdown-item" style="cursor: pointer;"><i class="fa fa-print" aria-hidden="true"></i>@lang('Print')</a>
@endif