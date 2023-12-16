@extends('layouts.main', ['title' => 'Today'])
@push('admin.css')
<style>
#dashbord_bg{
background-image: url('{{ asset('images/bg.png') }}');
padding: 50px;
background-position: center;
background-repeat: no-repeat;
background-size: cover;
}
.btn-app {
min-width: 100% !important;
height: 106px;
font-size: 27px;
}
.card-1{
background-color: #14c1d7eb;
border: 1px solid #0192a5;
margin-bottom: 20px;
}

.card-2{
background-color: #4caf50;
border: 1px solid #028808;
margin-bottom: 20px;
}

.card-3{
background-color: #f9652c;
border: 1px solid #b93603;
margin-bottom: 20px;
}

.card-4{
background-color: #f9a72c;
border: 1px solid #c07300;
margin-bottom: 20px;
}

i.icon.fa{
float: right;
position: relative;
top: 5px;
left: -10px;
opacity: 0.5;
color: #0000008a;
}
.info h4 {
font-size: 16px;
}
.info p {
font-size: 20px;
margin-top: 10px;
}
</style>
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
<div id="dashbord_bg">
    <div class="box bg-white p-3 rounded">
        <div class="row">
            <div class="col-md-6">
                <div class="card-1 pt-2 text-white rounded"><i class="icon fa fa-bar-chart fa-3x"></i>
                    <div class="info p-3">
                        <h4>@lang('My Cash') </h4>
                        <p><b> {!! $my_cash !!}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-2 pt-2 text-light rounded"><i class="icon fa fa-bar-chart fa-3x"></i>
                    <div class="info text-white p-3">
                        <h4>@lang('My Bank')</h4>
                        <p><b>{!! $my_bank !!} </b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-3 pt-2 text-white rounded"><i class="icon fa fa-bar-chart fa-3x"></i>
                    <div class="info p-3">
                        <h4>@lang('Today Recieved')</h4>
                        <p><b>{!! $receipt_amt !!}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-4 pt-2 text-white rounded"><i class="icon fa fa-bar-chart fa-3x"></i>
                    <div class="info p-3">
                        <h4>@lang('Today Payment')</h4>
                        <p><b> {!! $payment_amt !!} </b></p>
                    </div>
                </div>
            </div>
            {{--<div class="col-md-4">
                <div class="card-1 pt-2 text-white rounded"><i class="icon fa fa-bar-chart fa-3x"></i>
                    <div class="info p-3">
                        <h4>@lang('Total Recieved')</h4>
                        <p><b>{!! $total_receipt_amt !!} </b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-2 pt-2 text-white rounded"><i class="icon fa fa-bar-chart fa-3x"></i>
                    <div class="info p-3">
                        <h4>@lang('Total Payable')</h4>
                        <p><b>{!! $total_payment_amt !!} </b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-3 pt-2 text-white rounded"><i class="icon fa fa-bar-chart fa-3x"></i>
                    <div class="info p-3">
                        <h4>@lang('Current Cash')</h4>
                        <p><b>{!! $current_cash !!}</b></p>
                    </div>
                </div>
            </div>--}}

        </div>
    </div>
</div>
@endsection
