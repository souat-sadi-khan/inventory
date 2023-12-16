@extends('layouts.main', ['title' => ('Purchase Report'), 'modal' => 'xl',])
@push('admin.css')
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
            <h3 class="card-title">Show Purchase Report</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="row">
                <div class="col-sm-4">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                            <h5 class="card-text">Purchase Report</h5>
                            <a href="{{ route('admin.report.purchase') }}" class="btn btn-success">Go To Report</a>
                        </div>
                    </div>
                </div>


                   <div class="col-sm-4">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                            <h5 class="card-text">Purchase Payment Report</h5>
                            <a href="{{ route('admin.report.purchase_payment') }}" class="btn btn-success">Go To Report</a>
                        </div>
                    </div>
                </div>


                   <div class="col-sm-4">
                    <div class="card border border-primary">
                        <div class="card-body text-center">
                            <i class="fa fa-registered fa-4x" aria-hidden="true"></i> <br>
                            <h5 class="card-text">Purchase Return Report</h5>
                            <a href="{{ route('admin.report.purchase_return') }}" class="btn btn-success">Go To Report</a>
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

@endpush
