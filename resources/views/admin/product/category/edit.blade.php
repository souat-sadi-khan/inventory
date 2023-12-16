<form action="{{ route('admin.product-initiazile.category.update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')
    <div class="row">

        {{-- Product Category Image --}}
        <div class="col-md-12 form-group">
            <label for="category_image">Product Category Image</label>
            <input type="file" name="category_image" id="category_image" class="form-control dropify" data-default-file="{{ $model->category_image != '' ? asset('storage/images/product/category'. '/'. $model->category_image) : ''}}"> <span class="text-danger">Category Image must be under 500 KB and width & hieght can not be greater then 110 pixel </span>
            @if ($model->category_image)
                <input type="hidden" name="old_image" value="{{ $model->category_image }}">
            @endif
        </div>

        {{-- Product Category Name --}}
        <div class="col-md-4 form-group">
            <label for="category_name">Product Category Name <span class="text-danger">*</span></label>
            <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Enter Product Category Name" required value="{{ $model->category_name }}">
        </div>

        {{-- Parent Category --}}
        <div class="col-md-4 form-group">
            <label for="parent_id">Parent Category <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#parent_id_error" name="parent_id" id="edit_parent_id" class="form-control select" data-placeholder="Select Parent Category" required>
                <option {{ $model->parent_id == 'x' ? 'selected' : ''}} value="x">As A Parent</option>
                @php
                    $query = App\MOdels\Products\Category::where('status', 1)->get();
                @endphp
                @foreach ($query as $item)
                    <option {{ $model->parent_id == $item->id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->category_name }}</option>
                @endforeach
            </select>
            <span id="parent_id_error"></span>
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

        {{-- Category Details --}}
        <div class="col-md-12 form-group">
            <label for="category_details">Category Details</label>
            <textarea name="category_details" id="category_details" class="form-control" cols="30" rows="2" placeholder="Enter Category Description">{{ $model->category_details }}</textarea>
        </div>
    </div>
    <button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Save</button>
    <button type="button" id="edit_submiting" class="btn btn-info float-right" id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>
