<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b>Create New Unit</b>
</div>
<form action="{{ route('admin.products.products.save_unit') }}" data-select="unit_id" method="post" class="remote_form">
    @csrf
    <div class="row">
        {{-- Product Unit Name --}}
        <div class="col-md-4 form-group">
            <label for="unit_name">Product Unit Name <span class="text-danger">*</span></label>
            <input type="text" name="unit_name" id="unit_name" class="form-control" placeholder="Enter Product Unit Name" required>
        </div>

        {{-- Product Unit Code Name --}}
        <div class="col-md-4 form-group">
            <label for="unit_code_name">Product Unit Code  </label>
            <input type="text" name="unit_code_name" id="unit_code_name" class="form-control" placeholder="Enter Product Unit Code Name">
        </div>

        {{-- Status --}}
        <div class="col-md-4 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#status_error" required name="status" id="status" class="form-control select" data-placeholder="Select Customer Status">
                <option value="">Select  Customer Status</option>
                <option selected value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <span id="status_error"></span>
        </div>

        {{-- Unit Details --}}
        <div class="col-md-12 form-group">
            <label for="unit_details">Unit Details</label>
            <textarea name="unit_details" id="unit_details" class="form-control" cols="30" rows="2" placeholder="Enter Unit Description"></textarea>
        </div>
    </div>
    <button type="submit" id="remote_submit_add_unit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Submit</button>
    <button type="button" id="remote_submiting_add_unit" class="btn btn-sm btn-info float-right px-5" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>
