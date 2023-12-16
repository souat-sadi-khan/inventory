@extends('layouts.main', ['title' => ('Product Purchase'), 'modal' => 'xl',])
@push('admin.css')
<style>
.bg-gray {
color: #000 !important;
background-color: #d2d6de !important;
}
.bg-green, .callout.callout-success, .alert-success, .label-success, .modal-success .modal-body {
background-color: #00a65a !important;
}
.table th, .table td {
padding: 0.2rem 0.5rem;
}
.pos_product_div .form-control{
padding: 0.1rem 0.65rem;
}
.btn-sm, .btn-group-sm > .btn{
padding: 0rem 0.5rem;
}
.table-bordered th, .table-bordered td {
border: 1px solid #797979;

}
.custom-input-field .form-control{
    height: calc(1.2rem + 2px);
    font-size: 13px;
    text-align: right;
    user-select: none;
}
</style>
@endpush
@section('header')
   <a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
    <a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club" aria-hidden="true"></i>@lang('Today')</a>
    <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play" aria-hidden="true"></i>@lang('Tutorial')</a>
    <a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle" aria-hidden="true"></i>@lang('Help')</a>
    <a href="{{ route('admin.pur_voucher.purchase.index') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-list-alt" aria-hidden="true"></i>@lang('Purchase List')</a>
    <a href="{{ route('admin.pur_voucher.return.create') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-retweet" aria-hidden="true"></i>@lang('Return')</a>
    <a href="{{ route('admin.pur_voucher.return.index') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-list-alt" aria-hidden="true"></i>@lang('Return List')</a>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create Product Purchase </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('admin.pur_voucher.purchase.store') }}" method="post" id="content_form">
                <input type="hidden" id="row" value="0">
                <div class="row">
                    <div class="col-md-5">
                        <label for="supplier_id">Supplier <span class="text-danger"></span></label>
                        <select data-parsley-errors-container="#supplier_error" required name="supplier_id" id="supplier_id" class="form-control select" data-placeholder="Select Supplier">
                            @foreach ($suppliers as $element)
                            <option {{ isset($supplier)?$supplier==$element->id?'selected':'':'' }} value="{{ $element->id }}">{{ $element->sup_name }}({{ $element->sup_mobile }})</option>
                            @endforeach
                        </select>
                        <span id="supplier_error"></span>
                    </div>
                    <div class="col-md-2">
                        <label for="invoice_no">Voucher No</label>
                        <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="{{ random_num('Purchase') }}" readonly>
                    </div>
                    <div class="col-md-5">
                        <label for="date">Purchase Date</label>
                        <input type="text" name="date" id="date" class="form-control take_date" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <h3 class="bg-primary text-center mt-4">
                Purchase Product
                </h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-gray">
                                <tr>
                                    <td>
                                        <label for="product">Product <span class="text-danger"></span></label>
                                        <select data-parsley-errors-container="#product_error"  name="product" id="product" class="form-control select">
                                            <option value="">Select Product</option>
                                            @foreach ($products as $element)
                                            <option value="{{ $element->id }}">{{ $element->product_name }}</option>
                                            @endforeach
                                        </select>
                                        <span id="product_error"></span>
                                    </td>
                                    <td>
                                        <label for="product_qty">Purchase Qty</label>
                                        <input type="text" name="product_qty" id="product_qty" class="form-control input_number">
                                    </td>
                                    <td>
                                        <label for="product_cost">Purchase Price</label>
                                        <input type="text" name="product_cost" id="product_cost" class="form-control input_number">
                                    </td>
                                    <td>
                                        <label for="product_price">Sale Price</label>
                                        <input type="text" name="product_price" id="product_price" class="form-control input_number">
                                    </td>
                                </tr>
                            </thead>
                        </table>
                     </div>
                    </div>
                    <div class="col-md-6 mx-auto text-center">
                        <button type="button" id="click_here" class="btn btn-info btn-sm ">Click Add</button>
                        <button type="button"  class="btn btn-sm btn-info" id="submitted" style="display: none;">
                        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-green">
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Purchase Price</th>
                                    <th>Sale Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray" id="pursesDetailsRender">
                                
                            </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-5">
                    <div class="col-md-11 mx-auto">
                        <div class="table-responsive">
                        <table class="table table-bordered border-dark " style="margin-bottom: 0px !important;background: #eee">
                            <tbody>
                                <tr>
                                    <td>
                                        <span>Total Item</span> <br>
                                        <input type="hidden" class="total_item">
                                        <span class="total_item">0</span>
                                    </td>
                                    <td>
                                        <span>Total</span> <br>
                                        <input type="hidden" name="sub_total" class="sub_total">
                                        <span class="sub_total">0</span>
                                    </td>
                                    <td style="width: 40%">
                                        <span>Discount Type</span> <br>
                                        <select name="discount_type" class="form-control" id="discount_type">
                                            <option value="">None</option>
                                            <option value="percentage">Percentage</option>
                                            <option value="fixed">Fixed</option>
                                        </select>
                                    </td>
                                    <td>
                                        <span>Discount</span> <br>
                                        <input type="text" name="discount" class="form-control input_number" id="discount_amount">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span>Discount Value</span> <br>
                                        <input type="text" name="discount_amount" class="form-control" id="total_discount" readonly>
                                    </td>
                                    <td>
                                        <span>Tax</span> <br>
                                        <input type="text" name="tax" class="form-control input_number" id="tax_calculation_amount">
                                    </td>
                                    <td>
                                        <span>Shipping</span> <br>
                                        <input type="text" name="shipping_charges" class="form-control input_number" id="shipping_charges">
                                    </td>
                                    <td>
                                        <span>Total Payable</span> <br>
                                        <input type="hidden" class="form-control net_total" name="net_total">
                                        <span class="net_total"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-11 mx-auto">
                        <div class="card" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="paid">Paid</label>
                                            <input type="text" class="form-control paid input_number" name="paid" id="paid">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="due">Due</label>
                                            <input type="text" class="form-control due" name="due" id="due" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_id">Account </label>
                                            <select name="account_id" class="form-control select" id="account_id" required>
                                                <option value="">Select Account</option>
                                                @foreach ($accounts as $element)
                                                   <option {{ $element->id == 1 ? 'selected' : ''}} value="{{ $element->id }}">{{ $element->name }}({{ toWord($element->category) }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="paid">Method </label>
                                            <select name="method" class="form-control method">
                                                <option value="cash">Cash</option>
                                                <option value="check">Check</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 reference_no" style="display: none;">
                                        <div class="form-group">
                                            <label for="check_no">Reference </label>
                                            <input type="text" class="form-control" name="check_no" id="check_no">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="transaction_note">Purchase Note </label>
                                        <textarea name="transaction_note" class="form-control" id="transaction_note" placeholder="Purchase Note"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="stuff_note">Stuff Note </label>
                                        <textarea name="stuff_note" class="form-control" id="stuff_note" placeholder="Stuff Note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mx-auto text-center">
                        
                        <button type="submit" class="btn btn-primary btn-sm w-100" id="submit">Save Voucher</button>
                        <button type="button" class="btn btn-sm btn-info w-100" id="submiting" style="display: none;">
                        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection
@push('admin.scripts')
<script>
_componentSelect2Normal();
_componentDatePicker();
$(document).on('change', '#product', function() {
    var product = $('#product').val();
    $.ajax({
            url: '/admin/purchase-voucher/product',
            data: {
                product: product,
            },
            type: 'Get',
            dataType: 'json'
        })
        .done(function(data) {
            $('#product_cost').val(data.product_cost);
            $('#product_price').val(data.product_price);
        })
});


$(document).on('click', '#click_here', function() {
    var product = $("#product").val();
    var quantity = $("#product_qty").val();
    var product_cost = $("#product_cost").val();
    var product_price = $("#product_price").val();
    var row = parseInt($("#row").val());
    $("#click_here").hide();
    $("#submitted").show();
    if (product == "" || quantity == "") {
        $("#click_here").show();
        $("#submitted").hide();
        swal("Select Product & Qty");
    } else {
        $.ajax({
            url: '/admin/purchase-voucher/add-product',
            data: {
                product: product,
                quantity: quantity,
                product_cost: product_cost,
                product_price: product_price,
                row: row,
            },
            type: 'Get',
            dataType: 'html'
        })

        .done(function(data) {

            if(data.status == 'danger') {
                alert(1);
                toastr.error(data.message);
                return false;
            }

            $("#pursesDetailsRender").append(data);
             $('#row').val(row + 1);
            $("#product").val("");
            $("#product_qty").val("");
            $("#product_cost").val("");
            $("#product_price").val("");
            $("#click_here").show();
            $("#submitted").hide();
            calculate();

        })
    }

});


$("#pursesDetailsRender").on('click', '.remmove', function() {
    $(this).closest('tr').remove();
    calculate();
})

function calculate() {
    var sub_total = 0;
    var shipping_charges = 0;
    var qty = 0;
    $(".amt").each(function() {
        sub_total = sub_total + ($(this).html() * 1);
    })

    $(".qty").each(function() {
        qty = qty + ($(this).val() * 1);
    })

    $(".total_item").val(qty);
    $(".total_item").text(qty);
    net_total = sub_total;
    $(".sub_total").val(sub_total);
    $(".sub_total").text(sub_total);
    var discount = pos_discount(sub_total);
    net_total = sub_total - discount;

    var tax = pos_order_tax(net_total, discount);
    net_total = net_total + tax;

    shipping_charges = shipping();
    net_total = net_total + shipping_charges;

    $(".net_total").val(net_total);
    $(".net_total").text(net_total);
    $(".due").val(net_total);
    var change_amount = calculate_balance_due(net_total);
    $('.change_return_span').text(change_amount);
    $('#due').val(change_amount);

}


$("#discount_amount, #discount_type,#tax_calculation_amount,#shipping_charges,#paid").on('keyup blur change', function() {
    calculate();
});


function pos_discount(total_amount) {
    var calculation_type = $('#discount_type').val();
    var calculation_amount = __read_number($('#discount_amount'));

    var discount = __calculate_amount(calculation_type, calculation_amount, total_amount);

    $('#total_discount').val(discount, false);

    return discount;
}

function __read_number(input_element, use_page_currency = false) {
    return input_element.val();
}

function pos_order_tax(price_total, discount) {
    var calculation_type = 'percentage';
    var calculation_amount = __read_number($('#tax_calculation_amount'));
    var total_amount = price_total;

    var order_tax = __calculate_amount(calculation_type, calculation_amount, total_amount);


    $('span#order_tax').text(order_tax, false);
    return order_tax;
}

function shipping() {
    var shipping_charges = parseFloat($('#shipping_charges').val());
    return isNaN(shipping_charges) ? 0 : shipping_charges;;

}

function __calculate_amount(calculation_type, calculation_amount, amount) {
    var calculation_amount = parseFloat(calculation_amount);
    calculation_amount = isNaN(calculation_amount) ? 0 : calculation_amount;

    var amount = parseFloat(amount);
    amount = isNaN(amount) ? 0 : amount;

    switch (calculation_type) {
        case 'fixed':
            return parseFloat(calculation_amount);
        case 'percentage':
            return parseFloat((calculation_amount / 100) * amount);
        default:
            return 0;
    }
}


function calculate_balance_due(total) {
    var paid = parseFloat($('#paid').val());
    paid = isNaN(paid) ? 0 : paid;
    $('.total_paying').text(paid);
    var total_change = total - paid;
    return total_change;
}


$(document).on('change', '.method', function() {
    var method = $(".method").val();
    if (method == 'cash') {
        $('.reference_no').hide(300);
    } else {
        $('.reference_no').show(400);
    }
});

_formValidation();
</script>
@endpush