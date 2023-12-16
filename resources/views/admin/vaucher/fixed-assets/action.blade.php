@can('fiexd-assets.update')
    <button title="Update {{ $model->name }} Information" id="content_managment" data-url="{{ route('admin.fiexd-assets.edit',$model->id) }}"  class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>
@endcan 