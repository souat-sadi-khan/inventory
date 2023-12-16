<form action="{{ route('admin.supplier.update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')
    <div class="row">
        {{-- Name --}}
        <div class="col-md-6 form-group">
            <label for="sup_name">Name <span class="text-danger">*</span></label>
            <input type="text" name="sup_name" id="sup_name" class="form-control" placeholder="Enter Supplier Name" required value="{{ $model->sup_name }}">
        </div>
        {{-- Code Name --}}
        <div class="col-md-6 form-group">
            <label for="code_name">Code Name <span class="text-danger">*</span></label>
            <input type="text" name="code_name" id="code_name" class="form-control" placeholder="Enter Supplier Code Name" required value="{{ $model->code_name }}">
        </div>
        {{-- Phone --}}
        <div class="col-md-6 form-group">
            <label for="sup_mobile">Phone <span class="text-danger">*</span></label>
            <input type="text" name="sup_mobile" id="sup_mobile" class="form-control" placeholder="Enter Supplier Phone" required value="{{ $model->sup_mobile }}">
        </div>
        {{-- Email --}}
        <div class="col-md-6 form-group">
            <label for="sup_email">Email</label>
            <input type="email" name="sup_email" id="sup_email" class="form-control" placeholder="Enter Supplier Email" value="{{ $model->sup_email }}">
        </div>
        {{-- <div class="col-md-4 form-group">
            <label for="net_total">Opening Balance</label>
            <input type="text" autocomplete="off" name="net_total" id="net_total" class="form-control" placeholder="Enter Opening Balance" value="{{ $opening_balance }}">
        </div> --}}
        {{-- Address --}}
        <div class="col-md-12 form-group">
            <label for="sup_address">Address</label>
            <textarea name="sup_address" id="sup_address" class="form-control" placeholder="Ener Supplier Address" cols="30" rows="2">{{ $model->sup_address }}</textarea>
        </div>
        {{-- City --}}
        <div class="col-md-6 form-group">
            <label for="sup_city">City</label>
            <input type="text" name="sup_city" id="sup_city" class="form-control" placeholder="Enter Supplier City" value="{{ $model->sup_city }}">
        </div>
        {{-- State --}}
        <div class="col-md-6 form-group">
            <label for="sup_state">State</label>
            <input type="text" name="sup_state" id="sup_state" class="form-control" placeholder="Enter Supplier State" value="{{ $model->sup_state }}">
        </div>
        {{-- Country --}}
        <div class="col-md-6 form-group">
            <label for="sup_country">Country</label>
            <input type="text" name="sup_country" id="sup_country" class="form-control" placeholder="Enter Supplier Country" value="{{ $model->sup_country != '' ? $model->sup_country : 'Bangladesh'}}">
        </div>
        {{-- Status --}}
        <div class="col-md-6 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-control select" data-placeholder="Select Customer Status">
                <option value="">Select Supplier Status</option>
                <option {{$model->status == 1 ? 'selected' : ''}} value="1">Active</option>
                <option {{$model->status == 0 ? 'selected' : ''}} value="0">Inactive</option>
            </select>
        </div>
    </div>
    <button type="submit" id="edit_submit" class="btn btn-primary float-right"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i> Save</button>
    <button type="button" id="edit_submiting" class="btn btn-sm btn-info float-right"  style="display: none;">
    <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>
<script>
$('.select').select2({ width: '100%' });
</script>