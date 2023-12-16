@can('vehicle-type.update')
    <button title="Update {{ $model->name }} Information" id="content_managment" data-url="{{ route('admin.vehicle-type.edit',$model->id) }}"  class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>
@endcan 

@can('vehicle-type.delete')
    <button title="Delete {{ $model->name }}" id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.vehicle-type.destroy',$model->id) }}"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
@endcan