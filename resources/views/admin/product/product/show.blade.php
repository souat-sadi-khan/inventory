<div class="row">
	<div class="col-md-5 mx-auto  ">
		  <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                <h4 class="card-title border bg-light border-info">@lang('Stock In Cost Price')</h4>
                 <span class="badge badge-info">{{ $model->product_cost}}X{{ $model->stock  }}</span>
                 <span class="badge badge-success">{{ $model->product_cost*$model->stock }} {{ get_option('currency_symbol') }}</span>
            </div>
        </div>
	</div>

		<div class="col-md-5 mx-auto  ">
		  <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                <h4 class="card-title border bg-light border-info">@lang('Stock In Sale Price')</h4> 
                  <span class="badge badge-info">{{ $model->product_price}}X{{ $model->stock  }}</span>
                 <span class="badge badge-success">{{ $model->product_price*$model->stock }} {{ get_option('currency_symbol') }}</span>
            </div>
        </div>
	</div>
</div>
<div class="row">
		<div class="col-md-11 mx-auto  ">
		  <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                <h4 class="card-title">@lang('Stock Information')</h4> <br>
                  <span class="bg-info">Opening Stock : +</span>
                  <span class="badge badge-success">{{ $model->opening }}</span> <br>
                  <span class="bg-info">Purchase :+</span>
                  <span class="badge badge-success">{{ $model->purchase->sum('qty') }}</span> <br>
                  <span class="bg-info">Purchase Return :-</span>
                  <span class="badge badge-success">{{ $model->purchase->sum('quantity_returned') }}</span> <br>
                  <span class="bg-info">Sale :-</span>
                  <span class="badge badge-success">{{ $model->sale_line->sum('quantity') }}</span> <br>
                  <span class="bg-info">Sale Return :+</span>
                  <span class="badge badge-success">{{ $model->sale_line->sum('quantity_returned') }}</span> <br>
                  <span class="bg-info">In Stock :</span>
                  <span class="badge badge-success">{{ $model->stock }}</span> <br>
            </div>
        </div>
	</div>
</div>