@extends('layouts.main', ['title' => ('Fiexd Assets'), 'modal' => 'xl',])

@push('admin.css')
<link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('header')
 <a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
    <a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club" aria-hidden="true"></i>@lang('Today')</a>
    <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play" aria-hidden="true"></i>@lang('Tutorial')</a>
    <a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle" aria-hidden="true"></i>@lang('Help')</a>
    <a href="{{ route('admin.account.index') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-check-square" aria-hidden="true"></i>@lang('Account')</a>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Or Manage Fiexd Assets</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="accordion">
                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                {{-- @can('customer.create') --}}
                <div class="card card-info">
                    <a class="bg-info" data-toggle="collapse" data-parent="#accordion" href="#create">
                        <div class="card-header">
                            <h4 class="card-title">
                                Create Fiexd Assets
                            </h4>
                        </div>
                    </a>
                    <div id="create" class="panel-collapse collapse in">
                        <div class="card-body">
                            <form action="{{ route('admin.fiexd-assets.store') }}" method="post" id="content_form">
                                @csrf
                                <div class="row">
                                    {{-- Category --}}

                                    <div class="col-md-4 form-group">
                                        <label for="category">Category</label>
                                        <div class="input-group" data-target-input="nearest">
                                            <select name="category" data-placeholder="Select Category" id="category"
                                                class="form-control select" required>
                                                <option value="">Select Category</option>
                                                @php
                                                $models = App\Models\Admin\FixedAssetsCategory::select('id',
                                                'name')->get();
                                                @endphp
                                                @foreach ($models as $model)
                                                <option  value="{{$model->id}}">{{$model->name}} </option>
                                                @endforeach
                                            </select>
                                            <div data-url="{{ route('admin.fiexd-assets.add_category') }}"
                                                title="Add New Category" class="input-group-append"
                                                id='content_managment' style="cursor: pointer;">
                                                <div class="input-group-text"><i class="fa fa-plus"></i></div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Product Name --}}
                                    <div class="col-md-4 form-group">
                                        <label id="Product" for="product_name">Product Name <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="product_name" id="product_name" class="form-control"
                                            placeholder="Enter Product Name" required>
                                    </div>

                                    {{-- Details --}}
                                    <div class="col-md-4 form-group" id="display">
                                        <label for="details">Details <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="details" id="details" class="form-control"
                                            placeholder="Enter Details" required>
                                    </div>

                                    {{-- Cost Per 1 Ps --}}
                                    <div class="col-md-3 form-group " id="alias_show">
                                        <label for="cost">Cost Per 1 Ps <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="cost" id="cost" class="form-control input_number"
                                            placeholder="Enter Cost Price" required>
                                    </div>


                                    {{-- Qty --}}
                                    <div class="col-md-3 form-group ">
                                        <label for="qty">Qty <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="qty" id="qty" class="form-control input_number"
                                            placeholder="00.00">
                                    </div>

                                    {{-- Total --}}
                                    <div class="col-md-3 form-group bank_show">
                                        <label for="total">Total <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" readonly name="total" id="total" class="form-control input_number"
                                            value="0">
                                    </div>


                                    {{-- Depreciation (%) (Yearly) --}}
                                    <div class="col-md-3 form-group bank_show">
                                        <label for="depreciation">Depreciation (%) (Yearly) <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="depreciation" id="depreciation" class="form-control"
                                            placeholder="0%">
                                    </div>

                                </div>

                                <button type="submit" id="submit"
                                    class="btn btn-primary float-right px-5">Submit</button>
                                <button type="button" id="submiting" class="btn btn-sm btn-info float-right px-5"
                                    id="submiting" style="display: none;">
                                    <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

                                <button type="button" class="btn btn-sm btn-danger" id="close">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- @endcan --}}

                <div class="card card-primary">
                    <a class="bg-primary" data-toggle="collapse" data-parent="#accordion" href="#list">
                        <div class="card-header">
                            <h4 class="card-title">
                                Fiexd Assets
                            </h4>
                        </div>
                    </a>
                    <div id="list" class="panel-collapse collapse">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table"
                                    data-url="{{ route('admin.fixed-assets.datatable') }}">
                                    <thead>
                                        <tr>
                                            <th>S/L</th>
                                            <th>Discription</th>
                                            <th>Qty</th>
                                            <th>Cost Price</th>
                                            <th>Total Stock</th>
                                            <th>Depreciation (%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S/L</th>
                                            <th>Discription</th>
                                            <th>Qty</th>
                                            <th>Cost Price</th>
                                            <th>Total Stock</th>
                                            <th>Depreciation (%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12 mt-3">
                <div class="card card-primary">
                    <a class="bg-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Assets Category List
                            </h4>
                        </div>
                    </a>
                    <div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S/L</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $models = App\Models\Admin\FixedAssetsCategory::select('id', 'name')->get();
                                        @endphp
                                        @foreach ($models as $model)
                                        <tr>
                                            <th scope="row">{{$loop->index+1}}</th>
                                            <td id="content_managment" title="Update {{ $model->name }} Information"
                                                data-url="{{ route('admin.fiexd-assets-category.edit',$model->id) }}">
                                                {{ $model->name }}</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S/L</th>
                                            <th>Name</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection

@push('admin.scripts')
<script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js//summernote-bs4.min.js') }}"></script>
<script src="{{ asset('js/pages/fixed-assets.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#category").select2({
            width: '80%'
        });
    });

</script>

@endpush
