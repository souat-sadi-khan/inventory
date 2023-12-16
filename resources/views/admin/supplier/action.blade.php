@can('supplier.purchase')
    @if ($model->status == 1)
        <a title="Purchase From {{ $model->sup_name }}" href="{{ route('admin.pur_voucher.purchase.create',['supplier'=>$model->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></a>
    @else 
        <button type="button" class="btn btn-default btn-sm" disabled data-toggle="tooltip" data-placement="top" title="Supplier is InActive . Please Make Active"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
    @endif
@endcan

@can('supplier.view')
    <a title="View {{ $model->sup_name }} Information" href="{{ route('admin.supplier.show',$model->id) }}"><button class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></button></a>
@endcan 

@can('supplier.view')
@if(($model->total_purchase + $model->opening_balance - $model->purchase_paid - $model->opening_balance_paid)>0)
    <button title="Pay Due Amount" id="content_managment" data-url="{{ route('admin.supplier.make_payment',[$model->id,'type'=>'Purchase']) }}" class="btn btn-sm btn-primary"><i class="fa fa-money"></i></button>
@endif   
@endcan 
@can('supplier.view')
 @if(($model->total_purchase_return - $model->purchase_return_paid) > 0)
    <button title="Receive Purchase Return Due" id="content_managment" data-url="{{ route('admin.supplier.make_payment',[$model->id,'type'=>'purchase_return']) }}" class="btn btn-sm btn-primary"><i class="fa fa-money"></i></button>
@endif   
@endcan 

@can('supplier.update')
    <button id="content_managment" data-url="{{ route('admin.supplier.edit',$model->id) }}"  class="btn btn-sm btn-info" title="Edit {{ $model->sup_name }} Information" ><i class="fa fa-pencil-square-o"></i></button>
@endcan 

@if ($model->id !=1)
    @can('supplier.delete')
    <button id="delete_item" data-id ="{{ $model->id }}" data-url="{{ route('admin.supplier.destroy',$model->id) }}" title="Delete {{ $model->sup_name }}"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
@endcan 
@endif