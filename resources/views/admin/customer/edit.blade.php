<form action="{{ route('admin.customer.update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')
    <div class="row">
        {{-- Name --}}
        <div class="col-md-6 form-group">
            <label for="customer_name">Name <span class="text-danger">*</span></label>
            <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Enter Customer Name" required value="{{ $model->customer_name }}">
        </div>
        {{-- Opening Balance --}}
        {{-- <div class="col-md-6 form-group">
            <label for="net_total">Opening Balance</label>
            <input type="text" autocomplete="off" name="net_total" id="net_total" class="form-control" placeholder="Enter Customer Opening Balance" value="{{ $opening_balance }}">
        </div> --}}
        {{-- Phone --}}
        <div class="col-md-6 form-group">
            <label for="customer_mobile">Phone <span class="text-danger">*</span></label>
            <input type="text" name="customer_mobile" id="customer_mobile" class="form-control" placeholder="Enter Customer Phone" required value="{{ $model->customer_mobile }}">
        </div>
        {{-- Date of Birth --}}
        <div class="col-md-6 form-group">
            <label for="date_of_birth">Date of Birth </label>
            <input type="text" name="date_of_birth" id="date_of_birth" class="form-control take_date" placeholder="Enter Customer Date of Birth" value="{{ $model->date_of_birth }}">
        </div>
        {{-- Email --}}
        <div class="col-md-6 form-group">
            <label for="customer_email">Email</label>
            <input type="email" name="customer_email" id="customer_email" class="form-control" placeholder="Enter Customer Email" value="{{ $model->customer_email }}">
        </div>
        {{-- Sex --}}
        <div class="col-md-4 form-group">
            <label for="customer_sex">Sex</label>
            <select name="customer_sex" id="edit_customer_sex" class="form-control select" data-placeholder="Select Sex">
                <option value="">Select Sex</option>
                <option {{ $model->customer_sex == 'Male' ? 'seleted' : ''}} value="Male">Male</option>
                <option {{ $model->customer_sex == 'Male' ? 'Female' : ''}} value="Female">Female</option>
                <option {{ $model->customer_sex == 'Male' ? 'Other' : ''}} value="Other">Other</option>
            </select>
        </div>
        {{-- Age --}}
        <div class="col-md-4 form-group">
            <label for="customer_age">Age</label>
            <input type="text" name="customer_age" id="customer_age" class="form-control" placeholder="Enter Customer Age" value="{{ $model->customer_age }}">
        </div>
        {{-- Gtin --}}
        <div class="col-md-4 form-group">
            <label for="gtin">Gtin</label>
            <input type="text" name="gtin" id="gtin" class="form-control" placeholder="Enter Customer Gtin" value="{{ $model->gtin }}">
        </div>
        {{-- Address --}}
        <div class="col-md-12 form-group">
            <label for="customer_address">Address</label>
            <textarea name="customer_address" id="customer_address" class="form-control" placeholder="Ener Customer Address" cols="30" rows="2"> {{ $model->customer_address }}</textarea>
        </div>
        {{-- City --}}
        <div class="col-md-6 form-group">
            <label for="customer_city">City</label>
            <input type="text" name="customer_city" id="customer_city" class="form-control" placeholder="Enter Customer City" value="{{ $model->customer_city }}">
        </div>
        {{-- State --}}
        <div class="col-md-6 form-group">
            <label for="customer_state">State</label>
            <input type="text" name="customer_state" id="customer_state" class="form-control" placeholder="Enter Customer State" value="{{ $model->customer_state }}">
        </div>
        {{-- Country --}}
        <div class="col-md-6 form-group">
            <label for="customer_country">Country</label>
            <input type="text" name="customer_country" id="customer_country" class="form-control" placeholder="Enter Customer Country" value="{{ $model->customer_country != '' ? $model->customer_country : 'Bangladesh' }}">
        </div>
        {{-- Status --}}
        <div class="col-md-6 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#parsley_satatus_error" required name="status" id="edit_status" class="form-control select" data-placeholder="Select Customer Status">
                <option value="">Select  Customer Status</option>
                <option {{ $model->status == 1 ? 'selected' : ''}} value="1">Active</option>
                <option {{ $model->status == 0 ? 'selected' : ''}} value="0">Inactive</option>
            </select>
            <span id="parsley_satatus_error"></span>
        </div>
    </div>
    <button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Save</button>
    <button type="button" id="edit_submiting" class="btn btn-sm btn-info float-right" id="submiting" style="display: none;">
    <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>