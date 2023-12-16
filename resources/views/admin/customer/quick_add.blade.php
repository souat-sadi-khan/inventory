<div class="col-md-6 mx-auto mb-3 text-center border bg-light border-info">
    <b>Create New Customer</b>
</div>
<form action="{{ route('admin.postquick_customer') }}" data-select="customer_id" method="post" class="remote_form">
    @csrf
    <div class="row">
        {{-- Name --}}
        <div class="col-md-4 form-group">
            <label for="customer_name">Name <span class="text-danger">*</span></label>
            <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Enter Customer Name" required>
        </div>
        {{-- Phone --}}
        <div class="col-md-4 form-group">
            <label for="customer_mobile">Phone <span class="text-danger">*</span></label>
            <input type="text" name="customer_mobile" id="customer_mobile" class="form-control" placeholder="Enter Customer Phone" required>
        </div>
        {{-- Date of Birth --}}
        <div class="col-md-4 form-group">
            <label for="date_of_birth">Date of Birth </label>
            <input type="text" name="date_of_birth" id="date_of_birth" class="form-control take_date" placeholder="Enter Customer Date of Birth">
        </div>
        {{-- Email --}}
        <div class="col-md-6 form-group">
            <label for="customer_email">Email</label>
            <input type="email" name="customer_email" id="customer_email" class="form-control" placeholder="Enter Customer Email">
        </div>
        {{-- Sex --}}
        <div class="col-md-6 form-group">
            <label for="customer_sex">Sex</label>
            <select name="customer_sex" id="customer_sex" class="form-control select" data-placeholder="Select Sex">
                <option value="">Select Sex</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        {{-- Age --}}
        <div class="col-md-6 form-group">
            <label for="customer_age">Age</label>
            <input type="text" name="customer_age" id="customer_age" class="form-control" placeholder="Enter Customer Age">
        </div>
        {{-- Gtin --}}
        <div class="col-md-6 form-group">
            <label for="gtin">Gtin</label>
            <input type="text" name="gtin" id="gtin" class="form-control" placeholder="Enter Customer Gtin">
        </div>
        {{-- Address --}}
        <div class="col-md-12 form-group">
            <label for="customer_address">Address</label>
            <textarea name="customer_address" id="customer_address" class="form-control" placeholder="Ener Customer Address" cols="30" rows="2"></textarea>
        </div>
        {{-- City --}}
        <div class="col-md-6 form-group">
            <label for="customer_city">City</label>
            <input type="text" name="customer_city" id="customer_city" class="form-control" placeholder="Enter Customer City">
        </div>
        {{-- State --}}
        <div class="col-md-6 form-group">
            <label for="customer_state">State</label>
            <input type="text" name="customer_state" id="customer_state" class="form-control" placeholder="Enter Customer State">
        </div>
        {{-- Country --}}
        <div class="col-md-6 form-group">
            <label for="customer_country">Country</label>
            <input type="text" name="customer_country" id="customer_country" class="form-control" placeholder="Enter Customer Country" value="Bangladesh">
        </div>
        {{-- Status --}}
        <div class="col-md-6 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#customer_status_save_error" required name="status" id="status" class="form-control select" data-placeholder="Select Customer Status">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <span id="customer_status_save_error"></span>
        </div>
    </div>
    <button type="submit" id="submit" class="btn btn-primary float-right px-5">Submit</button>
    <button type="button" id="submiting" class="btn btn-sm btn-info float-right px-5" id="submiting" style="display: none;">
    <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
    
    <button type="button" class="btn btn-sm btn-danger" id="close">Close</button>
</form>