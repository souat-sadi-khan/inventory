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
      <div class="col-md-12">
        <form action="{{ route('layout.invoice_post') }}" id="content_form" method="post">
          <input type="hidden" name="type" value="{{ $type }}">
          <div class="card-body">
            <div class="card border border-primary">
              <div class="card-body text-center">
                <div class="row">
                  <div class="col-md-3 form-group">
                    <label for="product_name">Layout Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Enter Layout Name" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="company_name">Company Name <span class="text-danger">*</span></label>
                    <input type="text" name="company_name" id="company_name" class="form-control" required placeholder="Enter Company Name" value="">
                  </div>
                  <div class="col-md-2 form-group">
                    <label for="header">Header <span class="text-danger">*</span></label>
                    <input type="text" name="header" id="header" class="form-control" required placeholder="Enter header" value="">
                  </div>

                  <div class="col-md-2 form-group">
                    <label for="top_header">Top Header <span class="text-danger">*</span></label>
                    <input type="text" name="top_header" id="top_header" class="form-control" required placeholder="Enter Top header" value="">
                  </div>
                  <div class="col-md-2 form-group">
                    <label for="mobile_no">Mobile No <span class="text-danger">*</span></label>
                    <input type="text" name="mobile_no" id="mobile_no" class="form-control" required placeholder="Enter Mobile No" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="phone"> Phone<span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control" required placeholder="Enter Phone" value="">
                  </div>
                  <div class="col-md-2 form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="text" name="email" id="email" class="form-control" required placeholder="Enter Company Name" value="">
                  </div>
                  <div class="col-md-2 form-group">
                    <label for="accountant_sign">Accountant Sign <span class="text-danger">*</span></label>
                    <input type="text" name="accountant_sign" id="accountant_sign" class="form-control" required placeholder="Enter Accountant Sign" value="">
                  </div>

                    <div class="col-md-2 form-group">
                    <label for="maneger_sign">Manager Sign <span class="text-danger">*</span></label>
                    <input type="text" name="maneger_sign" id="maneger_sign" class="form-control" required placeholder="Enter Manager Sign" value="">
                  </div>
                  <div class="col-md-2 form-group">
                    <label for="propiter_sign">Propiter Sign <span class="text-danger">*</span></label>
                    <input type="text" name="propiter_sign" id="propiter_sign" class="form-control" required placeholder="Enter Propiter Sign" value="">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 form-group">
                    <label for="sector">Deposit sector <span class="text-danger">*</span></label>
                    <input type="text" name="sector" id="sector" class="form-control" required placeholder="Enter Depoite sector" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="voucher_name">Voucher Name <span class="text-danger">*</span></label>
                    <input type="text" name="voucher_name" id="voucher_name" class="form-control" required placeholder="Enter Voucher Name" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="cost_sector">Cost Sector <span class="text-danger">*</span></label>
                    <input type="text" name="cost_sector" id="cost_sector" class="form-control" required placeholder="Enter Cost Sector" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="account_name">Account Name <span class="text-danger">*</span></label>
                    <input type="text" name="account_name" id="account_name" class="form-control" required placeholder="Enter Account Name" value="">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 form-group">
                    <label for="voucher_no">Voucher No <span class="text-danger">*</span></label>
                    <input type="text" name="voucher_no" id="voucher_no" class="form-control" required placeholder="Enter Voucher No" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="date">Date <span class="text-danger">*</span></label>
                    <input type="text" name="date" id="date" class="form-control" required placeholder="Enter Date" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="day">Day <span class="text-danger">*</span></label>
                    <input type="text" name="day" id="day" class="form-control" required placeholder="Enter Day" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="amount">Amount <span class="text-danger">*</span></label>
                    <input type="text" name="amount" id="amount" class="form-control" required placeholder="Enter Amount" value="">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 form-group">
                    <label for="note">Note <span class="text-danger">*</span></label>
                    <input type="text" name="note" id="note" class="form-control" required placeholder="Enter Note" value="">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mx-auto text-center">
                    
                    <button type="submit" class="btn btn-primary btn-sm w-100" id="submit">Save Invoice</button>
                    <button type="button" class="btn btn-sm btn-info w-100" id="submiting" style="display: none;">
                    <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
@endsection
@push('admin.scripts')
<script>
  _formValidation();
</script>
@endpush