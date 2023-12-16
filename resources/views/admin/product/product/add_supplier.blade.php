<div class="col-md-6 mx-auto mb-3 text-center border bg-light border-info">
    <b>Create New Supplier</b>
</div>
<form action="{{ route('admin.products.products.save_supplier') }}" data-select="supplier_id" method="post" class="remote_form">
    @csrf
    <div class="row">
        {{-- Name --}}
        <div class="col-md-6 form-group">
            <label for="sup_name">Name <span class="text-danger">*</span></label>
            <input type="text" name="sup_name" id="sup_name" class="form-control" placeholder="Enter Supplier Name" required>
        </div>
        {{-- Code Name --}}
        <div class="col-md-6 form-group">
            <label for="code_name">Code Name <span class="text-danger">*</span></label>
            <input type="text" name="code_name" id="code_name" class="form-control" placeholder="Enter Supplier Code Name" required>
        </div>
        {{-- Phone --}}
        <div class="col-md-6 form-group">
            <label for="sup_mobile">Phone <span class="text-danger">*</span></label>
            <input type="text" name="sup_mobile" id="sup_mobile" class="form-control" placeholder="Enter Supplier Phone" required>
        </div>
        {{-- Email --}}
        <div class="col-md-6 form-group">
            <label for="sup_email">Email</label>
            <input type="email" name="sup_email" id="sup_email" class="form-control" placeholder="Enter Supplier Email">
        </div>
        {{-- Address --}}
        <div class="col-md-12 form-group">
            <label for="sup_address">Address</label>
            <textarea name="sup_address" id="sup_address" class="form-control" placeholder="Ener Supplier Address" cols="30" rows="2"></textarea>
        </div>
        {{-- City --}}
        <div class="col-md-6 form-group">
            <label for="sup_city">City</label>
            <input type="text" name="sup_city" id="sup_city" class="form-control" placeholder="Enter Supplier City">
        </div>
        {{-- State --}}
        <div class="col-md-6 form-group">
            <label for="sup_state">State</label>
            <input type="text" name="sup_state" id="sup_state" class="form-control" placeholder="Enter Supplier State">
        </div>
        {{-- Country --}}
        <div class="col-md-6 form-group">
            <label for="sup_country">Country</label>
            <input type="text" name="sup_country" id="sup_country" class="form-control" placeholder="Enter Supplier Country" value="Bangladesh">
        </div>
        {{-- Status --}}
        <div class="col-md-6 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#status_error" required name="status" id="status" class="form-control select" data-placeholder="Select Customer Status">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <span id="status_error"></span>
        </div>
    </div>
    <button type="submit" id="submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Submit</button>
    <button type="button" id="submiting" class="btn btn-sm btn-info float-right px-5" id="submiting" style="display: none;">
    <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
    
    <button type="button" class="btn btn-sm btn-danger" id="close">Close</button>
</form>