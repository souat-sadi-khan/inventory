@extends('layouts.main', ['title' => ('Receipt Layout'), 'modal' => 'xl',])
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
      <h4>Receipt Layout</h4>
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
                  <div class="col-md-2 form-group">
                    <label for="phone"> Phone<span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control" required placeholder="Enter Phone" value="">
                  </div>
                     <div class="col-md-2 form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="text" name="email" id="email" class="form-control" required placeholder="Enter Company Name" value="">
                  </div>

                   <div class="col-md-2 form-group">
                    <label for="c_name">Cus/Sup Name <span class="text-danger">*</span></label>
                    <input type="text" name="c_name" id="c_name" class="form-control" required placeholder="Enter  Name" value="">
                  </div>

                   <div class="col-md-2 form-group">
                    <label for="address">Customer/Sup address <span class="text-danger">*</span></label>
                    <input type="text" name="address" id="c_address" class="form-control" required placeholder="Enter  Customer/Sup address" value="">
                  </div>
                  <div class="col-md-2 form-group">
                    <label for="customer_sign">Customer Sign <span class="text-danger">*</span></label>
                    <input type="text" name="customer_sign" id="customer_sign" class="form-control" required placeholder="Enter Customer Sign" value="">
                  </div>

                    <div class="col-md-2 form-group">
                    <label for="customer_sign">Supplier Sign <span class="text-danger">*</span></label>
                    <input type="text" name="customer_sign" id="customer_sign" class="form-control" required placeholder="Enter Customer Sign" value="">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3 form-group">
                    <label for="product">Product <span class="text-danger">*</span></label>
                    <input type="text" name="product" id="product" class="form-control" required placeholder="Enter Product" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="quantity">Quantity <span class="text-danger">*</span></label>
                    <input type="text" name="quantity" id="quantity" class="form-control" required placeholder="Enter Quantity" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="price">Price <span class="text-danger">*</span></label>
                    <input type="text" name="price" id="price" class="form-control" required placeholder="Enter Price" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="total">Total <span class="text-danger">*</span></label>
                    <input type="text" name="total" id="total" class="form-control" required placeholder="Enter Total" value="">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 form-group">
                    <label for="sub_total">Subtotal <span class="text-danger">*</span></label>
                    <input type="text" name="sub_total" id="sub_total" class="form-control" required placeholder="Enter Subtotal" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="net_total">Net Total <span class="text-danger">*</span></label>
                    <input type="text" name="net_total" id="net_total" class="form-control" required placeholder="Enter Net Total" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="discount">Discount <span class="text-danger">*</span></label>
                    <input type="text" name="discount" id="discount" class="form-control" required placeholder="Enter Discount" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="tax">Tax <span class="text-danger">*</span></label>
                    <input type="text" name="tax" id="tax" class="form-control" required placeholder="Enter Tax" value="">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 form-group">
                    <label for="shipping">Shipping <span class="text-danger">*</span></label>
                    <input type="text" name="shipping" id="shipping" class="form-control" required placeholder="Enter Shipping" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="paid">Paid <span class="text-danger">*</span></label>
                    <input type="text" name="paid" id="paid" class="form-control" required placeholder="Enter Paid" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="due">Due <span class="text-danger">*</span></label>
                    <input type="text" name="due" id="due" class="form-control" required placeholder="Enter Due" value="">
                  </div>
                  <div class="col-md-3 form-group">
                    <label for="return">Return Qty <span class="text-danger">*</span></label>
                    <input type="text" name="return" id="return" class="form-control" required placeholder="Enter Return Qty" value="">
                  </div>

                    <div class="col-md-3 form-group">
                    <label for="return">Return Total <span class="text-danger">*</span></label>
                    <input type="text" name="return_total" id="return_total" class="form-control" required placeholder="Enter Return Total" value="">
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