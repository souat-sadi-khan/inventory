@can('brand.update')
    <a data-url="{{ route('admin.products.products.show',$model->id) }}"  class="btn btn-sm btn-info btn_modal"><i class="fa fa-eye-slash" title="View"></i></a>
@endcan 
@can('brand.update')
    <a href="{{ route('admin.products.products.edit',$model->id) }}"  class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></a>
@endcan 

@can('brand.delete')
    <button id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.products.products.destroy',$model->id) }}" title="Delete {{ $model->brand_name }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
@endcan