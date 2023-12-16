<tr>
	<td>
		<input type="hidden" name="form_bank[]" value="{{$bank->id }}" class="pid">
		{{ $bank->name }}
	</td>
	<td>
		<input type="hidden" name="to_bank[]" value="{{ $account->id }}" class="qty">
		{{ $account->name }}
	</td>
	<td>
		<input type="hidden" name="sent_type[]" value="{{ $type }}">
		{{ $type }}
	</td>
	<td>
		<input type="hidden" name="sent_amount[]" value="{{ $amount }}">
		{{ $amount }}
	</td>
	<td>
		<button type="button" name="remove" class="btn btn-danger btn-sm remmove"><i class="fa fa-trash"></i></button>
	</td>
</tr>