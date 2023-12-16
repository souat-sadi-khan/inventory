@extends('layouts.main', ['title' => ('Loan Manage'), 'modal' => 'xl',])

@push('admin.css')
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Loan Manage</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fa fa-home"
                                aria-hidden="true"></i></a></li>
                    <li class="breadcrumb-item active">Loan</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Or Manage Loan</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="accordion">
                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                <div class="card card-info">
                    <a class="bg-info" data-toggle="collapse" data-parent="#accordion" href="#create">
                    <div class="card-header">
                        <h4 class="card-title">
                                Create New Loan
                        </h4>
                    </div>
                </a>
                    <div id="create" class="panel-collapse collapse in">
                        <div class="card-body">
                            <form action="{{ route('admin.loan.store') }}" method="post" id="content_form">
                                @csrf
                                <div class="row">
                                    {{-- Date --}}
                                    <div class="col-md-6 form-group">
                                        <label for="date">{{ __('Date') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="date" id="date" class="form-control take_date" required value="{{date('Y-m-d')}}">
                                    </div>
    
                                    {{-- Loan From --}}
                                    <div class="col-md-6 form-group">
                                        <label for="loan_from">{{ __('From Loan') }} <span class="text-danger">*</span></label>
                                        <select data-parsley-errors-container="#loan_form_error" name="loan_from" id="loan_from" class="form-control select" required data-placeholder="Please Select One">
                                            <option value="">{{ __('Please Select One') }}</option>
                                            <option value="Bank">{{ __('Bank') }}</option>
                                            <option value="NGO">{{ __('NGO') }}</option>
                                            <option value="Person">{{ __('Person') }}</option>
                                            <option value="Other">{{ __('Other') }}</option>
                                        </select>
                                        <span id="loan_form_error"></span>
                                    </div>
    
                                    {{-- Reference Number --}}
                                    <div class="col-md-6 form-group">
                                        <label for="ref_no">{{ __('Reference Number')}}</label>
                                        <input type="text" name="ref_no" id="ref_no" class="form-control" placeholder="Enter Reference Number">
                                    </div>
    
                                    {{-- Title --}}
                                    <div class="col-md-6 form-group">
                                        <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter Loan Title" required>
                                    </div>
    
                                    {{-- Amount --}}
                                    <div class="col-md-4 form-group">
                                        <label for="amount">{{ __('Amount') }} <span class="text-danger">*</span></label>
                                        <input required type="number" id="amount" name="amount" class="form-control" placeholder="Enter Loan Amount">
                                    </div>
    
                                    {{-- Interest --}}
                                    <div class="col-md-4 form-group">
                                        <label for="interest">{{ __('Interest') }} (%) <span class="text-danger">*</span></label>
                                        <input required type="number" id="interest" name="interest" class="form-control" placeholder="Enter Interest Percen">
                                    </div>
    
                                    {{-- Payable --}}
                                    <div class="col-md-4 form-group">
                                        <label for="payable">{{ __('Payable') }} <span class="text-danger">*</span></label>
                                        <input type="text" readonly required placeholder="Enter Payable Amount" class="form-control" id="payable" name="payable">
                                    </div>
    
                                    {{-- Details --}}
                                    <div class="col-md-12 form-group">
                                        <label for="details">{{ __('Details') }}</label>
                                        <textarea name="details" id="details" class="form-control" cols="30" rows="2" placeholder="Enter Description"></textarea>
                                    </div>
    
                                    {{-- Attatchment --}}
                                    <div class="col-md-12 form-group">
                                        <label for="attatchment">{{ __('Attatchment') }}</label>
                                        <input type="file" name="attatchment" id="attatchment" class="form-control dropify">
                                    </div>
    
                                </div>
                                <button type="submit" id="submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Submit</button>
                                <button type="button" id="submiting" class="btn btn-sm btn-info float-right px-5" id="submiting" style="display: none;">
                                    <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
                            
                                <button type="button" class="btn btn-sm btn-danger" id="close">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card card-primary">
                    <a class="bg-primary" data-toggle="collapse" data-parent="#accordion" href="#list">
                        <div class="card-header">
                            <h4 class="card-title">
                                Loan List 
                            </h4>
                        </div>
                    </a>
                    <div id="list" class="panel-collapse collapse">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.loan.datatable') }}">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Loan From</th>
                                            <th>Basic Amount</th>
                                            <th>Interest (%)</th>
                                            <th>Payable</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Loan From</th>
                                            <th>Basic Amount</th>
                                            <th>Interest (%)</th>
                                            <th>Payable</th>
                                            <th>Paid</th>
                                            <th>Due</th>
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
<script src="{{ asset('js/pages/loan.js') }}"></script>
@endpush
