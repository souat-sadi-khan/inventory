<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b> Journal Voucher</b>
</div>
<form action="{{ route('admin.vaucher.journal_store') }}" method="post" id="modal_form">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead class="bg-gray">
                    <tr>
                        <td>
                            <label for="bank">Select By Dr/Cr A/c <span class="text-danger">*</span></label>
                            <select name="bank" id="bank"  class="form-control select"
                                data-placeholder="Select Account">
                                <option value="">Select Account</option>
                                @foreach ($bank as $model)
                                <option {{ $model->id == 1 ? 'selected' : ''}} value="{{ $model->id}}">{{ $model->name }} ({{ toWord($model->category) }})</option>
                                @endforeach
                            </select>
                            <span id="product_error"></span>
                        </td>
                        <td>
                            <label for="account">Select By Dr/Cr A/c <span class="text-danger">*</span></label>
                            <select name="account" id="account" 
                                 class="form-control select" data-placeholder="Select Account">
                                <option value="">Select Account</option>
                                @foreach ($models as $model)
                                <option value="{{ $model->id}}">{{ $model->name }} ({{ toWord($model->category) }})</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <label for="type">Debit/Credit <span class="text-danger">*</span></label>
                            <select name="type" id="type"  class="form-control select"
                                data-placeholder="Select Type">
                                <option value="">Select Type</option>
                                <option value="Debit">Debit</option>
                                <option value="Credit">Credit</option>
                            </select>
                        </td>
                        <td>
                            <label for="amount">Payment Amount <span class="text-danger">*</span></label>
                            <input autocomplete="off" type="text" name="amount"  id="amount" class="form-control input_number"
                                placeholder="Enter Payment Amount">
                        </td>
                        <td>
                            <input type="hidden" id='url' data-url="{{ route('admin.vaucher.journal_data') }}">
                            <button type="button" id="click_here" class="btn btn-info btn-sm ">Click Add</button>
                            <button type="button" class="btn btn-sm btn-info" id="submitted" style="display: none;">
                                <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

<h5 class="bg-primary text-center mt-4">
    Journal Voucher Account List
</h5>
 <div class="row mt-2">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead class="bg-green">
                                <tr>
                                    <th>Account By</th>
                                    <th>Account To</th>
                                    <th>Debit/Credit</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray" id="pursesDetailsRender">
                                
                            </tbody>
                        </table>
                    </div>
                </div>

<div class="row">
                    <div class="col-md-6 mx-auto text-center">
                        
                        <button type="submit" class="btn btn-primary btn-sm w-100" id="submit">Journal Voucher Save </button>
                        <button type="button" class="btn btn-sm btn-info w-100" id="submiting" style="display: none;">
                        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
                    </div>
                </div>
            </form>

                

<script>
    
$(document).on('click', '#click_here', function() {
    var url = $("#url").data('url');
    var bank = $("#bank").val();
    var account = $("#account").val();
    var type = $("#type").val();
    var amount = parseInt($("#amount").val());
    $("#click_here").hide();
    $("#submitted").show();
    if (bank == "" || account == "" || amount == "") {
        $("#click_here").show();
        $("#submitted").hide();
        swal("Select Account & Amount");
    } else {
        $.ajax({
             url: url,
            data: {
                bank: bank,
                account: account,
                type: type,
                amount: amount,
            },
            type: 'Get',
            dataType: 'html'

        })

        .done(function(data) {

            $("#pursesDetailsRender").append(data);
            $("#bank").val("");
            $("#account").val("");
            $("#type").val("");
            $("#amount").val("");
            $("#click_here").show();
            $("#submitted").hide();
            // calculate();

        })
    }

});


$("#pursesDetailsRender").on('click', '.remmove', function() {
    $(this).closest('tr').remove();
    // calculate();
})

</script>
