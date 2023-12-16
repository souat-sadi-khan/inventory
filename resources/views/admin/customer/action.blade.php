{{-- @can('customer.sell')
    @if ($model->status == 1)
        <button title="Sell on {{ $model->customer_name }}" class="btn btn-success btn-sm" type="button"><i class="fa fa-cart-plus" aria-hidden="true"></i></button>
    @else 

        <button type="button" class="btn btn-default btn-sm" disabled data-toggle="tooltip" data-placement="top" title="Customer is InActive . Please Make Active"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
    @endif

@endcan  --}}

@can('customer.show')
    <a title="View {{ $model->customer_name }} Information" href="{{ route('admin.customer.show',$model->id) }}"><button class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></button></a>
@endcan

@can('supplier.view')
@if(($model->total_sale + $model->opening_balance - $model->sale_paid - $model->opening_balance_paid)>0)
    <button title="Pay Due Amount" id="content_managment" data-url="{{ route('admin.customer.make_payment',[$model->id,'type'=>'Sale']) }}" class="btn btn-sm btn-primary"><i class="fa fa-money"></i></button>
@endif   
@endcan 
@can('supplier.view')
 @if(($model->total_sale_return - $model->sale_return_paid) > 0)
    <button title="Receive Sale Return Due" id="content_managment" data-url="{{ route('admin.customer.make_payment',[$model->id,'type'=>'sale_return']) }}" class="btn btn-sm btn-primary"><i class="fa fa-money"></i></button>
 @endif
@endcan 

@can('customer.update')
    <button title="Update {{ $model->customer_name }} Information" id="content_managment" data-url="{{ route('admin.customer.edit',$model->id) }}"  class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></button>
@endcan 
@if ($model->id !=1)
   @can('customer.delete')
    <button title="Delete {{ $model->customer_name }}" id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.customer.destroy',$model->id) }}"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
@endcan
@endif
