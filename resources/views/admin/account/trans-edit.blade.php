<form action="{{ route('admin.account-trans.update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')
    <div class="row">
        {{-- Account Type --}}
        <div class="col-md-6 form-group">
            <label for="category">Account Type
            </label>
            <div class="input-group">
                <select readonly name="category" id="category" class="form-control">
                    <option> {{ $model->account->name }} ({{ toWord($model->account->category) }})</option>
                </select>
            </div>
        </div>
        {{-- Account Name --}}
        <div class="col-md-6 form-group">
            <label for="type">Transaction Type <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <select name="type" name="type" id="type" class="form-control select">
                    <option {{$model->type == 'Debit'?'selected':''}} value="Debit">{{$model->type}} </option>
                    <option {{$model->type == 'Credit'?'selected':''}} value="Credit">{{$model->type}} </option>
                </select>
            </div>
        </div>
        {{-- Display Name --}}
        <div class="col-md-6 form-group" >
            <label for="sub_type">Sub Type 
            </label>
            <input type="text" value="{{$model->sub_type}}" name="sub_type" id="sub_type" class="form-control"
                placeholder="Enter Sub Type">
        </div>
        {{-- Amount --}}
        <div class="col-md-6 form-group ">
            <label for="amount">Amount <span class="text-danger">*</span>
            </label>
            <input type="text" value="{{$model->amount}}" name="amount" id="amount" class="form-control"
                placeholder="Enter Amount" required>
        </div>
        {{-- For Bank Accout    --}}
        {{-- Reference No --}}
        <div class="col-md-6 form-group ">
            <label for="reff_no">Reference No 
            </label>
            <input type="text" value="{{$model->reff_no}}" name="reff_no" id="reff_no" class="form-control"
                placeholder="Enter Reference No">
        </div>
 
        {{-- Opening Date --}}
        <div class="col-md-6 form-group ">
            <label for="operation_date">Operation Date <span class="text-danger">*</span>
            </label>
            <input type="text" value="{{$model->operation_date}}" name="operation_date" id="operation_date"
                class="form-control take_date" placeholder="Enter Operation Date" required>
        </div>
        {{-- Note --}}
        <div class="col-md-12 form-group">
            <label for="note">Note <span class="text-danger">*</span>
            </label>
                <textarea name="note" id="note" class="form-control"
                placeholder="Enter Note">{{$model->note}}</textarea>
        </div>
    </div>
    <button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3"
            aria-hidden="true"></i>Save</button>
    <button type="button" id="edit_submiting" class="btn btn-sm btn-info float-right" id="submiting"
        style="display: none;">
        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>
