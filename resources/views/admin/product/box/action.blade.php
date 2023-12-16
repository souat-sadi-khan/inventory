@can('box.update')
    <button id="content_managment" data-url="{{ route('admin.product-initiazile.box.edit',$model->id) }}" title="Edit {{ $model->box_name }}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>
@endcan 

@can('box.delete')
    <button id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.product-initiazile.box.destroy',$model->id) }}" title="Delete {{ $model->box_name }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
@endcan
