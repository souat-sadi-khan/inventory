<form action="{{ route('admin.vehicle-transaction.update', $data->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')
    <div class="row">


        {{-- Transaction Type Type --}}

        <div class="col-md-6 form-group mx-auto">
            <label for="type">Transaction Type <span class="text-danger">*</span></label>
            <select data-parsley-errors-container="#Vehicle_Transactionsave_error" required name="type" id="type"
                class="form-control select" data-placeholder="Select Transaction Type">
                <option {{$data->type =='Income'?'selected':''}} value="Income">Income</option>
                <option {{$data->type =='Expence'?'selected':''}} value="Expence">Expence</option>
            </select>
            <span id="Vehicle_Transactionsave_error"></span>
        </div>


        <div class="col-md-6 form-group">
            <label for="vehicle_id">Vehicle List <span class="text-danger">*</span></label>
            <select name="vehicle_id" id="vehicle_id" class="form-control select" data-placeholder="Select Vehicle">
                <option value="">Select Vehicle</option>
                @foreach ($vehicle as $model)
                <option {{$data->vehicle_id ==$model->id?'selected':''}} value="{{ $model->id}}">{{$model->name}}  ({{$model->type->name}})</option>
                @endforeach
            </select>
            <span id="product_error"></span>
        </div>
        <div class="col-md-6 form-group">
            <label for="description">Description <span class="text-danger">*</span></label>
            <input autocomplete="off" type="text" value="{{$data->description}}" name="description" id="description"
                class="form-control" placeholder="Enter Description">
        </div>
        <div class="col-md-6 form-group">
            <label for="amount"> Amount <span class="text-danger">*</span></label>
            <input autocomplete="off" type="text" value="{{$data->amount}}" name="amount" id="amount"
                class="form-control input_number" placeholder="Enter  Amount">
        </div>
        <div class="col-md-6 form-group">
            <label for="date"> Date
            </label>
            <input type="text" name="date" value="{{$data->date}}" id="date" class="form-control take_date"
                value="{{date('Y-m-d')}}" placeholder="Enter  Date">
        </div>


    </div>

    <button type="submit" id="submit" class="btn btn-primary float-right px-5">Submit</button>
    <button type="button" id="submiting" class="btn btn-sm btn-info float-right px-5" id="submiting"
        style="display: none;">
        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" id="close">Close</button>
</form>
