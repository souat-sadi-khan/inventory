<form action="{{ route('admin.vehicle.update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')
    <div class="row">


        {{-- Vehicle Type --}}
        <div class="col-md-6 form-group">
            <label for="vehicle_type_id">Vehicle Type <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#Vehicle_type_save_error" required name="vehicle_type_id"
                id="vehicle_type_id" class="form-control select" data-placeholder="Select Vehicle Type">
                <option value="">Select Vehicle Type </option>
                @foreach ($types as $type)
                <option {{$type->id == $model->vehicle_type_id?'selected':''}} value="{{$type->id}}">{{$type->name}}
                </option>
                @endforeach
            </select>
            <span id="Vehicle_type_save_error"></span>
        </div>

               {{--  Vehicle Name  --}}
            <div class="col-md-6 form-group">
                <label for="name"> Vehicle Name <span class="text-danger">*</span>
                </label>
                <input type="text" value="{{$model->name}}" name="name" id="name" class="form-control"
                    placeholder="Enter Vehicle Name" required>
            </div>

        {{--  Registrarion Number  --}}
        <div class="col-md-6 form-group">
            <label for="regi_no"> Registrarion Number <span class="text-danger">*</span>
            </label>
            <input type="text" value="{{$model->regi_no}}" name="regi_no" id="regi_no" class="form-control"
                placeholder="Enter Registrarion Number" required>
        </div>

        {{--  Chassis Number  --}}
        <div class="col-md-6 form-group">
            <label for="chassis_no"> Chassis Number 
            </label>
            <input type="text" value="{{$model->chassis_no}}" name="chassis_no" id="chassis_no" class="form-control"
                placeholder="Enter Chassis Number">
        </div>

        {{--  Model Number  --}}
        <div class="col-md-6 form-group">
            <label for="model_no"> Model Number <span class="text-danger">*</span>
            </label>
            <input type="text" value="{{$model->model_no}}" name="model_no" id="model_no" class="form-control"
                placeholder="Enter Model Number" required>
        </div>

        {{--  Engine Number  --}}
        <div class="col-md-6 form-group">
            <label for="engine_no"> Engine Number 
            </label>
            <input type="text" value="{{$model->engine_no}}" name="engine_no" id="engine_no" class="form-control"
                placeholder="Enter Engine Number">
        </div>


        {{--  License Number  --}}
        <div class="col-md-6 form-group">
            <label for="license_no"> License Number 
            </label>
            <input type="text" name="license_no" value="{{$model->license_no}}" id="license_no" class="form-control" placeholder="Enter License Number"
            >
        </div>

        {{--  License Validity  --}}
        <div class="col-md-6 form-group">
            <label for="license_validity"> License Validity 
            </label>
            <input type="text" name="license_validity" value="{{$model->license_validity}}" id="license_validity" class="form-control"
                placeholder="Enter License Validity">
        </div>


        {{--  Road Permit  --}}
        <div class="col-md-6 form-group">
            <label for="road_permit"> Road Permit 
            </label>
            <input type="text" name="road_permit" value="{{$model->road_permit}}" id="road_permit" class="form-control" placeholder="Enter Road Permit"
            >
        </div>

        {{--  Total Investment  --}}
        <div class="col-md-6 form-group">
            <label for="investment"> Total Investment <span class="text-danger">*</span>
            </label>
            <input type="number" name="investment" value="{{$model->investment}}" id="investment" class="form-control"
                placeholder="Enter Total Investment" required>
        </div>


        {{-- Status --}}
        <div class="col-md-6 form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#Vehicles_status_save_error" required name="status" id="status"
                class="form-control select" data-placeholder="Select Vehicle Status">
                <option {{$model->status =='Active'?'selected':''}} value="Active">Active</option>
                <option {{$model->status =='InActive'?'selected':''}} value="InActive">InActive</option>
            </select>
            <span id="Vehicles_status_save_error"></span>
        </div>



    </div>

    <button type="submit" id="submit" class="btn btn-primary float-right px-5">Submit</button>
    <button type="button" id="submiting" class="btn btn-sm btn-info float-right px-5" id="submiting"
        style="display: none;">
        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" id="close">Close</button>
</form>
