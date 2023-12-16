<tr>
	<td>
		<input type="hidden" name="variation[{{ $row }}][product_id]" value="{{ $model->id }}" class="pid">
		{{ $model->product_name }}
	</td>
	<td>
		<input type="hidden" name="variation[{{ $row }}][qty]" value="{{ $quantity }}" class="qty">
		{{ $quantity }}
	</td>
	<td>
		<input type="hidden" name="variation[{{ $row }}][purchase_price]" value="{{ $product_cost }}">
		{{ $product_cost }}
	</td>
	<td>
		<input type="hidden" name="variation[{{ $row }}][product_price]" value="{{ $product_price }}">
		{{ $product_price }}
	</td>
	<td>
		<input type="hidden" name="variation[{{ $row }}][line_total]" value="{{$product_cost*$quantity}}">
		<span class="amt" id="amt">{{$product_cost*$quantity}}</span>
	</td>
	<td>
		<button type="button" name="remove" class="btn btn-danger btn-sm remmove"><i class="fa fa-trash"></i></button>
	</td>
</tr>