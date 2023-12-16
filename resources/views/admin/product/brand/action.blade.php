@can('brand.update')
    <button id="content_managment" data-url="{{ route('admin.product-initiazile.brand.edit',$model->id) }}" title="Edit {{ $model->brand_name }}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>
@endcan 

@can('brand.delete')
    <button id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.product-initiazile.brand.destroy',$model->id) }}" title="Delete {{ $model->brand_name }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
@endcan
