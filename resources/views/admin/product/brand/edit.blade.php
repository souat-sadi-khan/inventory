<form action="{{ route('admin.product-initiazile.brand.update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')
    <div class="row">

        {{-- Product Brand Image --}}
        <div class="col-md-12 form-group">
            <label for="brand_image">Product Brand Image</label>
            <input type="file" name="brand_image" id="brand_image" class="form-control dropify" data-default-file="{{ $model->brand_image != '' ? asset('storage/images/product/brand'. '/'. $model->brand_image) : ''}}"> <span class="text-danger" >Brand Image must be under 500 KB and width & hieght can not be greater then 110 pixel </span>
            @if ($model->brand_image)
                <input type="hidden" name="old_image" value="{{ $model->brand_image }}">
            @endif
        </div>

        {{-- Product Brand Name --}}
        <div class="col-md-4 form-group">
            <label for="brand_name">Product Brand Name <span class="text-danger">*</span></label>
            <input type="text" name="brand_name" id="brand_name" class="form-control" placeholder="Enter Product Brand Name" required value="{{ $model->brand_name }}">
        </div>

        {{-- Product Brand Code Name --}}
        <div class="col-md-4 form-group">
            <label for="brand_code_name">Product Brand Code </label>
            <input type="text" name="brand_code_name" id="brand_code_name" class="form-control" placeholder="Enter Product Brand Code Name" value="{{ $model->brand_code_name }}">
        </div>

        {{-- Status --}}
        <div class="col-md-4 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#status_error" required name="status" id="edit_status" class="form-control select" data-placeholder="Select Customer Status">
                <option value="">Select  Customer Status</option>
                <option {{ $model->status == 1 ? 'selected' : ''}} value="1">Active</option>
                <option {{ $model->status == 0 ? 'selected' : ''}} value="0">Inactive</option>
            </select>
            <span id="status_error"></span>
        </div>

        {{-- Brand Details --}}
        <div class="col-md-12 form-group">
            <label for="brand_details">Brand Details</label>
            <textarea name="brand_details" id="brand_details" class="form-control" cols="30" rows="2" placeholder="Enter Brand Description">{{ $model->brand_details }}</textarea>
        </div>
    </div>
    <button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Save</button>
    <button type="button" id="edit_submiting" class="btn btn-info float-right" id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>
