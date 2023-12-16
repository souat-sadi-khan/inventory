@extends('layouts.invoice',['title' => ('Print Invoice'), 'url' => null,])
@section('main_invoice')
<div class="container">
	<div class="row mt-5">
		<div class="col-md-2 my-auto">
			<img src="{{ get_option('logo') && get_option('logo') != '' ? asset('storage/images/logo'). '/'. get_option('logo') : asset('images/logo.png') }}" class="w-100" width="90">
		</div>
		<div class="col-md-10 text-center">
			<p class="mb-"> {{get_option('institute_top_header') }}</p>
			<p class="h1"> {{get_option('company_name') }} </p>
			<p class=" mb-0"> {{ get_option('description') }} </p>
		</div>
		@php
		$date =explode('-',$model->date);
		@endphp
		<div class="col-md-12 text-center mt-3">
			<div class="bg-primary py-2">
				<p class="mb-0  text-light"> ফোনঃ {{ get_option('alternate_phone') }} , মোবাইলঃ {{ get_option('phone') }}</p>
			</div>
			<div class="col-md-12 text-center">
                    <span class="h3 border-one py-1 px-2">@lang('Purchase Return Voucher') </span>
              </div>
		</div>
	</div>
	<div class="row mt-4 mx-5">
		<div class="col-md-4">
			<p>  নং : {{ $model->reference_no }} </p>
		</div>
		
		<div class="col-md-4 text-right ml-auto">
			<div>
				<span class="mb-2"> তারিখঃ </span>
				<table class="table table-bordered d-inline border-0">
					<tbody>
						<tr>
							<td class="py-1">{{ $date[2] }}</td>
							<td class="py-1">{{ $date[1] }}</td>
							<td class="py-1">{{ $date[0] }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>
<div class="container mt-3">
	<div class="row mx-5">
		<div class="col-md-12">
			<table class="table table-bordered border-0">
				<tbody>
					<tr>
						<th class="py-1" scope="row"> নাম <span class="float-right"> : </span>  </th>
						<td class="py-1">{{ $model->supplier?$model->supplier->sup_name:'' }} </td>
					</tr>
					<tr>
						<th class="py-1" scope="row"> মোবাইল <span class="float-right"> : </span>  </th>
						<td class="py-1">{{ $model->supplier?$model->supplier->sup_mobile:'' }} </td>
					</tr>
					
					<tr class="my-1">
						<th class="py-1" scope="row"> ঠিকানা <span class="float-right"> : </span> </th>
						<td class="py-1"> {{ $model->supplier?$model->supplier->sup_address:'' }} </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row mt-5 mx-5">
		<div class="col-md-12">
			<table class="table table-bordered border-0">
				<thead class="bg-primary text-black">
					<tr>
						<th class="w-50" scope="col"> বিবরণ </th>
						<th class="w-2" scope="col"> পরিমাণ </th>
						<th class="w-2" scope="col"> দর </th>
						<th class="w-2" scope="col"> টাকা </th>
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
				<tfoot>
				<tr>
					<td class="border-0"> </td>
					<td class="border-0"></td>
					<td class="py-1"> মোট </td>
					<td>{{ $total_before_tax }}{{ get_option('currency_symbol') }}</td>
				</tr>
				
				<tr>
					<td class="border-0"> </td>
					<td class="border-0"></td>
					<td class="py-1"> মোট প্রদেয় </td>
					<td>{{ $model->return_parent->net_total ??  $model->net_total }} {{ get_option('currency_symbol') }}</td>
				</tr>
				<tr>
					<td class="border-0"> </td>
					<td class="border-0"></td>
					<td class="py-1"> মোট দেওয়া </td>
					<td>{{ $model->return_parent->net_total ??  $model->net_total }} {{ get_option('currency_symbol') }}</td>
				</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
@endsection