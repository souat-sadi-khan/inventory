@can('vehicle.view')
    <button title="View {{ $model->name }} Information" id="content_managment" data-url="{{ route('admin.vehicle.show',$model->id) }}"  class="btn btn-sm btn-primary"><i class="fa fa-eye-slash"></i></button>
@endcan 

@can('vehicle.update')
    <button title="Update {{ $model->name }} Information" id="content_managment" data-url="{{ route('admin.vehicle.edit',$model->id) }}"  class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>
@endcan 

@can('vehicle.delete')
    <button title="Delete {{ $model->name }}" id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.vehicle.destroy',$model->id) }}"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
@endcan