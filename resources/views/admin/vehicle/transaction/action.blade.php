@can('vehicle-transaction.update')
    <button title="Update {{ $model->name }} Information" id="content_managment" data-url="{{ route('admin.vehicle-transaction.edit',$model->id) }}"  class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>
@endcan 

@can('vehicle-transaction.delete')
    <button title="Delete {{ $model->name }}" id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.vehicle-transaction.destroy',$model->id) }}"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
@endcan