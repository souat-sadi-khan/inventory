<div class="col-md-6 mx-auto text-center mb-3 border bg-light border-info">
    <b> Opening Balance</b>
</div>
<form action="{{ route('admin.vaucher.ob_store') }}" method="post" id="modal_form">
    @csrf
    <div class="row">
        {{-- Receipt By A/c --}}
        <div class="col-md-6 form-group">
            <label for="account">Opening Balance Account By A/c <span
                    class="text-danger">*</span></label>
            <select name="account" id="account" required class="form-control select" data-placeholder="Select Account">
                <option value="">Select Account</option>
                @foreach ($models as $model)

                    <option {{ $model->id == 1 ? 'selected' : ''}} value="{{ $model->id }}">{{ $model->name }} ({{ toWord($model->category) }})</option>
                @endforeach
            </select>
        </div>

         {{-- Debit/Credit --}}
        <div class="col-md-6 form-group">
            <label for="type">Debit/Credit <span
                    class="text-danger">*</span></label>
            <select name="type" id="type" required class="form-control select" data-placeholder="Select Type">
                <option value="">Select Type</option>
                <option  value="Debit">Debit</option>
                <option value="Credit">Credit</option>
            </select>
        </div>

        {{-- Payment Amount --}}
        <div class="col-md-6 form-group">
            <label for="amount">Payment Amount <span
                    class="text-danger">*</span></label>
            <input autocomplete="off" type="text" name="amount" required id="amount" class="form-control input_number" placeholder="Enter Payment Amount">
        </div>

        {{-- Operation Date --}}
        <div class="col-md-6 form-group " >
            <label for="operation_date">Operation Date 
            </label>
            <input type="text" name="operation_date" id="operation_date"
                class="form-control take_date" value="{{date('Y-m-d')}}" placeholder="Enter Operation Date">
        </div>

         {{-- Description --}}
            <div class="col-md-12 form-group">
                <label for="note">Description
                </label>
                    <textarea name="note" class="form-control" id="note" >Opening Balance</textarea>
            </div>

    </div>

    <button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Save</button>
    <button type="button" id="edit_submiting" class="btn btn-sm btn-info float-right" id="submiting" style="display: none;">
        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>