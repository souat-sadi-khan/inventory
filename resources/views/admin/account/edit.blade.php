<form action="{{ route('admin.account.update', $model->id) }}" method="post" id="modal_form">
    @csrf
    @method('PATCH')
    <div class="row">
        {{-- Account Type --}}
        <div class="col-md-6 form-group">
            <label for="category">Account Type
            </label>
            <div class="input-group">
                <select readonly name="category" id="category" data-placeholder="Please Select One.."
                    class="form-control select">
                    <option value="{{$model->category}}">{{toWord($model->category)}} </option>
                </select>
            </div>
        </div>
        {{-- Account Name --}}
        <div class="col-md-6 form-group">
            <label id="account" for="account_name">Account Name <span
            class="text-danger">*</span>
        </label>
        <input type="text" value="{{$model->name}}" name="account_name" id="account_name" class="form-control"
        placeholder="Enter Account Name" required>
    </div>
    {{-- Display Name --}}
    <div class="col-md-6 form-group" id="display">
        <label for="display_name">Display Name <span
        class="text-danger">*</span>
    </label>
    <input type="text" value="{{$model->display_name}}" name="display_name" id="display_name" class="form-control"
    placeholder="Enter Display Name" required>
</div>
{{-- Alias --}}
<div class="col-md-6 form-group " id="alias_show">
    <label for="alias">Alias <span class="text-danger">*</span>
</label>
<input type="text" value="{{$model->alias}}" name="alias" id="alias" class="form-control"
placeholder="Enter Alias" required>
</div>
{{-- For Bank Accout    --}}
{{-- Account no --}}
<div class="col-md-6 form-group bank_show" style="display: none;">
<label for="account_no">Account No <span
class="text-danger">*</span>
</label>
<input type="text" value="{{$model->account_no}}" name="account_no" id="account_no" class="form-control"
placeholder="Enter Account No">
</div>
{{-- Check Form --}}
<div class="col-md-6 form-group bank_show" style="display: none;">
<label for="check_form">Check Form <span
class="text-danger">*</span>
</label>
<input type="text" value="{{$model->check_form}}" name="check_form" id="check_form" class="form-control"
placeholder="Enter Check Form">
</div>
{{-- Check To --}}
<div class="col-md-6 form-group bank_show" style="display: none;">
<label for="check_to">Check To <span class="text-danger">*</span>
</label>
<input type="text" value="{{$model->check_to}}" name="check_to" id="check_to" class="form-control"
placeholder="Enter Check To">
</div>
{{-- Customer Section --}}
{{-- Phone --}}
<div class="col-md-6 form-group customer_show" style="display: none;">
<label for="phone">Phone <span class="text-danger">*</span>
</label>
<input type="text" value="{{$model->phone}}" name="phone" id="phone" class="form-control"
placeholder="Enter Phone">
</div>
{{-- Email --}}
<div class="col-md-6 form-group customer_show" style="display: none;">
<label for="email">Email <span class="text-danger">*</span>
</label>
<input type="email" value="{{$model->email}}" name="email" id="email" class="form-control"
placeholder="Enter Email">
</div>
{{-- Opening Date --}}
<div class="col-md-6 form-group " id="opening_date_show">
<label for="opening_date">Opening Date <span
class="text-danger">*</span>
</label>
<input type="text" value="{{$model->opening_date}}" name="opening_date" id="opening_date"
class="form-control take_date" placeholder="Enter Opening Date" required>
</div>
{{-- Salary --}}
<div class="col-md-6 form-group customer_show" style="display: none;">
<label for="salary">Salary <span class="text-danger">*</span>
</label>
<input type="text" value="{{$model->salary}}" name="salary" id="salary" class="form-control"
placeholder="Enter Salary">
</div>
{{-- Status Type --}}
<div class="col-md-6 form-group">
<label for="status">Status Type
</label>
<div class="input-group">
<select readonly name="status" id="status" data-placeholder="Please Select One.."
class="form-control select">
<option value="">Please Select One .. </option>
<option {{$model->status =='Active'?'selected':''}} value="Active">Active</option>
<option {{$model->status =='InActive'?'selected':''}} value="InActive">InActive</option>
</select>
</div>
</div>
{{-- Address --}}
<div class="col-md-12 form-group customer_show" style="display: none;">
<label for="address">Address <span class="text-danger">*</span>
</label>
<textarea name="address" class="form-control" id="address" >{{$model->address}}</textarea>
</div>
</div>
<button type="submit" id="edit_submit" class="btn btn-primary float-right px-5"><i class="fa fa-floppy-o mr-3" aria-hidden="true"></i>Save</button>
<button type="button" id="edit_submiting" class="btn btn-sm btn-info float-right" id="submiting" style="display: none;">
<i class="fa fa-spinner fa-spin fa-fw"></i>Loading...</button>
<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
</form>
<script>
$( document ).ready(function() {
var value = $('#category').val();
if (value == 'Bank_Account') {

$('#display').show();
$('#alias_show').hide();
$('.bank_show').show(500);
$('.customer_show').hide(500);
$('#account').html('Bank Name');
$("#bank_name").prop('required', true);
$("#account_no").prop('required', true);
$("#check_form").prop('required', true);
$("#check_to").prop('required', true);
$("#alias").prop('required', false);
$("#opening_date").prop('required', false);
$("#phone").prop('required', false);
$("#email").prop('required', false);
} else if (value == 'Employee') {
$('.bank_show').hide(500);
$('.customer_show').show(500);
$('#display').hide();
$('#account').html('Employee Name');
$('#alias_show').show();
$("#phone").prop('required', true);
$("#email").prop('required', true);
$("#display_name").prop('required', false);
$("#account_no").prop('required', false);
$("#check_form").prop('required', false);
$("#check_to").prop('required', false);
} else {
$('#display').show();
$('#alias_show').show();
$('.bank_show').hide(500);
$('.customer_show').hide(500);
$('#account').html('Account Name');
$("#bank_name").prop('required', false);
$("#account_no").prop('required', false);
$("#check_form").prop('required', false);
$("#check_to").prop('required', false);
$("#phone").prop('required', false);
$("#email").prop('required', false);

}
});
</script>