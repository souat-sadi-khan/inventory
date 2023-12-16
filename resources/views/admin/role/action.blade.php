@can('role.update')
    <a data-placement="bottom" title="Edit Role & Permission System for Users." href="{{ route('admin.user.role.edit',$model->id) }}" class="btn btn-info" title="{{ _lang('edit_permission') }}" data-popup="tooltip" data-placement="bottom"><i class="fa fa-pencil-square-o"></i></a>
@endcan

    <a data-placement="bottom" title="Delete Forever Role & Permission System for Users." href="" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.user.role.delete',$model->id) }}" class="btn btn-danger" title="delete_permission" data-popup="tooltip" data-placement="bottom"><i class="fa fa-trash"></i></a>