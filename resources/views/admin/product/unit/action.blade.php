@can('unit.update')
    <button id="content_managment" data-url="{{ route('admin.product-initiazile.unit.edit',$model->id) }}" title="Edit {{ $model->unit_name }}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>
@endcan 

@can('unit.delete')
    <button id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.product-initiazile.unit.destroy',$model->id) }}" title="Delete {{ $model->unit_name }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
@endcan
