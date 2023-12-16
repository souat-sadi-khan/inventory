<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b>Create New Box</b>
</div>
<form action="{{ route('admin.products.products.save_box') }}" data-select="box_id" method="post" class="remote_form">
    @csrf
    <div class="row">
        {{-- Product Box Name --}}
        <div class="col-md-4 form-group">
            <label for="box_name">Product Box Name <span class="text-danger">*</span></label>
            <input type="text" name="box_name" id="box_name" class="form-control" placeholder="Enter Product Box Name" required>
        </div>

        {{-- Product Box Code Name --}}
        <div class="col-md-4 form-group">
            <label for="box_code_name">Product Box Code  </label>
            <input type="text" name="box_code_name" id="box_code_name" class="form-control" placeholder="Enter Product Box Code Name">
        </div>

        {{-- Status --}}
        <div class="col-md-4 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#status_error" required name="status" id="status" class="form-control select" data-placeholder="Select Status">
                <option value="">Select Status</option>
                <option selected value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <span id="status_error"></span>
        </div>

        {{-- Box Details --}}
        <div class="col-md-12 form-group">
            <label for="box_details">Box Details</label>
            <textarea name="box_details" id="box_details" class="form-control" cols="30" rows="2" placeholder="Enter Box Description"></textarea>
        </div>
    </div>
    <button type="submit" id="remote_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Submit</button>
    <button type="button" id="remote_submiting" class="btn btn-sm btn-info float-right px-5" id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>