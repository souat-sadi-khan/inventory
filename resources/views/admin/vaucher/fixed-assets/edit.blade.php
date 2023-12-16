<form action="{{ route('admin.fiexd-assets.update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')


     <div class="row">
        {{-- Category --}}

        <div class="col-md-4 form-group">
            <label for="category">Category</label>
            <div class="input-group" >
                <select name="category" data-placeholder="Select Category" id="category" class="form-control select"
                    required>
                    <option value="">Select Category</option>
                    @php
                    $category = App\Models\Admin\FixedAssetsCategory::select('id', 'name')->get();
                    @endphp
                    @foreach ($category as $item)
                    <option {{$item->id == $model->category_id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>


        {{-- Product Name --}}
        <div class="col-md-4 form-group">
            <label id="Product" for="product_name">Product Name <span class="text-danger">*</span>
            </label>
        <input type="text" value="{{$model->product_name}}" name="product_name" id="product_name" class="form-control"
                placeholder="Enter Product Name" required>
        </div>

        {{-- Details --}}
        <div class="col-md-4 form-group" id="display">
            <label for="details">Details <span class="text-danger">*</span>
            </label>
            <input type="text" value="{{$model->details}}" name="details" id="details" class="form-control" placeholder="Enter Details" required>
        </div>

        {{-- Cost Per 1 Ps --}}
        <div class="col-md-3 form-group " id="alias_show">
            <label for="cost">Cost Per 1 Ps <span class="text-danger">*</span>
            </label>
            <input type="text" value="{{$model->cost}}" name="cost" id="cost1" class="form-control input_number" placeholder="Enter Cost Price" required>
        </div>


        {{-- Qty --}}
        <div class="col-md-3 form-group ">
            <label for="qty">Qty <span class="text-danger">*</span>
            </label>
            <input type="text" value="{{$model->qty}}" name="qty" id="qty1" class="form-control input_number" placeholder="00.00">
        </div>

        {{-- Total --}}
        <div class="col-md-3 form-group bank_show">
            <label for="total">Total <span class="text-danger">*</span>
            </label>
            <input type="text" value="{{$model->total}}" readonly name="total" id="total1" class="form-control input_number" value="0">
        </div>


        {{-- Depreciation (%) (Yearly) --}}
        <div class="col-md-3 form-group bank_show">
            <label for="depreciation">Depreciation (%) (Yearly) <span class="text-danger">*</span>
            </label>
            <input type="text" value="{{$model->depreciation}}" name="depreciation" id="depreciation" class="form-control" placeholder="0%">
        </div>

    </div>


    <button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Save</button>
    <button type="button" id="edit_submiting" class="btn btn-sm btn-info float-right" id="submiting" style="display: none;">
        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>


<script>
      $(document).on('keyup blur', '#cost1', function () {
        cost = parseInt($(this).val());
        qty = parseInt($('#qty1').val());
        total = parseInt((cost * qty));
        $('#total1').val(total);
    });

      $(document).on('keyup blur', '#qty1', function () {
        cost = parseInt($('#cost1').val());
        qty = parseInt($(this).val());
        total = parseInt((cost * qty));
        $('#total1').val(total);
    });

</script>
