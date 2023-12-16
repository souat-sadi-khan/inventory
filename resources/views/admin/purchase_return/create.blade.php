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
<div class="row">
	<div class="col-md-10 mx-auto ">
		<div class="card card-box border border-primary">
			<div class="card-body text-center">
				<div class="row">
					<div class="col-md-10 mx-auto">
						<label for="transaction_id">Purchase Reference <span class="text-danger"></span></label>
						<select data-parsley-errors-container="#transaction_error" required name="transaction_id" id="transaction_id" class="form-control select" data-placeholder="Select Transaction Reference">
							<option value="">Select Transaction Reference</option>
							@foreach ($transaction as $element)
							<option value="{{ $element->id }}">{{ $element->reference_no }}</option>
							@endforeach
						</select>
						<span id="transaction_error"></span>
					</div>
				</div>
				<div class="row mt-2">
					 <div class="col-md-6 mx-auto text-center">
                        
                        <button type="button" class="btn btn-primary btn-sm w-100" id="check_it">Check Transaction</button>
                        <button type="button" class="btn btn-sm btn-info w-100" id="checking" style="display: none;">
                        <i class="fa fa-spinner fa-spin fa-fw"></i>Checking...</button>
                    </div>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection
@push('admin.scripts')
<script>
	_componentSelect2Normal();

$(document).on('click', '#check_it', function() {
    var transaction_id = $('#transaction_id').val();
    $(this).hide();
    $('#checking').show();
    if (transaction_id=="") {
      $(this).show();
      $('#checking').hide();
      toastr.error('Select Purchase References');
    }else{
     $.ajax({
            url: '/admin/purchase-voucher/return-check',
            data: {
                transaction_id: transaction_id,
            },
            type: 'Get',
            dataType: 'json'
        })
        .done(function(data) {
           $(this).show();
           $('#checking').hide();
           toastr.success(data.message);
            if (data.goto) {
                setTimeout(function() {

                    window.location.href = data.goto;
                }, 500);
            }
        })
    }

});
</script>
@endpush