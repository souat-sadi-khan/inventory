<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b> Debit Note</b>
</div>
<form action="{{ route('admin.vaucher.debit_store') }}" method="post" id="modal_form">
    @csrf
    <div class="row">
        {{-- Cash/Bank By A/c(Debit) --}}
        <div class="col-md-4 form-group">
            <label for="debit1">Debit By A/c <span
                    class="text-danger">*</span></label>
            <select name="debit1" id="debit1" data-url="{{ route('admin.vaucher.balance_check') }}" required class="form-control select" data-placeholder="Select Account">
                <option value="">Select Account</option>
                @foreach ($models as $model)
                    <option {{ $model->id == 1 ? 'selected' : ''}} value="{{ $model->id}}">{{ $model->name }} ({{ toWord($model->category) }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-2 form-group">
            <label for="debit1_amount"> .</label>
            <input type="text" value="00.00" readonly name="debit1_amount"  id="debit1_amount" class="form-control" placeholder="Enter Payment Amount">
        </div>


        {{-- Receipt By A/c(Credit) --}}
        <div class="col-md-4 form-group">
            <label for="debit2">Debit By A/c <span
                    class="text-danger">*</span></label>
            <select name="debit2" id="debit2" data-url="{{ route('admin.vaucher.balance_check') }}" required class="form-control select" data-placeholder="Select Account">
                <option value="">Select Account</option>
                @foreach ($models as $model)
                    <option  value="{{ $model->id}}">{{ $model->name }} ({{ toWord($model->category) }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-2 form-group">
            <label for="debit2_amount">.</label>
            <input type="text" name="debit2_amount" value="00.00" readonly  id="debit2_amount" class="form-control input_number" placeholder="Enter Payment Amount">
        </div>


        {{-- Receipt Amount --}}
        <div class="col-md-6 form-group mx-auto" >
            <label for="amount">Payment Amount <span
                    class="text-danger">*</span></label>
            <input type="text" autocomplete="off" name="amount" required id="amount" class="form-control input_number" placeholder="Enter Receipt Amount">
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

      $(document).on('change', '#debit1', function () {
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
            
            $('#debit1_amount').val(data);
            
        })
    });



      $(document).on('change', '#debit2', function () {
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
            
            $('#debit2_amount').val(data);
            
        })
    });
</script>