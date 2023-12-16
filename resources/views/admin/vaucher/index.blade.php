@extends('layouts.main', ['title' => ('Account Vaucher Manage'), 'modal' => 'xl',])

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
            <h3 class="card-title">Create Or Manage Account's Vaucher</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="accordion" class="row">
                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment" data-url="{{ route('admin.vaucher.opening_balance') }}" class="btn btn-block btn-sm btn-info py-3 " href="" title="Create Opening Balance">
                                <i class="fa fa-money"></i> Opening Balance
                            </a>
                    </div>
                </div>
                <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment1" data-url="{{ route('admin.vaucher.deposit') }}" class="btn btn-block btn-sm btn-success py-3 " href="" title="Create Payment">
                                <i class="fa fa-hand-o-up"></i> Cash Payment
                            </a>
                    </div>
                </div>
                
                <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment1" data-url="{{ route('admin.vaucher.withdraw') }}" class="btn btn-block btn-sm btn-danger py-3" href="" title="Create Received">
                                <i class="fa fa-telegram"></i> Cash Received
                            </a>
                    </div>
                </div>

                <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment1" data-url="{{ route('admin.vaucher.contra') }}" class="btn btn-block btn-sm btn-warning py-3" href="" title="Create Contra">
                                <i class="fa fa-expand"></i> Contra
                            </a>
                    </div>
                </div>

                <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment1" data-url="{{ route('admin.vaucher.journal') }}" class="btn btn-block btn-sm btn-primary py-3" href="" title="Create Journal Vaucher">
                                <i class="fa fa-expand"></i> Journal Vaucher
                            </a>
                    </div>
                </div>

                {{-- <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment1" data-url="{{ route('admin.vaucher.debit') }}" class="btn btn-block btn-sm btn-secondary py-3" href="" title="Create Debit Note">
                                <i class="fa fa-plus"></i> Debit Note
                            </a>
                    </div>
                </div>
                <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment1" data-url="{{ route('admin.vaucher.credit') }}" class="btn btn-block btn-sm  btn-info py-3" href="" title="Create Credit Note">
                                <i class="fa fa-plus"></i> Credit Note
                            </a>
                    </div>
                </div>

                <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button"  href="{{ route('admin.fiexd-assets.index') }}" class="btn btn-block btn-sm btn-success py-3" href="" title="Create Fiexd Assets">
                                <i class="fa fa-plus"></i> Fiexd Assets
                            </a>
                    </div>
                </div> --}}

                <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment1" data-url="{{ route('admin.vaucher.vaucher') }}" class="btn btn-block btn-sm btn-success py-3" href="" title="Create Vaucher Entry">
                                <i class="fa fa-plus"></i> Vaucher Entry
                            </a>
                    </div>
                </div> 


                 <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment1" data-url="{{ route('admin.vaucher.income') }}" class="btn btn-block btn-sm btn-success py-3" href="" title="Create Income">
                                <i class="fa fa-plus"></i> Income
                            </a>
                    </div>
                </div>

                 <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment1" data-url="{{ route('admin.vaucher.expense') }}" class="btn btn-block btn-sm btn-danger py-3" href="" title="Create Expense">
                                <i class="fa fa-plus"></i> Expense
                            </a>
                    </div>
                </div>

                 <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment1" data-url="{{ route('admin.vaucher.loan') }}" class="btn btn-block btn-sm btn-primary py-3" href="" title="Create Loan Received">
                                <i class="fa fa-plus"></i> Loan Received
                            </a>
                    </div>
                </div>

                 <div class="col-sm-3 border-">
                    <div class="description-block mx-2 my-3" style="font-size: 12px;">
                        <a role="button" id="content_managment1" data-url="{{ route('admin.vaucher.loan_pay') }}" class="btn btn-block btn-sm btn-info py-3" href="" title="Create Loan Received">
                                <i class="fa fa-plus"></i> Loan Pay
                            </a>
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
