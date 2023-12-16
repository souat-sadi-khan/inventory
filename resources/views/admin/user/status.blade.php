<label class="switch">
	<input type="checkbox"  id="change_status" data-id="{{ $model->id }}" data-status="{{ $model->active }}" data-url="{{ route('admin.user.change',['value'=> ($model->active == 1 ? 0 : 1),'id'=>$model->id])  }}" {{ $model->active == 1 ? 'checked' : '' }}>
	<span class="slider"></span>
</label>