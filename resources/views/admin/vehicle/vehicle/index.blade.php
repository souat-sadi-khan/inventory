@extends('layouts.main', ['title' => ('Vehicle Manage'), 'modal' => 'xl',])

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
            <h3 class="card-title">Create Or Manage Vehicle's</h3>
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
                                Create New Vehicle
                            </h4>
                        </div>
                    </a>
                    <div id="create" class="panel-collapse collapse in">
                        <div class="card-body">
                            <form action="{{ route('admin.vehicle.store') }}" method="post" id="content_form">
                                @csrf
                                <div class="row">


                                    {{-- Vehicle Type --}}
                                        <div class="col-md-6 form-group">
                                            <label for="vehicle_type_id">Vehicle Type <span class="text-danger">*</span></label>
                                            <select data-parsley-errors-container="#Vehicle_type_save_error" required name="vehicle_type_id" id="vehicle_type_id" class="form-control select" data-placeholder="Select Vehicle Type">
                                                <option value="">Select Vehicle Type </option>
                                                @foreach ($models as $model)
                                                <option value="{{$model->id}}">{{$model->name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="Vehicle_type_save_error"></span>
                                        </div>

                                         {{--  Vehicle Name  --}}
                                    <div class="col-md-6 form-group">
                                        <label for="name"> Vehicle Name <span class="text-danger">*</span>
                                        </label>
                                       <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Enter Vehicle Name" required>
                                    </div>

                                    {{--  Registrarion Number  --}}
                                    <div class="col-md-6 form-group">
                                        <label for="regi_no"> Registrarion Number <span class="text-danger">*</span>
                                        </label>
                                       <input type="text" name="regi_no" id="regi_no" class="form-control"
                                            placeholder="Enter Registrarion Number" required>
                                    </div>

                                    {{--  Chassis Number  --}}
                                    <div class="col-md-6 form-group">
                                        <label for="chassis_no"> Chassis Number 
                                        </label>
                                       <input type="text" name="chassis_no" id="chassis_no" class="form-control"
                                            placeholder="Enter Chassis Number" >
                                    </div>

                                    {{--  Model Number  --}}
                                    <div class="col-md-6 form-group">
                                        <label for="model_no"> Model Number <span class="text-danger">*</span>
                                        </label>
                                       <input type="text" name="model_no" id="model_no" class="form-control"
                                            placeholder="Enter Model Number" required>
                                    </div>

                                    {{--  Engine Number  --}}
                                    <div class="col-md-6 form-group">
                                        <label for="engine_no"> Engine Number <span class="text-danger">*</span>
                                        </label>
                                       <input type="text" name="engine_no" id="engine_no" class="form-control"
                                            placeholder="Enter Engine Number">
                                    </div>

                                    {{--  License Number  --}}
                                    <div class="col-md-6 form-group">
                                        <label for="license_no"> License Number <span class="text-danger">*</span>
                                        </label>
                                       <input type="text" name="license_no" id="license_no" class="form-control"
                                            placeholder="Enter License Number">
                                    </div>

                                    {{--  License Validity  --}}
                                    <div class="col-md-6 form-group">
                                        <label for="license_validity"> License Validity 
                                        </label>
                                       <input type="text" name="license_validity" id="license_validity" class="form-control"
                                            placeholder="Enter License Validity">
                                    </div>


                                    {{--  Road Permit  --}}
                                    <div class="col-md-6 form-group">
                                        <label for="road_permit"> Road Permit 
                                        </label>
                                       <input type="text" name="road_permit" id="road_permit" class="form-control"
                                            placeholder="Enter Road Permit">
                                    </div>

                                    {{--  Total Investment  --}}
                                    <div class="col-md-6 form-group">
                                        <label for="investment"> Total Investment <span class="text-danger">*</span>
                                        </label>
                                       <input type="number" name="investment" id="investment" class="form-control"
                                            placeholder="Enter Total Investment" required>
                                    </div>

                                     
                                     {{-- Status --}}
                                        <div class="col-md-6 form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select data-parsley-errors-container="#Vehicles_status_save_error" required name="status" id="status" class="form-control select" data-placeholder="Select Vehicle Status">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                            <span id="Vehicles_status_save_error"></span>
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
                                Vehicle Type List
                            </h4>
                        </div>
                    </a>
                    <div id="list" class="panel-collapse collapse">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table"
                                    data-url="{{ route('admin.vehicle.datatable') }}">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Vehicle Type</th>
                                            <th>Vehicle Name</th>
                                            <th>Registrarion No </th>
                                            <th>Model No </th>
                                            <th>Investment</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Vehicle Type</th>
                                            <th>Vehicle Name</th>
                                            <th>Registrarion No </th>
                                            <th>Model No </th>
                                            <th>Investment</th>
                                            <th>Status</th>
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
<script src="{{ asset('js/pages/vehicle/vehicle.js') }}"></script>
@endpush
