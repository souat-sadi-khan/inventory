@extends('layouts.main', ['title' => ('Report'), 'modal' => 'xl',])
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
            <h3 class="card-title">Show All Report</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                            <h5 class="card-text">Trial Balance</h5>
                            <a href="{{ route('admin.report.trial_balance') }}" class="btn btn-success">Go To Report</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                            <h5 class="card-text">Ledger Book</h5>
                            <a href="{{ route('admin.report.ledger_book') }}" class="btn btn-success">Go To Report</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                            <h5 class="card-text">Day Book</h5>
                            <a href="{{ route('admin.report.day_book') }}" class="btn btn-success">Go To Report</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                            <h5 class="card-text">Cash & Bank book</h5>
                            <a href="{{ route('admin.report.cashbank_book') }}" class="btn btn-success">Go To Report</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                            <h5 class="card-text">Recipt / Payment Register</h5>
                            <a href="{{ route('admin.report.recept_payment') }}" class="btn btn-success">Go To
                            Report</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                            <h5 class="card-text">Sales Register</h5>
                            <a href="{{ route('admin.report.sales_report') }}" class="btn btn-success"><span class="badge badge-info"><i class="fa fa-align-right"></i></span>Go To
                        Report</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card border border-primary">
                    <div class="card-body text-center">
                        <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                        <h5 class="card-text">Purchase Register</h5>
                        <a href="{{ route('admin.report.purchase_report') }}" class="btn btn-success"><span class="badge badge-info"><i class="fa fa-align-right"></i></span>Go To
                    Report</a>
                </div>
            </div>
        </div>

         <div class="col-sm-4">
                <div class="card border border-primary">
                    <div class="card-body text-center">
                        <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                        <h5 class="card-text">Profit Loss</h5>
                        <a href="{{ route('admin.report.profit_loss') }}" class="btn btn-success"><span class="badge badge-info"></span>Go To
                    Report</a>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
                <div class="card border border-primary">
                    <div class="card-body text-center">
                        <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                        <h5 class="card-text">Product Report</h5>
                        <a href="{{ route('admin.report.product_report') }}" class="btn btn-success"><span class="badge badge-info"></span>Go To
                    Report</a>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card border border-primary">
                <div class="card-body text-center">
                    <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                    <h5 class="card-text">Today Product Report</h5>
                    <a href="{{ route('admin.report.today_product_report') }}" class="btn btn-success"><span class="badge badge-info"></span>Go To
                Report</a>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
                <div class="card border border-primary">
                    <div class="card-body text-center">
                        <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                        <h5 class="card-text">Vehicle Report</h5>
                        <a href="{{ route('admin.report.vehicle') }}" class="btn btn-success"><span class="badge badge-info"></span>Go To
                    Report</a>
                </div>
            </div>
        </div>


        <div class="col-sm-4">
                <div class="card border border-primary">
                    <div class="card-body text-center">
                        <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                        <h5 class="card-text">Vehicle Expance/Income Report</h5>
                        <a href="{{ route('admin.report.vehicle-income') }}" class="btn btn-success"><span class="badge badge-info"></span>Go To
                    Report</a>
                </div>
            </div>
        </div>



        {{-- Customer report --}}
        <div class="col-sm-4">
            <div class="card border border-primary">
                <div class="card-body text-center">
                    <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                    <h5 class="card-text">Customer Report</h5>
                    <a href="{{ route('admin.report.customre-due') }}" class="btn btn-success"><span class="badge badge-info"></span>Go To
                Report</a>
                </div>
            </div>
        </div>

        {{-- Supplier Report --}}
        <div class="col-sm-4">
            <div class="card border border-primary">
                <div class="card-body text-center">
                    <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                    <h5 class="card-text">Supplier Report</h5>
                    <a href="{{ route('admin.report.supplier-due') }}" class="btn btn-success"><span class="badge badge-info"></span>Go To
                Report</a>
                </div>
            </div>
        </div>
         <div class="col-sm-4">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                            <h5 class="card-text">Loan Register</h5>
                            <a href="{{ route('admin.report.loan') }}" class="btn btn-success">Go To
                            Report</a>
                        </div>
                    </div>
                </div>

        {{-- Direct Income Report --}}
        <div class="col-sm-4">
            <div class="card border border-primary">
                <div class="card-body text-center">
                    <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                    <h5 class="card-text">Direct Income Report</h5>
                    <a href="{{ route('admin.report.direct-income') }}" class="btn btn-success"><span class="badge badge-info"></span>Go To
                Report</a>
                </div>
            </div>
        </div>

        {{-- Direct Expense Report --}}
        <div class="col-sm-4">
            <div class="card border border-primary">
                <div class="card-body text-center">
                    <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                    <h5 class="card-text">Direct Expense Report</h5>
                    <a href="{{ route('admin.report.direct-expense') }}" class="btn btn-success"><span class="badge badge-info"></span>Go To
                Report</a>
                </div>
            </div>
        </div>

         <div class="col-sm-4">
            <div class="card border border-primary">
                <div class="card-body text-center">
                    <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                    <h5 class="card-text">Balance Sheet</h5>
                    <a href="{{ route('admin.report.balance_sheet') }}" class="btn btn-success">Go To
                    Report</a>
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
<script src="{{ asset('js/pages/vaucher.js') }}"></script>
@endpush
