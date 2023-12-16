@extends('layouts.main', ['title' => ('Vehicle Transaction Manage'), 'modal' => 'xl',])

@push('admin.css')
<link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('header')
<a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i
        class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
<a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club"
        aria-hidden="true"></i>@lang('Today')</a>
<a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank"
    class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play"
        aria-hidden="true"></i>@lang('Tutorial')</a>
<a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle"
        aria-hidden="true"></i>@lang('Help')</a>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Or Manage Vehicle Transaction's</h3>
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
                                Create New Vehicle Transaction
                            </h4>
                        </div>
                    </a>
                    <div id="create" class="panel-collapse collapse in">
                        <div class="card-body">
                            <form action="{{ route('admin.vehicle-transaction.store') }}" method="post"
                                id="content_form">
                                @csrf
                                <div class="row">
                                    {{-- Status --}}
                                    <div class="col-md-6 form-group mx-auto">
                                        <label for="type">Transaction Type <span class="text-danger">*</span></label>
                                        <select data-parsley-errors-container="#Vehicle_Transactionsave_error" required
                                            name="type" id="type" class="form-control select"
                                            data-placeholder="Select Transaction Type">
                                            <option value="Income">Income</option>
                                            <option value="Expence">Expence</option>
                                        </select>
                                        <span id="Vehicle_Transactionsave_error"></span>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead class="bg-gray">
                                                <tr>
                                                    <td>
                                                        <label for="vehicle_id">Vehicle List <span
                                                                class="text-danger">*</span></label>
                                                        <select name="vehicle_id" id="vehicle_id"
                                                            class="form-control select"
                                                            data-placeholder="Select Vehicle">
                                                            <option value="">Select Vehicle</option>
                                                            @foreach ($models as $model)
                                                            <option value="{{ $model->id}}">{{$model->name}}  ({{$model->type->name}})</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="product_error"></span>
                                                    </td>
                                                    <td>
                                                        <label for="description">Description <span
                                                                class="text-danger">*</span></label>
                                                        <input autocomplete="off" type="text" name="description"
                                                            id="description" class="form-control"
                                                            placeholder="Enter Description">
                                                    </td>
                                                    <td>
                                                        <label for="amount"> Amount <span
                                                                class="text-danger">*</span></label>
                                                        <input autocomplete="off" type="text" name="amount" id="amount"
                                                            class="form-control input_number"
                                                            placeholder="Enter  Amount">
                                                    </td>
                                                    <td>
                                                       
                                                            <label for="date"> Date
                                                            </label>
                                                            <input type="text" name="date" id="date"
                                                                class="form-control take_date" value="{{date('Y-m-d')}}"
                                                                placeholder="Enter  Date">
                                                        
                                                    </td>


                                                    <td>
                                                        <input type="hidden" id='url'
                                                            data-url="{{ route('admin.vehicle-transaction.data') }}">
                                                        <button type="button" id="click_here"
                                                            class="btn btn-info btn-sm mt-4">Click Add</button>
                                                        <button type="button" class="btn btn-sm btn-info" id="submitted"
                                                            style="display: none;">
                                                            <i
                                                                class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <h5 class="bg-primary text-center mt-4">
                                    Vehicle Transaction List
                                </h5>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead class="bg-green">
                                                <tr>
                                                    <th>Vehicle </th>
                                                    <th>Description </th>
                                                    <th>Amount</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-gray" id="pursesDetailsRender">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mx-auto text-center">

                                        <button type="submit" class="btn btn-primary btn-sm w-100" id="submit">Vehicle Transaction Save </button>
                                        <button type="button" class="btn btn-sm btn-info w-100" id="submiting"
                                            style="display: none;">
                                            <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
                                    </div>
                                </div>
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
                                    data-url="{{ route('admin.vehicle-transaction.datatable') }}">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Vehicle</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Vehicle</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Date</th>
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
<script src="{{ asset('js/pages/vehicle/vehicle-transaction.js') }}"></script>
@endpush
