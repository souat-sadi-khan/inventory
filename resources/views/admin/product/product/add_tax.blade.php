<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b>Create New Taxrate</b>
</div>
<form data-xhr="add_taxrate" action="{{ route('admin.products.products.save_tax') }}" data-select="tax_id" method="post" class="remote_form">
    @csrf
    <div class="row">
        {{-- Product Tax Name --}}
        <div class="col-md-6 form-group">
            <label for="tax_name">Product Tax Name <span class="text-danger">*</span></label>
            <input style="text-transform: uppercase;" type="text" name="tax_name" class="form-control" placeholder="Enter Product Tax Name" required>
        </div>

        {{-- Product Tax Code Name --}}
        <div class="col-md-6 form-group">
            <label for="tax_code_name">Product Tax Code  </label>
            <input type="text" name="tax_code_name" class="form-control" placeholder="Enter Product Tax Code Name">
        </div>

        {{-- Product Tax Rate --}}
        <div class="col-md-4 form-group">
            <label for="tax_rate">Tax Rate <span class="text-danger">*</span></label>
            <input type="number" name="tax_rate" class="form-control" placeholder="Enter Tax Rate" required>
        </div>

        {{-- Tax Rules --}}
        <div class="col-md-4 form-group">
            <label for="tax_rules">Tax Rule <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#tax_rules_error" name="tax_rules" class="form-control select" data-placeholder="Select One" required>
                <option value="">Select One</option>
                <option value="plus">Addition (+)</option>
                <option value="mod">Percentages (%)</option>
            </select>
            <span id="tax_rules_error"></span>
        </div>

        {{-- Status --}}
        <div class="col-md-4 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#status_error" required name="status" class="form-control select" data-placeholder="Select Status">
                <option value="">Select Status</option>
                <option selected value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <span id="status_error"></span>
        </div>
    </div>
    <button type="submit" id="remote_submit_add_taxrate" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Submit</button>
    <button type="button" disabled id="remote_submiting_add_taxrate" class="btn btn-sm btn-info float-right px-5" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>
