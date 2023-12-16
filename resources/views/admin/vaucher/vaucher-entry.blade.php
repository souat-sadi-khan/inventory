<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b> Vaucher Entry</b>
</div>
<form action="{{ route('admin.vaucher.vaucher_store') }}" method="post" id="modal_form">
    @csrf
    <div class="row">
        {{-- Cash/Bank By A/c(Debit) --}}

        <div class="col-md-6 form-group mx-auto" >
            <label for="voucher_number">Voucher number </label>
            <input autocomplete="off" type="text" name="voucher_number" id="voucher_number" class="form-control" placeholder="Enter Voucher number">
        </div>
    </div>
<div class="row">
    
        
        <div class="col-md-4 form-group">
            <label for="account1">Account By A/c <span
                    class="text-danger">*</span></label>
            <select name="account1" id="account1" required class="form-control select" data-placeholder="Select Account">
                <option value="">Select Account</option>
                @foreach ($models as $model)
                    <option value="{{ $model->id}}">{{ $model->name }} ({{ toWord($model->category) }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-2 form-group">
            <label for="type1">Debit/Credit <span
                    class="text-danger">*</span></label>
            <select name="type1" id="type1" required class="form-control select" data-placeholder="Select Type">
                <option value="">Select Type</option>
                <option  value="Debit">Debit</option>
                <option value="Credit">Credit</option>
            </select>
        </div>


        {{-- Receipt By A/c(Credit) --}}
        <div class="col-md-4 form-group">
            <label for="account2">Account By A/c <span
                    class="text-danger">*</span></label>
            <select name="account2" id="account2" required class="form-control select" data-placeholder="Select Account">
                <option value="">Select Account</option>
                @foreach ($models as $model)
                    <option value="{{ $model->id}}">{{ $model->name }} ({{ toWord($model->category) }})</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-2 form-group">
            <label for="type2">Debit/Credit <span
                    class="text-danger">*</span></label>
            <select name="type2" id="type2" required class="form-control select" data-placeholder="Select Type">
                <option value="">Select Type</option>
                <option  value="Debit">Debit</option>
                <option value="Credit">Credit</option>
            </select>
        </div>


        {{-- Receipt Amount --}}
        <div class="col-md-6 form-group mx-auto" >
            <label for="amount">Payment Amount <span
                    class="text-danger">*</span></label>
            <input autocomplete="off" type="text" name="amount" required id="amount" class="form-control input_number" placeholder="Enter Receipt Amount">
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
