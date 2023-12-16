@extends('layouts.main', ['title' => ('Loan Report'), 'modal' => 'xl',])

@push('admin.css')

@endpush

@section('header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Loan Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}"><i class="fa fa-home"
                                aria-hidden="true"></i></a></li>
                    <li class="breadcrumb-item active">Loan Report</li>
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
            <h3 class="card-title">Loan Report Show</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.report.loan_show') }}" method="get" id="">
                    <div class="row">

                        {{-- Type --}}
                        {{-- <div class="col-md-6 form-group mx-auto">
                            <label for="Type">Select Type</label>
                            <select name="type" id="Type" class="form-control select">
                                <option value="Loan_Received">Loan Received</option>
                                <option value="Loan_Pay">Loan Pay</option>
                            </select>
                        </div> --}}
                        </div>
                        <div class="row">

                        {{-- Start Date --}}
                        <div class="col-md-6 form-group">
                            <label for="start_date">Start Date</label>
                            <input type="text" name="start_date" id="start_date" class="form-control take_date" value="{{date('Y-m-d')}}" required placeholder="Enter Start Date">
                        </div>

                        {{-- End Date --}}
                        <div class="col-md-6 form-group">
                            <label for="end_date">End Date</label>
                            <input type="text" name="end_date" id="end_date" class="form-control take_date" value="{{date('Y-m-d')}}" required placeholder="Enter End Date">  
                        </div>
                    </div>

                <button type="submit" id="submit" class="btn btn-primary float-right  px-5"><i class="fa fa-search mr-3" aria-hidden="true"></i>Search Now</button>
                <button type="button" id="submiting" class="btn btn-sm  btn-info float-right" id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection

@push('admin.scripts')
<script src="{{ asset('js/pages/account.js') }}"></script> 
@endpush
