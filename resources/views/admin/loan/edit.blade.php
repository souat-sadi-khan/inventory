<form action="{{ route('admin.loan.update',$model->id) }}" method="post" id="modal_form">
    @csrf 
    @method('PATCH')
    <input type="hidden" name="old_attatchment" value="{{$model->attatchment}}">
    {{-- Loan From --}}
    <div class="col-md-10 mx-auto form-group">
        <label for="loan_from">{{ __('Loan From') }} <span class="text-danger">*</span></label>
        <select data-parsley-errors-container="#loan_form_error" name="loan_from" id="loan_from" class="form-control select" required data-placeholder="Please Select One">
            <option value="">{{ __('Please Select One') }}</option>
            <option {{$model->loan_from == 'Bank' ? 'selected' : '' }} value="Bank">{{ __('Bank') }}</option>
            <option {{$model->loan_from == 'NGO' ? 'selected' : '' }} value="NGO">{{ __('NGO') }}</option>
            <option {{$model->loan_from == 'Person' ? 'selected' : '' }} value="Person">{{ __('Person') }}</option>
            <option {{$model->loan_from == 'Other' ? 'selected' : '' }} value="Other">{{ __('Other') }}</option>
        </select>
        <span id="loan_form_error"></span>
    </div>

    {{-- Reference Number --}}
    <div class="col-md-10 mx-auto form-group">
        <label for="ref_no">{{ __('Reference Number')}}</label>
        <input type="text" name="ref_no" id="ref_no" class="form-control" placeholder="Enter Reference Number" value="{{$model->ref_no}}">
    </div>

    {{-- Title --}}
    <div class="col-md-10 mx-auto form-group">
        <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Enter Loan Title" required value="{{$model->title}}">
    </div>

    {{-- Amount --}}
    <div class="col-md-10 mx-auto form-group">
        <label for="amount">{{ __('Amount') }} <span class="text-danger">*</span></label>
        <input required type="number" id="edit_amount" name="amount" class="form-control" placeholder="Enter Loan Amount" value="{{$model->amount}}">
    </div>

    {{-- Interest --}}
    <div class="col-md-10 mx-auto form-group">
        <label for="interest">{{ __('Interest') }} (%) <span class="text-danger">*</span></label>
        <input required type="number" id="edit_interest" name="interest" class="form-control" placeholder="Enter Interest Percen" value="{{$model->interest}}">
    </div>

    {{-- Payable --}}
    <div class="col-md-10 mx-auto form-group">
        <label for="payable">{{ __('Payable') }} <span class="text-danger">*</span></label>
        <input type="text" readonly required placeholder="Enter Payable Amount" class="form-control" id="edit_payable" name="payable" value="{{$model->payable}}">
    </div>

    {{-- Details --}}
    <div class="col-md-10 mx-auto form-group">
        <label for="details">{{ __('Details') }}</label>
        <textarea name="details" id="details" class="form-control" cols="30" rows="2" placeholder="Enter Description">{{$model->details}}</textarea>
    </div>

    {{-- Attatchment --}}
    <div class="col-md-10 mx-auto form-group">
        <label for="attatchment">{{ __('Attatchment') }}</label>
        <input type="file" name="attatchment" id="attatchment" class="form-control dropify">
    </div>

    <button type="submit" id="submit" class="btn btn-primary btn-sm">Store</button>
    <button type="button" id="submiting" class="btn btn-sm btn-info" id="submiting" style="display: none;">
        <i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>

    <button type="button" class="btn btn-sm btn-danger float-right" data-dismiss="modal">Close</button>
</form>
<script>
    _componentSelect2Normal();
    _componentDropFile();

    $('#edit_interest').keyup(function() {
        interest = parseInt($(this).val());
        amount = parseInt($('#edit_amount').val());
        per = (amount * interest) / 100;
        var result = amount + per;
        $('#edit_payable').val(result);
    });

    $('#edit_amount').keyup(function() {
        amount = parseInt($(this).val());
        interest = parseInt($('#edit_interest').val());
        per = (amount * interest) / 100 ;
        var result = amount + per;
        $('#edit_payable').val(result);
    });
</script>