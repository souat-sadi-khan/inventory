@php
    $payable = $model->payable;
    $due = $model->due;
    $paid = $payable - $due;
@endphp
<div class="row">
    <div class="col-md-10 mx-auto">
        <table class="table">
            <tr class="table-primary">
                <td width="20%">Payable Amount</td>
                <td>{{get_option('currency_symbol')}} {{number_format($model->payable, 2)}} </td>
            </tr>
            <tr class="table-success">
                <td width="20%">Paid Amount</td>
                <td><span id="show_paid">{{get_option('currency_symbol')}} {{number_format($paid, 2)}}</span></td>
            </tr>
            <tr class="table-danger">
                <td width="20%">Due Amount</td>
                <td><span id="show_due">{{get_option('currency_symbol')}} {{number_format($model->due, 2)}}</span></td>
            </tr>
        </table>

        <form action="{{route('admin.loan.pay-amount')}}" method="post" id="modal_form">
            <input type="hidden" name="loan_id" value="{{$model->id}}">
            @csrf
            <div class="row">

                <div class="col-md-12 form-group">
                    <label for="ref_no">{{ __('Ref. No') }} <span class="text-danger">*</span></label>
                    <input type="text" name="ref_no" id="ref_no" class="form-control" placeholder="Enter Reference Number" required>
                </div>

                <div class="col-md-12 form-group">
                    <label for="paid">{{ __('Pay Amount') }} <span class="text-danger">*</span></label>
                    <input type="number" name="paid" id="paid" class="form-control" required placeholder="Enter Paid Amount"> 
                </div>

                <div class="col-md-12 form-group">
                    <label for="note">{{ __('Note') }}</label>
                    <textarea name="note" id="note" cols="30" rows="2" class="form-control" placeholder="Enter Description"></textarea>
                </div>

            </div>

            <button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Pay Amount</button>
            <button type="button" id="edit_submiting" class="btn btn-sm btn-info float-right px-5" id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
        </form>
    </div>
</div>

<script>
    var total_int_payable = '{{$payable}}';
    var total_payable = parseInt(total_int_payable);
    var total_int_due = '{{$due}}';
    var total_due = parseInt(total_int_due);
    var total_int_paid = '{{$paid}}';
    var total_paid = parseInt(total_int_paid);
    var in_due = total_due + 1;

    $('#paid').keyup(function() {
        $('#show_paid').html('---');
        $('#show_due').html('---');
        var val = parseInt($(this).val());
        var due = total_due - val ;
        var paid = total_paid + val;
        $('#show_paid').html(paid);
        $('#show_due').html(due);
    });
</script>