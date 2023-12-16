@extends('layouts.main', ['title' => ('Account Manage'), 'modal' => 'xl',])

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
            <h3 class="card-title">Create Or Manage Account's</h3>
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
                                Create New Account
                            </h4>
                        </div>
                    </a>
                    <div id="create" class="panel-collapse collapse in">
                        <div class="card-body">
                            <form action="{{ route('admin.account.store') }}" method="post" id="content_form">
                                @csrf
                                <div class="row">
                                    {{-- Account Type --}}
                                    <div class="col-md-6 form-group">
                                        <label for="category">Account Type
                                        </label>
                                        <div class="input-group">
                                            <select name="category" id="category" data-placeholder="Please Select One.."
                                                class="form-control select">
                                                <option value="">Please Select One .. </option>
                                                <option value="Bank_Account">Bank Account </option>
                                                <option value="Current_Assets">Current Assets </option>
                                                <option value="Current_Liabilities">Current Liabilities
                                                </option>
                                                <option value="Direct_Income">Direct Income </option>
                                                <option value="Direct_Expanses">Direct Expanses </option>
                                                <option value="Unsecured_Loans">Unsecured Loans </option>
                                                <option value="Employee">Employee </option>
                                                <option value="Fixed_Assets">Fixed Assets </option>
                                                <option value="Duties_Taxes">Duties & Taxes </option>
                                                <option value="Capital_Account">Capital Account </option>
                                                <option value="Investment">Investment </option>
                                            </select>
                                        </div>
                                    </div>


                                    {{-- Account Name --}}
                                    <div class="col-md-6 form-group">
                                        <label id="account" for="account_name">Account Name <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="account_name" id="account_name" class="form-control"
                                            placeholder="Enter Account Name" required>
                                    </div>

                                    {{-- Display Name --}}
                                    <div class="col-md-6 form-group" id="display">
                                        <label for="display_name">Display Name <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="display_name" id="display_name" class="form-control"
                                            placeholder="Enter Display Name" required>
                                    </div>

                                    {{-- Alias --}}
                                    <div class="col-md-6 form-group " id="alias_show">
                                        <label for="alias">Alias <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="alias" id="alias" class="form-control"
                                            placeholder="Enter Alias" required>
                                    </div>


                                    {{-- For Bank Accout    --}}
                                    {{-- Account no --}}
                                    <div class="col-md-6 form-group bank_show" style="display: none;">
                                        <label for="account_no">Account No <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="account_no" id="account_no" class="form-control"
                                            placeholder="Enter Account No">
                                    </div>
                                    {{-- Check Form --}}
                                    <div class="col-md-6 form-group bank_show" style="display: none;">
                                        <label for="check_form">Check Form <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="check_form" id="check_form" class="form-control"
                                            placeholder="Enter Check Form">
                                    </div>
                                    {{-- Check To --}}
                                    <div class="col-md-6 form-group bank_show" style="display: none;">
                                        <label for="check_to">Check To <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="check_to" id="check_to" class="form-control"
                                            placeholder="Enter Check To">
                                    </div>

                                    {{-- Customer Section --}}

                                    {{-- Phone --}}
                                    <div class="col-md-6 form-group customer_show" style="display: none;">
                                        <label for="phone">Phone <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            placeholder="Enter Phone">
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-6 form-group customer_show" style="display: none;">
                                        <label for="email">Email <span class="text-danger"></span>
                                        </label>
                                        <input type="text" name="email" id="email" class="form-control"
                                            placeholder="Enter Email">
                                    </div>


                                    {{-- Opening Date --}}
                                    <div class="col-md-6 form-group " id="opening_date_show">
                                        <label for="opening_date">Opening Date <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="opening_date" id="opening_date"
                                    class="form-control take_date" value="{{date("Y-m-d")}}" placeholder="Enter Opening Date" required>
                                    </div>


                                    {{-- Salary --}}
                                    <div class="col-md-6 form-group customer_show" style="display: none;">
                                        <label for="salary">Salary <span class="text-danger"></span>
                                        </label>
                                        <input type="text" name="salary" id="salary" class="form-control"
                                            placeholder="Enter Salary">
                                    </div>

                                    {{-- Address --}}
                                    <div class="col-md-12 form-group customer_show" style="display: none;">
                                        <label for="address">Address <span class="text-danger"></span>
                                        </label>
                                            <textarea name="address" class="form-control" id="address" ></textarea>
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
                                Account List
                            </h4>
                        </div>
                    </a>
                    <div id="list" class="panel-collapse collapse">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table"
                                    data-url="{{ route('admin.account.datatable') }}">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>No. Of Account</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>No. Of Account</th>
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
<script src="{{ asset('js/pages/account.js') }}"></script>
<script>
    $('#account_name').keyup(function() {
        var val = $(this).val();
        $('#display_name').val(val);
    })
</script>
@endpush
