        <div class="card-body">
            <div class="card border border-primary">
                <div class="card-body text-center">
                    <form action="{{ route('admin.accounting.postLinkAccount') }}" id="modal_form" method="post">
                        <input type="hidden" name="transaction_payment_id" value="{{ $payment->id }}">
                    <div class="row">
                        <div class="col-sm-10 mx-auto">
                            <label for="date">@lang('Account')</label>
                             <select name="account_id" id="account_id" class="form-control select" required>
                                 <option value="">Select Account</option>
                                 @foreach ($accounts as $element)
                                    <option {{ $payment->account_id==$element->id?'selected':'' }} value="{{ $element->id }}"> {{ $element->name }}({{ $element->category }}) </option>
                                 @endforeach
                             </select>
                        </div>
                        <div class="col-md-6 mx-auto mt-2 text-center">
                            <button type="submit" id="submit" class="btn btn-primary btn-sm w-100">@lang('Link Account')</button>
                            <button type="button"  class="btn btn-primary btn-sm w-100" id="submitting" style="display: none;">
                            <i class="fa fa-spinner fa-spin fa-fw"></i>Linkimg...</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>