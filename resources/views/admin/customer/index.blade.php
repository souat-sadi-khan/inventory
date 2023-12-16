@extends('layouts.main', ['title' => ('Customer Manage'), 'modal' => 'xl',])

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
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Or Manage Customer's</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="accordion">
                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                 @can('customer.create')
                    <div class="card card-info">
                        <a class="bg-info" data-toggle="collapse" data-parent="#accordion" href="#create">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Create New Customer
                                </h4>
                            </div>
                        </a>
                        <div id="create" class="panel-collapse collapse in">
                            <div class="card-body">
                                <form action="{{ route('admin.customer.store') }}" method="post" id="content_form">
                                    @csrf
                                    <div class="row">
                                        {{-- Name --}}
                                        <div class="col-md-6 form-group">
                                            <label for="customer_name">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Enter Customer Name" required>
                                        </div>

                                        {{-- Opening Balance --}}
                                        {{-- <div class="col-md-6 form-group">
                                            <label for="net_total">Opening Balance</label>
                                            <input autocomplete="off" type="text" name="net_total" id="net_total" class="form-control" placeholder="Enter Customer Opening Balance" value="">
                                        </div> --}}

                                        {{-- Phone --}}
                                        <div class="col-md-6 form-group">
                                            <label for="customer_mobile">Phone <span class="text-danger">*</span></label>
                                            <input type="text" name="customer_mobile" id="customer_mobile" class="form-control" placeholder="Enter Customer Phone" required>
                                        </div>

                                        {{-- Date of Birth --}}
                                        <div class="col-md-6 form-group">
                                            <label for="date_of_birth">Date of Birth </label>
                                            <input type="text" name="date_of_birth" id="date_of_birth" class="form-control take_date" placeholder="Enter Customer Date of Birth">
                                        </div>

                                        {{-- Email --}}
                                        <div class="col-md-6 form-group">
                                            <label for="customer_email">Email</label>
                                            <input type="email" name="customer_email" id="customer_email" class="form-control" placeholder="Enter Customer Email">
                                        </div>

                                        {{-- Sex --}}
                                        <div class="col-md-4 form-group">
                                            <label for="customer_sex">Sex</label>
                                            <select name="customer_sex" id="customer_sex" class="form-control select" data-placeholder="Select Sex">
                                                <option value="">Select Sex</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        {{-- Age --}}
                                        <div class="col-md-4 form-group">
                                            <label for="customer_age">Age</label>
                                            <input type="text" name="customer_age" id="customer_age" class="form-control" placeholder="Enter Customer Age">
                                        </div>

                                        {{-- Gtin --}}
                                        <div class="col-md-4 form-group">
                                            <label for="gtin">Gtin</label>
                                            <input type="text" name="gtin" id="gtin" class="form-control" placeholder="Enter Customer Gtin">
                                        </div>

                                        {{-- Address --}}
                                        <div class="col-md-12 form-group">
                                            <label for="customer_address">Address</label>
                                            <textarea name="customer_address" id="customer_address" class="form-control" placeholder="Ener Customer Address" cols="30" rows="2"></textarea>
                                        </div>

                                        {{-- City --}}
                                        <div class="col-md-6 form-group">
                                            <label for="customer_city">City</label>
                                            <input type="text" name="customer_city" id="customer_city" class="form-control" placeholder="Enter Customer City">
                                        </div>

                                        {{-- State --}}
                                        <div class="col-md-6 form-group">
                                            <label for="customer_state">State</label>
                                            <input type="text" name="customer_state" id="customer_state" class="form-control" placeholder="Enter Customer State">
                                        </div>

                                        {{-- Country --}}
                                        <div class="col-md-6 form-group">
                                            <label for="customer_country">Country</label>
                                            <input type="text" name="customer_country" id="customer_country" class="form-control" placeholder="Enter Customer Country" value="Bangladesh">
                                        </div>

                                        {{-- Status --}}
                                        <div class="col-md-6 form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select data-parsley-errors-container="#customer_status_save_error" required name="status" id="status" class="form-control select" data-placeholder="Select Customer Status">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <span id="customer_status_save_error"></span>
                                        </div>
                                    </div>

                                    <button type="submit" id="submit" class="btn btn-primary float-right px-5">Submit</button>
                                    <button type="button" id="submiting" class="btn btn-sm btn-info float-right px-5" id="submiting" style="display: none;">
                                        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

                                    <button type="button" class="btn btn-sm btn-danger" id="close">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                 @endcan
                @can('customer.view')
                <div class="card card-primary">
                    <a class="bg-primary" data-toggle="collapse" data-parent="#accordion" href="#list">
                        <div class="card-header">
                            <h4 class="card-title">
                                Customer List
                            </h4>
                        </div>
                    </a>
                    <div id="list" class="panel-collapse collapse">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.customer.datatable') }}">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Sale Due</th>
                                            <th>S.R Due</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Sale Due</th>
                                            <th>S.R Due</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                    @endcan
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
<script src="{{ asset('js/pages/customer.js') }}"></script>
@endpush
