@extends('layouts.main', ['title' => ('Product Brand Manage'), 'modal' => 'xl',])

@push('admin.css')
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}">
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
            <h3 class="card-title">Create Or Manage Product Brand</h3>
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
                                    Create New Product Brand
                                </h4>
                            </div>
                        </a>
                        <div id="create" class="panel-collapse collapse in">
                            <div class="card-body">
                                <form action="{{ route('admin.product-initiazile.brand.store') }}" method="post" id="content_form">
                                    @csrf
                                    <div class="row">

                                        {{-- Product Brand Image --}}
                                        <div class="col-md-12 form-group">
                                            <label for="brand_image">Product Brand Image</label>
                                            <input type="file" name="brand_image" id="brand_image" class="form-control dropify"> <span class="text-danger">Brand Image must be under 500 KB and width & hieght can not be greater then 110 pixel </span>
                                        </div>

                                        {{-- Product Brand Name --}}
                                        <div class="col-md-4 form-group">
                                            <label for="brand_name">Product Brand Name <span class="text-danger">*</span></label>
                                            <input type="text" name="brand_name" id="brand_name" class="form-control" placeholder="Enter Product Brand Name" required>
                                        </div>

                                        {{-- Product Brand Code Name --}}
                                        <div class="col-md-4 form-group">
                                            <label for="brand_code_name">Product Brand Code  </label>
                                            <input type="text" name="brand_code_name" id="brand_code_name" class="form-control" placeholder="Enter Product Brand Code Name">
                                        </div>

                                        {{-- Status --}}
                                        <div class="col-md-4 form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select data-parsley-errors-container="#status_error" required name="status" id="status" class="form-control select" data-placeholder="Select Customer Status">
                                                <option value="">Select  Customer Status</option>
                                                <option selected value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <span id="status_error"></span>
                                        </div>

                                        {{-- Brand Details --}}
                                        <div class="col-md-12 form-group">
                                            <label for="brand_details">Brand Details</label>
                                            <textarea name="brand_details" id="brand_details" class="form-control" cols="30" rows="2" placeholder="Enter Brand Description"></textarea>
                                        </div>
                                    </div>

                                    <button type="submit" id="submit" class="px-5 btn btn-primary float-right">Submit</button>
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
                                Brand List 
                            </h4>
                        </div>
                    </a>
                    <div id="list" class="panel-collapse collapse">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.product-initiazile.brand.datatable') }}">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <td>Image</td>
                                            <th>Name</th>
                                            <th>No of Product</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <td>Image</td>
                                            <th>Name</th>
                                            <th>No of Product</th>
                                            <th>Status</th>
                                            <th>Created At</th>
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
<script src="{{ asset('js/pages/product/brand.js') }}"></script>
@endpush
