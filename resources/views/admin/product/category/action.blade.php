@can('category.update')
    <button id="content_managment" data-url="{{ route('admin.product-initiazile.category.edit',$model->id) }}" title="Edit {{ $model->category_name }}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>
@endcan 

@can('category.delete')
    <button id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.product-initiazile.category.destroy',$model->id) }}" title="Delete {{ $model->category_name }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
@endcan
