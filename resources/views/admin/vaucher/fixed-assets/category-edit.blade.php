<form action="{{ route('admin.fiexd-assets.category_update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')

     <div class="row">
        {{-- Category --}}

        <div class="col-md-6 mx-auto form-group ">
            <label for="category">Category Name <span class="text-danger">*</span>
            </label>
        <input type="text" name="category" id="category_name1" value="{{$model->name}}" class="form-control"
                placeholder="Enter Category Name" required>
        </div>
    </div>


    <button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Save</button>
    <button type="button" id="edit_submiting" class="btn btn-sm btn-info float-right" id="submiting" style="display: none;">
        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>

