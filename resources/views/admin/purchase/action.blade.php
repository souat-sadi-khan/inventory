<div class="dropdown">
	<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
	@lang('Action')
	</button>
	<div class="dropdown-menu">
		<a data-url ="{{ route('admin.pur_voucher.purchase.show',$model->id) }}" id="btn_modal" class="dropdown-item" style="cursor: pointer;"><i class="fa fa-eye-slash" aria-hidden="true"></i>@lang('Details')</a>
		<a onclick="myFunction('{{ route('admin.pur_voucher.view',$model->id) }}')" class="dropdown-item" style="cursor: pointer;"><i class="fa fa-print" aria-hidden="true"></i>@lang('Print')</a>
        <a data-url ="{{ route('admin.pur_voucher.purchase_payment',$model->id) }}" id="btn_modal" class="dropdown-item" style="cursor: pointer;"><i class="fa fa-money" aria-hidden="true"></i>@lang('Payment')</a>
        <a id="delete_item" data-id ="{{$model->id}}" data-url ="{{ route('admin.pur_voucher.purchase.destroy',$model->id) }}" id="btn_modal" class="dropdown-item" style="cursor: pointer;"><i class="fa fa-trash" aria-hidden="true"></i>@lang('Delete')</a>

	</div>
</div>