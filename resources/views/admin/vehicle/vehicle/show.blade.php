<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vehicle's Full View Information</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                {{-- Information --}}
                <div class="col-md-6 card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Basic Information</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="bg-light p-1">
                            @if ($model->type->name != '')
                            <h4 class="text-center">Name : {{ $model->type->name }} ({{$model->model_no}}) </h4>
                            @endif
                            @if ($model->regi_no != '')
                            <h6 class="text-center">Registration No : {{ $model->regi_no }} </h6>
                            @endif
                            @if ($model->chassis_no != '')
                            <h6 class="text-center">Chassis Number  : {{ $model->chassis_no }} </h6>
                            @endif
                            @if ($model->model_no != '')
                            <h6 class="text-center">Model Number : {{ $model->model_no }} </h6>
                            @endif
                            @if ($model->engine_no != '')
                            <h6 class="text-center">Engine Number : {{ $model->engine_no }} </h6>
                            @endif
                            @if ($model->road_permit != '')
                            <h6 class="text-center">License Number : {{ $model->road_permit }} </h6>
                            @endif
                            @if ($model->license_no != '')
                            <h6 class="text-center">License Validity : {{ $model->license_no }} </h6>
                            @endif
                            @if ($model->license_validity != '')
                            <h6 class="text-center">Road Permit : {{ $model->license_validity }} </h6>
                            @endif
                            @if ($model->investment != '')
                            <h6 class="text-center">Total Investment : {{ $model->investment }} </h6>
                            @endif
                            @if ($model->status != '')
                            <h6 class="text-center">Status : {{ $model->status }} </h6>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Balance --}}
                <div class="info-box col-md-6">
                    <span class="info-box-icon bg-info">{{ get_option('currency_symbol') }}</span>
                    
                    <div class="info-box-content">
                        <h4 class="info-box-text text-center">Balance Info</h4>
                        <h6 class="info-box-number text-center">
                        <strong>@lang('Total Investment')</strong>
                        <p class="text-muted">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $model->investment }} {{ get_option('currency_symbol') }}</span>
                        </p>
                        <strong>@lang('Total Income')</strong>
                        <p class="text-muted">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $income}} {{ get_option('currency_symbol') }}</span>
                        </p>
                        <strong>@lang('Total Expence')</strong>
                        <p class="text-muted">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $expence }} {{ get_option('currency_symbol') }}</span>
                        </p>
                        <strong>@lang('Current Balance')</strong>
                        <p class="text-muted">
                            <span class="display_currency" data-currency_symbol="true">
                            {{ $balance }} {{ get_option('currency_symbol') }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>


        <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vehicle Transaction</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped " >
                <thead>
                    <tr>
                        <th>@lang('id')</th>
                        <th>@lang('Transaction Type')</th>
                        <th>@lang('Description')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Date')</th>
                    </tr>
                </thead>
                <tbody>
{{-- @php
    $total = 0;
@endphp --}}
                    @foreach ($model->invest as $item)
                    {{-- @php
                        $total += $item->amount;
                    @endphp --}}
                        <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$item->type}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->amount}}</td>
                        <td>{{$item->date}}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
                {{-- <tfoot>
                    <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <th>{{$total}}</th>
                    </tr>
                </tfoot> --}}
            </table>
        </div>
    </div>
