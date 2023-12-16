@can('account.show')
    <a title="View {{ $model->category }} Information" href="{{ route('admin.account.show',$model->category) }}"><button class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></button></a>
@endcan