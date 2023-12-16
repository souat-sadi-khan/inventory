<div class="col-md-6 mx-auto mb-3 text-center border bg-light border-info">
    <b>Create New Category</b>
</div>
<form action="{{ route('admin.fiexd-assets.category_store') }}" data-select="brand_id" method="post"
    id="modal_form">
    @csrf
    <div class="row">

        {{-- Category Name --}}
        <div class="col-md-6 form-group mx-auto">
            <label for="assets_category">Category Name <span class="text-danger">*</span>
            </label>
            <input type="text" name="assets_category" id="assets_category" class="form-control"
                placeholder="Enter Category Name" required>
        </div>

    </div>

    <button type="submit" id="remote_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3"
            aria-hidden="true"></i>Submit</button>
    <button type="button" id="remote_submiting" class="btn btn-sm btn-info float-right px-5" id="submiting"
        style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>

