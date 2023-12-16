<button title="Update Information" id="content_managment" data-url="{{ route('admin.account-trans.edit',$model->id) }}"  class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>

<button title="Delete" id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.account-trans.destroy',$model->id) }}"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>