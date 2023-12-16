<div class="col-md-6 mx-auto text-center border bg-light border-info">
    <b>Create New Category</b>
</div>
<form action="{{ route('admin.products.products.save_category') }}" data-select="product_category_id" method="post" class="remote_form">
    @csrf
    <div class="row">

        {{-- Product Category Image --}}
        <div class="col-md-12 form-group">
            <label for="category_image">Product Category Image</label>
            <input type="file" name="category_image" id="category_image" class="form-control dropify"> <span class="text-danger">Category Image must be under 500 KB and width & hieght can not be greater then 110 pixel </span>
        </div>

        {{-- Product Category Name --}}
        <div class="col-md-4 form-group">
            <label for="category_name">Product Category Name <span class="text-danger">*</span></label>
            <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Enter Product Category Name" required>
        </div>

        {{-- Parent Category --}}
        <div class="col-md-4 form-group">
            <label for="parent_id">Parent Category <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#parent_id_error" name="parent_id" id="parent_id" class="form-control" data-placeholder="Select Parent Category" required>
                <option value="x">As A Parent</option>
                @php
                    $query = App\Models\Products\Category::where('status', 1)->get();
                @endphp
                @foreach ($query as $item)
                    <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                @endforeach
            </select>
            <span id="parent_id_error"></span>
        </div>

        {{-- Status --}}
        <div class="col-md-4 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#status_error" required name="status" id="status" class="form-control select" data-placeholder="Select Customer Status">
                <option value="">Select  Customer Status</option>
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
            </select>
            <span id="status_error"></span>
        </div>

        {{-- Category Details --}}
        <div class="col-md-12 form-group">
            <label for="category_details">Category Details</label>
            <textarea name="category_details" id="category_details" class="form-control" cols="30" rows="2" placeholder="Enter Category Description"></textarea>
        </div>
    </div>
    <button type="submit" id="remote_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Submit</button>
    <button type="button" id="remote_submiting" class="btn btn-sm btn-info float-right px-5" id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>

<script>
    $('#parent_id').select2({width:'100%'});
</script>