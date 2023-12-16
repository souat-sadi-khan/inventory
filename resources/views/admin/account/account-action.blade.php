@if ($model->is_default)
@can('account.show')
    <a title="View {{ $model->name }} Information" href="{{ route('admin.account.show_data',$model->id) }}"><button class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></button></a>
@endcan
@else 

@can('account.show')
    <a title="View {{ $model->name }} Information" href="{{ route('admin.account.show_data',$model->id) }}"><button class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></button></a>
@endcan

@can('account.update')
    <button title="Update {{ $model->name }} Information" id="content_managment" data-url="{{ route('admin.account.edit',$model->id) }}"  class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>
@endcan 
@can('account.delete')
    <button title="Delete {{ $model->name }}" id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.account.destroy',$model->id) }}"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
@endcan
@endif