@php
    $payable = $model->payable;
    $due = $model->due;
    $paid = $payable - $due;
@endphp
<h4>Details</h4>
<div class="table-responsive" style="font-size: 12px;">
    <table class="table table-bordered table-striped">
        <tr>
            <td class="text-right" width="30%">Ref. No.</td>
            <td>{{$model->ref_no}}</td>
        </tr>
        <tr>
            <td class="text-right" width="30%">Date Time</td>
            <td>{{formatDate($model->date)}}</td>
        </tr>
        <tr>
            <td class="text-right" width="30%">Created By</td>
            <td>{{$model->admin->name}}</td>
        </tr>
        <tr>
            <td class="text-right" width="30%">Loan From</td>
            <td>{{$model->loan_from}}</td>
        </tr>
        <tr>
            <td class="text-right" width="30%">Title</td>
            <td>{{$model->title}}</td>
        </tr>
        <tr>
            <td class="text-right" width="30%">Details</td>
            <td>{{$model->details}}</td>
        </tr>
        <tr>
            <td class="text-right" width="30%">Attachment</td>
            <td>
                @if ($model->attachment != '')
                    <img src="{{asset('storage/file/loan') . '/'. $model->attatchment }}" width="250px" alt="Loan Attatchment">
                @endif
            </td>
        </tr>
        <tr class="table-secondary">
            <td class="text-right" width="30%">Basic Amount	</td>
            <td>{{get_option('currency_symbol'). ' '. number_format($model->amount, 2)}}</td>
        </tr>
        <tr class="table-secondary">
            <td class="text-right" width="30%">Interest(%)</td>
            <td>{{number_format($model->interest, 2)}}%</td>
        </tr>
        <tr>
            <td class="text-right" width="30%">Payable Amount</td>
            <td class="table-info">
                {{get_option('currency_symbol'). ' '. number_format($model->payable, 2)}}
            </td>
        </tr>
        <tr>
            <td class="text-right" width="30%">Paid Amount</td>
            <td class="table-success">
                {{get_option('currency_symbol'). ' '. number_format($paid, 2)}}    
            </td>
        </tr>
        <tr>
            <td class="text-right" width="30%">Due Amount</td>
            <td class="table-danger">
                {{get_option('currency_symbol'). ' '. number_format($model->due, 2)}}
            </td>
        </tr>
    </table>
</div>

<h6>Payments</h6>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-primary text-white">
            <tr>
                <th>Ref. No.</th>
                <th>Date Time</th>
                <th>Notes</th>
                <th>Paid By	</th>
                <th class="text-right">Paid Amount </th>
            </tr>
        </thead>
        <tbody>
            @php
                $query = App\Models\LoanPayment::where('loan_id', $model->id)->get();
            @endphp
            @if (count($query))
                @foreach ($query as $item)
                    <tr class="table-success">
                        <td>{{$item->ref_no}} </td>
                        <td>{{formatDate($item->created_at)}}</td>
                        <td>{{$item->note}} </td>
                        <td>{{$item->admin->name}} </td>
                        <td class="text-right">
                            {{get_option('currency_symbol'). ' '. number_format($item->paid, 2)}}    
                        </td>
                    </tr>
                @endforeach
            @else 
                <tr class="table-secondary">
                    <td colspan="5">No Data Available</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="col-md-12 text-center">
    <button type="button" class="btn btn-primary"> <i class="fa fa-print" aria-hidden="true"></i> &nbsp;Print</button>
</div>