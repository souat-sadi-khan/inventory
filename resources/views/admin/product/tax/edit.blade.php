<form action="{{ route('admin.product-initiazile.taxrate.update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')
    <div class="row">

        {{-- Product Tax Name --}}
        <div class="col-md-6 form-group">
            <label for="tax_name">Product Tax Name <span class="text-danger">*</span></label>
            <input style="text-transform: uppercase;" type="text" value="{{ $model->tax_name }}" name="tax_name" id="tax_name" class="form-control" placeholder="Enter Product Tax Name" required>
        </div>

        {{-- Product Tax Code Name --}}
        <div class="col-md-6 form-group">
            <label for="tax_code_name">Product Tax Code  </label>
            <input type="text" value="{{ $model->tax_code_name }}" name="tax_code_name" id="tax_code_name" class="form-control" placeholder="Enter Product Tax Code Name">
        </div>

        {{-- Product Tax Rate --}}
        <div class="col-md-4 form-group">
            <label for="tax_rate">Tax Rate <span class="text-danger">*</span></label>
            <input type="number" value="{{ $model->tax_rate }}" name="tax_rate" id="tax_rate" class="form-control" placeholder="Enter Tax Rate" required>
        </div>

        {{-- Tax Rules --}}
        <div class="col-md-4 form-group">
            <label for="tax_rules">Tax Rule <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#edit_tax_rules_error" name="tax_rules" id="edit_tax_rules" class="form-control select" data-placeholder="Select One" required>
                <option value="">Select One</option>
                <option {{ $model->tax_rules == 'plus' ? 'selected' : ''}} value="plus">Addition (+)</option>
                <option {{ $model->tax_rules == 'mod' ? 'selected' : ''}} value="mod">Percentages (%)</option>
            </select>
            <span id="edit_tax_rules_error"></span>
        </div>

        {{-- Status --}}
        <div class="col-md-4 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#edit_status_error" required name="status" id="edit_status" class="form-control select" data-placeholder="Select Status">
                <option value="">Select Status</option>
                <option {{ $model->status == 1 ? 'selected' : ''}} value="1">Active</option>
                <option {{ $model->status == 0 ? 'selected' : ''}} value="0">Inactive</option>
            </select>
            <span id="edit_status_error"></span>
        </div>
    </div>
    <button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Save</button>
    <button type="button" id="edit_submiting" class="btn btn-info float-right" id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>
