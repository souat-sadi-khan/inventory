{{-- Pay --}}
@if ($model->due != 0)
    <button title="Pay {{$model->title}}" id="content_managment" data-url="{{ route('admin.loan.pay',$model->id) }}" class="btn btn-success btn-sm"><i class="fa fa-money"></i></button>
@endif 
{{-- View --}}
<button title="View {{$model->title}} Information" id="content_managment" data-url="{{ route('admin.loan.show',$model->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></button>

{{-- Edit --}}
<button title="Update {{$model->title}} Information" id="content_managment" data-url="{{ route('admin.loan.edit',$model->id) }}" class="btn btn-info btn-sm"><i class="fa fa-pencil-square-o"></i></button>

{{-- Delete --}}
<button title="Delete {{$model->title}}" id="delete_item" data-id ="{{$model->id}}" data-url="{{ route('admin.loan.destroy',$model->id) }}" class="btn btn-danger btn-sm delete_{{$model->id}}" disabled><i class="fa fa-trash"></i></button>

    <input type="checkbox" class="check" data-id="{{$model->id}}" multiple="multiple" value="">

<script>
    $(function() {
        $(document).on('click', '.check', function() {
            var id = $(this).data('id');
            $('.delete_'+id).removeAttr('disabled');
        });
    })
</script>