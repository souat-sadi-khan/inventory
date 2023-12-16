<form action="{{ route('admin.user.update',$model->id) }}" method="post" id="modal_form">
    @method('PUT')
    @csrf
    <div class="row">
        {{-- Product Brand Image --}}
        <div class="col-md-12 form-group">
            <label for="image">User Image</label>
            <input type="file" name="image" id="image" class="form-control dropify" data-default-file="{{$model->image?asset('storage/images/user/'.$model->image):''}}"> <span class="text-danger">User Image must be under 500 KB and width & hieght can not be greater then 110 pixel </span>
        </div>
        {{-- Product Brand Name --}}
        <div class="col-md-6 form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter  Name" value="{{ $model->name }}" required>
        </div>
        {{-- Product Brand Code Name --}}
        <div class="col-md-6 form-group">
            <label for="username">User Name  </label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter User Name" value="{{ $model->username }}" required>
        </div>
        <div class="col-md-4 form-group">
            <label for="email">Email  </label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Enter User email" value="{{ $model->email }}" required>
        </div>
        {{-- Status --}}
        <div class="col-md-8 form-group">
            <label for="role">User Role <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#role_error" required name="role" id="role" class="form-control select" required>
                <option value="">Select  User Role</option>
                @foreach ($roles as $element)
                <option {{ $model->roles->first()->id==$element->id?'selected':'' }} value="{{ $element->id }}">{{ $element->name }}</option>
                @endforeach
            </select>
            <span id="role_error"></span>
        </div>

    </div>
    <button type="submit" id="submit" class="px-5 btn btn-primary float-right">Submit</button>
    <button type="button" id="submiting" class="px-5 btn btn-sm btn-info float-right" id="submiting" style="display: none;">
    <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
    
    <button type="button" class="btn btn-sm btn-danger" id="close">Close</button>
</form>