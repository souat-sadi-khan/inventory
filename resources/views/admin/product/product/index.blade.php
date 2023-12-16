@extends('layouts.main', ['title' => ('Product Manage'), 'modal' => 'xl',])

@push('admin.css')
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/summernote-bs4.css') }}">
    <style>
        .table th, .table td {
         padding: 0.2rem 0.5rem;
        }
    </style>
@endpush

@section('header')
  <div class="btn-group btn-group-justified ml-3">
    <a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
    <a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club" aria-hidden="true"></i>@lang('Today')</a>
    <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play" aria-hidden="true"></i>@lang('Tutorial')</a>
    <a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle" aria-hidden="true"></i>@lang('Help')</a>
  </div>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Or Manage Product</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="accordion">
                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                @can('brand.create')
                    <div class="card card-info">
                        <a class="bg-info" data-toggle="collapse" data-parent="#accordion" href="#create">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Create New Product
                                </h4>
                            </div>
                        </a>
                        <div id="create" class="panel-collapse collapse in">
                            <div class="card-body" id="data_form">
                                <form action="{{ route('admin.products.products.store') }}" method="post" id="content_form">
                                    @csrf
                                    <div class="row">
                                        {{-- Product Image --}}
                                        <div class="col-md-12 form-group">
                                            <label for="product_image">Product Image</label>
                                            <input type="file" name="product_image" id="product_image" class="form-control dropify"> <span class="text-danger">Product Image must be under 2000 KB and width & hieght can not be greater then 1900 pixel </span>
                                        </div>

                                        {{-- Product Name --}}
                                        <div class="col-md-6 form-group">
                                            <label for="product_name">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" name="product_name" id="product_name" class="form-control" required placeholder="Enter Product Name">
                                        </div>

                                        {{-- Product Code --}}
                                        <div class="col-md-6 form-group">
                                            <label for="product_code">Product Code <span class="text-danger">*</span></label>
                                            <div class="input-group"  data-target-input="nearest">
                                                <input data-parsley-errors-container="#product_code_error" type="text" name="product_code" id="product_code" class="form-control" required placeholder="Enter Product Name">
                                                <div class="input-group-append generate_random_number" style="cursor: pointer;" data-target="#timepicker" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-repeat"></i></div>
                                                </div>
                                            </div>
                                            <span id="product_code_error"></span>
                                        </div>

                                        {{-- Product Cost --}}
                                        <div class="col-md-6 form-group">
                                            <label for="product_cost">Product Cost <span class="text-danger">*</span></label>
                                            <input type="text" name="product_cost" id="product_cost" class="form-control input_number" required placeholder="Enter Product Cost">
                                        </div>

                                        {{-- Product Price --}}
                                        <div class="col-md-6 form-group">
                                            <label for="product_price">Product Price <span class="text-danger">*</span></label>
                                            <input type="text" name="product_price" id="product_price" class="form-control input_number" required placeholder="Enter Product Price">
                                        </div>

                                        {{-- Product Category --}}
                                        <div class="col-md-6 form-group">
                                            <label for="product_category_id">Product Category</label>
                                            <div class="input-group"  data-target-input="nearest">
                                                <select name="product_category_id" data-placeholder="Select Category" id="product_category_id" class="form-control" >
                                                    <option value="">Select Category</option>
                                                    <option selected value="0">No Category</option>
                                                    @php
                                                        $category_query = App\Models\Products\Category::select('id', 'category_name')->where('status', 1)->get();
                                                    @endphp
                                                    @foreach ($category_query as $item)
                                                        <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                                    @endforeach
                                                </select>
                                                <div data-url="{{ route('admin.products.products.add_category') }}" title="Add New Category" class="input-group-append content_manage" style="cursor: pointer;">
                                                    <div class="input-group-text"><i class="fa fa-plus"></i></div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Product Supplier --}}
                                        <div class="col-md-6 form-group">
                                            <label for="supplier_id">Product Supplier</label>
                                            <div class="input-group"  data-target-input="nearest">
                                                <select name="supplier_id" data-placeholder="Select Category" id="supplier_id" class="form-control">
                                                    <option value="">Select Supplier</option>
                                                    <option selected value="0">No Supplier</option>
                                                    @php
                                                        $supplier_query = App\Models\Supplier::select('id', 'sup_name')->where('status', 1)->get();
                                                    @endphp
                                                    @foreach ($supplier_query as $item)
                                                        <option value="{{ $item->id }}">{{ $item->sup_name }}</option>
                                                    @endforeach
                                                </select>
                                                <div data-url="{{ route('admin.products.products.add_supplier') }}" title="Add New Supplier" class="input-group-append content_manage" style="cursor: pointer;">
                                                    <div class="input-group-text"><i class="fa fa-plus"></i></div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Product Brand --}}
                                        <div class="col-md-6 form-group">
                                            <label for="brand_id">Product Brand</label>
                                            <div class="input-group"  data-target-input="nearest">
                                                <select name="brand_id" data-placeholder="Select Brand" id="brand_id" class="form-control">
                                                    <option value="">Select Brand</option>
                                                    <option selected value="0">No Brand</option>
                                                    @php
                                                        $supplier_query = App\Models\Products\Brand::select('id', 'brand_name')->where('status', 1)->get();
                                                    @endphp
                                                    @foreach ($supplier_query as $item)
                                                        <option value="{{ $item->id }}">{{ $item->brand_name }}</option>
                                                    @endforeach
                                                </select>
                                                <div data-url="{{ route('admin.products.products.add_brand') }}" title="Add New Brand" class="input-group-append content_manage" style="cursor: pointer;">
                                                    <div class="input-group-text"><i class="fa fa-plus"></i></div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Barcode Symbiology --}}
                                   

                                        {{-- Product Box --}}
                                        <div class="col-md-6 form-group">
                                            <label for="box_id">Product Box</label>
                                            <div class="input-group"  data-target-input="nearest">
                                                <select name="box_id" data-placeholder="Select Box" id="box_id" class="form-control">
                                                    <option value="">Select Box</option>
                                                    <option selected value="0">No Box</option>
                                                    @php
                                                        $supplier_query = App\Models\Products\Box::select('id', 'box_name')->where('status', 1)->get();
                                                    @endphp
                                                    @foreach ($supplier_query as $item)
                                                        <option value="{{ $item->id }}">{{ $item->box_name }}</option>
                                                    @endforeach
                                                </select>
                                                <div data-url="{{ route('admin.products.products.add_box') }}" title="Add New Box" class="input-group-append content_manage" style="cursor: pointer;">
                                                    <div class="input-group-text"><i class="fa fa-plus"></i></div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Product Unit --}}
                                        <div class="col-md-6 form-group">
                                            <label for="box_id">Product Unit</label>
                                            <div class="input-group"  data-target-input="nearest">
                                                <select name="unit_id" data-placeholder="Select Unit" id="unit_id" class="form-control">
                                                    <option value="">Select Unit</option>
                                                    <option selected value="0">No Unit</option>
                                                    @php
                                                        $supplier_query = App\Models\Products\Unit::select('id', 'unit_name')->where('status', 1)->get();
                                                    @endphp
                                                    @foreach ($supplier_query as $item)
                                                        <option value="{{ $item->id }}">{{ $item->unit_name }}</option>
                                                    @endforeach
                                                </select>
                                                <div data-url="{{ route('admin.products.products.add_unit') }}" title="Add New Box" class="input-group-append content_manage" style="cursor: pointer;">
                                                    <div class="input-group-text"><i class="fa fa-plus"></i></div>
                                                </div>
                                            </div>
                                        </div>

                         

                                        {{-- Stock Alert --}}
                                        <div class="col-md-6 form-group">
                                            <label for="opening">Opening Stock <span class="text-danger"></span></label>
                                            <input type="text" autocomplete="off" name="opening" id="opening" class="form-control" required placeholder="Enter Product Opening Stock">
                                        </div>

            
                                        <div class="col-md-12 form-group">
                                            <label for="product_details">Product Description</label>
                                            <textarea name="product_details" id="product_details" class="form-control summernote" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>

                                    <button type="submit" id="submit" class="px-5 btn btn-primary float-right"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Submit</button>
                                    <button type="button" id="submiting" class="px-5 btn btn-sm btn-info float-right" id="submiting" style="display: none;">
                                        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

                                    <button type="button" class="btn btn-sm btn-danger" id="close">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan

                <div class="card card-primary">
                    <a class="bg-primary" data-toggle="collapse" data-parent="#accordion" href="#list">
                        <div class="card-header">
                            <h4 class="card-title">
                                Product List
                            </h4>
                        </div>
                    </a>
                    <div id="list" class="panel-collapse collapse">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.products.products.datatable') }}">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Supplier</th>
                                            <th>Stock</th>
                                            <th>P. Cost</th>
                                            <th>P. Price</th>
                                            <th>Opening.S</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Supplier</th>
                                            <th>Stock</th>
                                            <th>P. Cost</th>
                                            <th>P. Price</th>
                                            <th>Opening.S</th>
                                            <th>Action</th>
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
<script src="{{ asset('js/pages/product/product.js') }}"></script>
@endpush
