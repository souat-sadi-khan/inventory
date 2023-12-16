<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b> Deposit Edit</b>
</div>
<form action="{{ route('admin.account-trans.deposit_update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')
    <div class="row">
        {{-- Cash/Bank By A/c(Debit) --}}
        <div class="col-md-4 form-group">
            <label for="bank">Deposit A/c <span
                    class="text-danger">*</span></label>
            <select name="bank" id="bank" data-url="{{ route('admin.vaucher.balance_check') }}" required class="form-control select" data-placeholder="Select Account">
                <option value="">Select Account</option>
                @foreach ($bank as $item)
                    <option {{$item->id == $model->account_id?'selected':''}} value="{{ $item->id}}">{{ $item->name }} ({{ toWord($item->category) }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-2 form-group">
            <label for="bank_amount"> .</label>
            <input type="text" value="00.00" readonly name="bank_amount"  id="bank_amount" class="form-control" placeholder="Enter Payment Amount">
        </div>


        {{-- Voucher number --}}
        <div class="col-md-6 form-group mx-auto" >
            <label for="voucher_number">Voucher number </label>
        <input autocomplete="off" value="{{$model->reff_no}}" type="text" name="voucher_number" id="voucher_number" class="form-control" placeholder="Enter Voucher number">
        </div>

        {{-- Receipt Amount --}}
        <div class="col-md-6 form-group mx-auto" >
            <label for="amount">Deposit Amount <span
                    class="text-danger">*</span></label>
            <input autocomplete="off" value="{{$model->amount}}" type="text" name="amount" required id="amount" class="form-control input_number" placeholder="Enter Deposit Amount">
        </div>


                 {{-- Description --}}
            <div class="col-md-12 form-group">
                <label for="note">Description
                </label>
                    <textarea name="note" class="form-control" id="note" >{{$model->note}}</textarea>
            </div>



        {{-- Operation Date --}}
        <div class="col-md-6 form-group mx-auto" >
            <label for="operation_date">Operation Date 
            </label>
            <input type="text" name="operation_date" id="operation_date"
                class="form-control take_date" value="{{$model->operation_date}}" placeholder="Enter Operation Date">
        </div>



    </div>

    <button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Save</button>
    <button type="button" id="edit_submiting" class="btn btn-sm btn-info float-right" id="submiting" style="display: none;">
        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>



<script>

      $(document).on('change', '#bank', function () {
        var value = $(this).val();
        var url = $(this).data('url');

        $.ajax({
            url: url,
            data:{value : value},
            type: 'Get',
            dataType: 'json'
        })
        .done(function(data) {
            $('#bank_amount').val(data);
            
        })
    });

</script>