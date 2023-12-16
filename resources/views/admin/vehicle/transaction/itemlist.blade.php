<tr>
	<td>
		<input type="hidden" name="vehicle_id[]" value="{{ $vehicle->id}}" class="pid">
		{{ $vehicle->model_no }} ({{$vehicle->type->name}})
	</td>
	<td>
		<input type="hidden" name="description[]" value="{{ $description}}" class="qty">
		{{ $description }}
	</td>
	<td>
		<input type="hidden" name="amount[]" value="{{ $amount }}">
		{{ $amount }}
	</td>
	<td>
		<input type="hidden" name="type[]" value="{{ $type }}">
		{{ $type }}
	</td>
	<td>
		<input type="hidden" name="date[]" value="{{ $date }}">
		{{ $date }}
	</td>
	
	<td>
		<button type="button" name="remove" class="btn btn-danger btn-sm remmove"><i class="fa fa-trash"></i></button>
	</td>
</tr>