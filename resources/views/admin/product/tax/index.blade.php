@extends('layouts.main', ['title' => ('Product Tax Manage'), 'modal' => 'xl',])

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
            <h3 class="card-title">Create Or Manage Product Tax</h3>
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
                                    Create New Product Tax
                                </h4>
                            </div>
                        </a>
                        <div id="create" class="panel-collapse collapse in">
                            <div class="card-body">
                                <form action="{{ route('admin.product-initiazile.taxrate.store') }}" method="post" id="content_form">
                                    @csrf
                                    <div class="row">

                                        {{-- Product Tax Name --}}
                                        <div class="col-md-6 form-group">
                                            <label for="tax_name">Product Tax Name <span class="text-danger">*</span></label>
                                            <input style="text-transform: uppercase;" type="text" name="tax_name" id="tax_name" class="form-control" placeholder="Enter Product Tax Name" required>
                                        </div>

                                        {{-- Product Tax Code Name --}}
                                        <div class="col-md-6 form-group">
                                            <label for="tax_code_name">Product Tax Code  </label>
                                            <input type="text" name="tax_code_name" id="tax_code_name" class="form-control" placeholder="Enter Product Tax Code Name">
                                        </div>

                                        {{-- Product Tax Rate --}}
                                        <div class="col-md-4 form-group">
                                            <label for="tax_rate">Tax Rate <span class="text-danger">*</span></label>
                                            <input type="text" autocomplete="off" name="tax_rate" id="tax_rate" class="form-control" placeholder="Enter Tax Rate" required>
                                        </div>

                                        {{-- Tax Rules --}}
                                        <div class="col-md-4 form-group">
                                            <label for="tax_rules">Tax Rule <span class="text-danger">*</span></label>
                                            <select data-parsley-errors-container="#tax_rules_error" name="tax_rules" id="tax_rules" class="form-control select" data-placeholder="Select One" required>
                                                <option value="">Select One</option>
                                                <option value="plus">Addition (+)</option>
                                                <option value="mod">Percentages (%)</option>
                                            </select>
                                            <span id="tax_rules_error"></span>
                                        </div>

                                        {{-- Status --}}
                                        <div class="col-md-4 form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select data-parsley-errors-container="#status_error" required name="status" id="status" class="form-control select" data-placeholder="Select Status">
                                                <option value="">Select Status</option>
                                                <option selected value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <span id="status_error"></span>
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
                                TaxRate List 
                            </h4>
                        </div>
                    </a>
                    <div id="list" class="panel-collapse collapse">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.product-initiazile.taxrate.datatable') }}">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Code Name</th>
                                            <th>Tax Rate</th>
                                            <th>Rule</th>
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
                                            <th>Name</th>
                                            <th>Code Name</th>
                                            <th>Tax Rate</th>
                                            <th>Rule</th>
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
<script src="{{ asset('js/pages/product/tax.js') }}"></script>
@endpush
