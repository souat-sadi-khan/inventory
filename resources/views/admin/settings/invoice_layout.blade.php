@extends('layouts.main', ['title' => ('Invoice Layout'), 'modal' => 'xl',])
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
      <h4>Invoice Layout</h4>
    </div>
    <!-- /.card-header -->
    <div class="row">
      <div class="col-md-4">
       <a href="{{ route('layout.invoice',['type'=>'invoice']) }}">
         <div class="card-body">
            <div class="card border border-primary">
                <div class="card-body text-center">
                  <i class="fa fa-file-word-o" style="font-size: 35px" aria-hidden="true"></i>
                  <p>@lang('Invoice Layout')</p>
                </div>
            </div>
        </div>
       </a>
      </div>

       <div class="col-md-4">
       <a href="{{ route('layout.invoice',['type'=>'voucher']) }}">
         <div class="card-body">
            <div class="card border border-primary">
                <div class="card-body text-center">
                  <i class="fa fa-file-word-o" style="font-size: 35px" aria-hidden="true"></i>
                  <p>@lang('Voucher Layout')</p>
                </div>
            </div>
        </div>
       </a>
      </div>

       <div class="col-md-4">
       <a href="">
         <div class="card-body">
            <div class="card border border-primary">
                <div class="card-body text-center">
                  <i class="fa fa-file-word-o" style="font-size: 35px" aria-hidden="true"></i>
                  <p>@lang('Payment Layout')</p>
                </div>
            </div>
        </div>
       </a>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
@endsection
@push('admin.scripts')
@endpush