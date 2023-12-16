<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b> Contra</b>
</div>
<form action="{{ route('admin.vaucher.contra_store') }}" method="post" id="modal_form">
    @csrf
    <div class="row">
        
        
        {{-- Payment By A/c(Credit) --}}
        <div class="col-md-4 form-group">
            <label for="from_bank">Cash/Bank A/c(Credit) <span
                    class="text-danger">*</span></label>
            <select name="from_bank" id="from_bank" data-url="{{ route('admin.vaucher.balance_check') }}" required class="form-control select" data-placeholder="Select Account">
                <option value="">Select Account</option>
                @foreach ($bank as $model)
                    <option {{ $model->id == 1 ? 'selected' : ''}} value="{{ $model->id}}">{{ $model->name }} ({{ toWord($model->category) }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-2 form-group">
            <label for="contra_amount">.</label>
            <input type="text" name="contra_amount" value="00.00" readonly  id="contra_amount" class="form-control input_number" placeholder="Enter Payment Amount">
        </div>


        {{-- Cash/Bank By A/c(Debit) --}}
        <div class="col-md-4 form-group">
            <label for="to_bank">Cash/Bank A/c(Debit) <span
                    class="text-danger">*</span></label>
            <select name="to_bank" id="to_bank" data-url="{{ route('admin.vaucher.balance_check') }}" required class="form-control select" data-placeholder="Select Account">
                <option value="">Select Account</option>
                @foreach ($bank as $model)
                    <option {{ $model->id == 1 ? 'selected' : ''}} value="{{ $model->id}}">{{ $model->name }} ({{ toWord($model->category) }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-2 form-group">
            <label for="bank_amount"> .</label>
            <input type="text" value="00.00" readonly name="bank_amount"  id="bank_amount" class="form-control" placeholder="Enter Payment Amount">
        </div>


        {{-- Payment Amount --}}
        <div class="col-md-6 form-group mx-auto" >
            <label for="amount">Payment Amount <span
                    class="text-danger">*</span></label>
            <input autocomplete="off" type="text" name="amount" required id="amount" class="form-control input_number" placeholder="Enter Payment Amount">
        </div>


                 {{-- Description --}}
            <div class="col-md-12 form-group">
                <label for="note">Description
                </label>
                    <textarea name="note" class="form-control" id="note" ></textarea>
            </div>



        {{-- Operation Date --}}
        <div class="col-md-6 form-group mx-auto" >
            <label for="operation_date">Operation Date 
            </label>
            <input type="text" name="operation_date" id="operation_date"
                class="form-control take_date" value="{{date('Y-m-d')}}" placeholder="Enter Operation Date">
        </div>



    </div>

    <button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Save</button>
    <button type="button" id="edit_submiting" class="btn btn-sm btn-info float-right" id="submiting" style="display: none;">
        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>



<script>

      $(document).on('change', '#to_bank', function () {
        var value = $(this).val();
        var url = $(this).data('url');

        $.ajax({
            url: url,
            data:{value : value},
            type: 'Get',
            dataType: 'json'
        })
        .done(function(data) {
            console.log(data);
            
            $('#bank_amount').val(data);
            
        })
    });



      $(document).on('change', '#from_bank', function () {
        var value = $(this).val();
        var url = $(this).data('url');

        $.ajax({
            url: url,
            data:{value : value},
            type: 'Get',
            dataType: 'json'
        })
        .done(function(data) {
            console.log(data);
            
            $('#contra_amount').val(data);
            
        })
    });
</script>