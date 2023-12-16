<tr>
	<td>
		<input type="hidden" name="variation[{{ $row }}][product_id]" value="{{ $model->id }}" class="pid">
		{{ $model->product_name }}
	</td>
	<td>
		<input type="hidden" name="variation[{{ $row }}][quantity]" value="{{ $quantity }}" class="qty">
		{{ $quantity }}
	</td>
	<td>
		<input type="hidden" name="variation[{{ $row }}][unit_price]" value="{{ $product_price }}">
		<input type="hidden" name="variation[{{ $row }}][cost_price]" value="{{ $product_cost_price }}" class="cost_price">
		{{ $product_price }}
	</td>
	<td>
		<input type="hidden" name="variation[{{ $row }}][total]" value="{{$product_price*$quantity}}">
		<span class="amt" id="amt">{{$product_price*$quantity}}</span>
		<span class="cost_amt d-none" id="cost_amt">{{$product_cost_price*$quantity}}</span>
	</td>
	<td>
		<button type="button" name="remove" class="btn btn-danger btn-sm remmove"><i class="fa fa-trash"></i></button>
	</td>
</tr>
