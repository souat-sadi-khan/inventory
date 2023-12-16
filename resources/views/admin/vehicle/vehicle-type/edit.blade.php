<form action="{{ route('admin.vehicle-type.update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')
    <div class="row">
        {{--  Vehicle Type --}}
        <div class="col-md-6 form-group">
            <label for="name"> Vehicle Type
            </label>
        <input type="text" value="{{$model->name}}" name="name" id="name" class="form-control" placeholder="Enter Vehicle Type Name"
                required>
        </div>

        {{-- Status --}}
        <div class="col-md-6 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#Vehicle_status_save_error" required name="status" id="status"
                class="form-control select" data-placeholder="Select Vehicle Type Status">
                <option {{$model->status =='Active'?'selected':''}} value="Active">Active</option>
                <option {{$model->status =='InActive'?'selected':''}} value="InActive">InActive</option>
            </select>
            <span id="Vehicle_status_save_error"></span>
        </div>

    </div>

    <button type="submit" id="submit" class="btn btn-primary float-right px-5">Submit</button>
    <button type="button" id="submiting" class="btn btn-sm btn-info float-right px-5" id="submiting"
        style="display: none;">
        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" id="close">Close</button>
</form>
