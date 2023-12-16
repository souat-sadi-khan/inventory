<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Account;
use App\Models\Admin\AccountTransaction;
use App\Transaction;
use App\TransactionPayment;
use App\Utilities\TransactionUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class SaleReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $transactionUtil;
    public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }

    public function index()
    {
          if (request()->ajax()) {

            $purchases_returns = Transaction::leftJoin('customers', 'transactions.customer_id', '=', 'customers.id')
                    ->leftJoin(
                        'transactions AS T',
                        'transactions.return_parent_id',
                        '=',
                        'T.id'
                    )
                    ->leftJoin(
                        'transaction_payments AS TP',
                        'transactions.id',
                        '=',
                        'TP.transaction_id'
                    )
                    ->where('transactions.transaction_type', 'sale_return')
                    ->select(
                        'transactions.id',
                        'transactions.date',
                        'transactions.reference_no',
                        'customers.customer_name as customer',
                        'transactions.status',
                        'transactions.payment_status',
                        'transactions.net_total',
                        'transactions.return_parent_id',
                        'T.reference_no as parent_purchase',
                        DB::raw('SUM(TP.amount) as amount_paid')
                    )
                    ->groupBy('transactions.id');

            if (!empty(request()->customer_id)) {
                $customer_id = request()->customer_id;
                $purchases_returns->where('customers.id', $customer_id);
            }
            return Datatables::of($purchases_returns)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (!empty($row->return_parent_id)) {
                        $html .= '<a href="' . route('admin.sale_voucher.add_return', $row->return_parent_id) . '" class="btn btn-info btn-xs" ><i class="fa fa-pencil-square-o"></i>' .
                                __("Edit") .
                                '</a>';
                    } else {
                          $html .= '<a href="' . route('admin.sale_voucher.add_return', $row->return_parent_id) . '" class="btn btn-info btn-xs" ><i class="fa fa-pencil-square-o"></i>' .
                                __("Edit") .
                                '</a>';
                    }

                    $html .= '<a data-url="' . route('admin.sale_voucher.return.destroy', $row->id) . '" class="btn btn-danger btn-xs" id="delete_item" data-id="'.$row->id.'" ><i class="fa fa-trash"></i>' .
                                __("Delete") .
                                '</a>';


                    return $html;
                })
                ->removeColumn('id')
                ->removeColumn('return_parent_id')
                ->editColumn(
                    'net_total',
                    '<span class="display_currency net_total" data-currency_symbol="true" data-orig-value="{{$net_total}}">{{$net_total}}</span>'
                )
                ->editColumn('transaction_date', '{{$date}}')

                ->editColumn(
                    'payment_status',
                    '<span class="badge badge-info" data-orig-value="{{$payment_status}}" data-status-name="@if($payment_status != "paid"){{__( $payment_status)}}@else{{__("received")}}@endif"><span class="label @payment_status($payment_status)">@if($payment_status != "paid"){{__( $payment_status)}} @else {{__("received")}} @endif
                        </span></span>'
                )
                ->editColumn('parent_purchase', function ($row) {
                    $html = '';
                    if (!empty($row->parent_purchase)) {
                        $html = '<a href="#" data-url="' . route('admin.sale_voucher.sale.show', $row->return_parent_id) . '" id="content_managment">' . $row->parent_purchase . '</a>';
                    }
                    return $html;
                })

                ->editColumn('reference_no', function ($row) {
                    $html = '';
                    if (!empty($row->reference_no)) {
                        $return_id = !empty($row->return_parent_id) ? $row->return_parent_id : $row->id;
                        $html = '<a href="#" data-url="' . route('admin.sale_voucher.return.show', $return_id) . '" id="content_managment">' . $row->reference_no . '</a>';
                    }
                    return $html;
                })
                ->addColumn('payment_due', function ($row) {
                    $due = $row->net_total - $row->amount_paid;
                    return '<span class="display_currency payment_due" data-currency_symbol="true" data-orig-value="' . $due . '">' . $due . '</sapn>';
                })

                 ->addColumn('suppiler', function ($row) {
                    return $row->suppiler;
                })
                ->rawColumns(['net_total', 'action', 'payment_status', 'parent_purchase', 'payment_due','suppiler','reference_no'])
                ->make(true);
        }
        return view('admin.sale_return.index');
    }

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transaction=Transaction::where('transaction_type','Sale')->select('id','reference_no')->get();
        return view('admin.sale_return.create',compact('transaction'));
    }


    public function return_check(Request $request)
    {
     $transaction_id =$request->transaction_id;
     return response()->json(['success' => true, 'status' => 'success', 'message' =>'Checking Successfully','goto'=>route('admin.sale_voucher.add_return',$transaction_id)]);
    }


    public function add_return($id)
    {

        $sale = Transaction::where('transaction_type', 'Sale')
                        ->with(['sell_lines', 'customer', 'return_parent',  'sell_lines.product'])
                        ->find($id);

        foreach ($sale->sell_lines as $key => $value) {
            $qty_available = $value->qty;

            $sale->sell_lines[$key]->formatted_qty_available = $qty_available;
        }
        $account_id ="";
        $return_id=null;
        if (isset($sale->return_parent)) {
        $return_id =$sale->return_parent->id;
        }
        $account_exit=TransactionPayment::where('transaction_id',$return_id)->first();
        if (isset($account_exit)) {
           $account_id =$account_exit->account_id;
        }
        $accounts =  Account::where('status', 'Active')->get();

        return view('admin.sale_return.add')
                    ->with(compact('sale','accounts','account_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sale = Transaction::where('transaction_type', 'Sale')
                        ->with(['sell_lines'])
                        ->findOrFail($request->input('transaction_id'));

        $customer = Account::where('customer_id', $sale->customer_id)->first();
        $customer_account_id = $customer->id;

            $return_quantities = $request->input('returns');
            $return_total = 0;

            foreach ($sale->sell_lines as $sale_line) {
                $old_return_qty = $sale_line->quantity_returned;

                $return_quantity = !empty($return_quantities[$sale_line->id]) ? $return_quantities[$sale_line->id] : 0;

                $sale_line->quantity_returned = $return_quantity;
                $sale_line->save();
                $return_total += $sale_line->unit_price * $sale_line->quantity_returned;
                //Decrease quantity in variation location details
                if ($old_return_qty != $sale_line->quantity_returned) {
                    $this->transactionUtil->IncreaseVariationQty(
                        $sale_line->product_id,
                        $sale_line->quantity_returned,
                        $old_return_qty
                    );
                }
            }

            // $return_total_inc_tax = $return_total;

            $return_transaction_data = [
                'discount'=>$request->discount,
                'discount_type'=>$request->discount_type,
                'discount_amount'=>$request->discount_amount,
                'tax'=>$request->tax_amount,
                'sub_total' => $return_total,
                'net_total' => $request->total_return,
                'paid' => $request->total_return
            ];

            $ref = $request->input('ref_no');

            if (empty($ref)) {
                //Update reference count
                $return_transaction_data['reference_no'] = $this->transactionUtil->setReference('sale_return');
                $ref = $this->transactionUtil->setReference('sale_return');
            }

            $return_transaction = Transaction::where('transaction_type', 'sale_return')->where('return_parent_id', $sale->id)->first();

            if (!empty($return_transaction)) {
                $return_transaction->update($return_transaction_data);
            } else {
                $return_transaction_data['transaction_type'] = 'sale_return';
                $return_transaction_data['status'] = 'final';
                $return_transaction_data['customer_id'] = $sale->customer_id;
                $return_transaction_data['date'] = date('Y-m-d');
                $return_transaction_data['created_by'] = auth()->user()->id;
                $return_transaction_data['type'] = 'Debit';
                $return_transaction_data['return_parent_id'] = $sale->id;

                $return_transaction = Transaction::create($return_transaction_data);
            }

           $return_payment =TransactionPayment::where('transaction_id',$return_transaction->id)->first();
            $payment_data['customer_id']=$sale->customer_id;
            $payment_data['method']='cash';
            $payment_data['type']='Debit';
            $payment_data['payment_date']=date('Y-m-d');
            $payment_data['amount']=$return_transaction->net_total;
            if (!empty($return_payment)) {
                $return_payment->update($payment_data);
            }else{
                $payment_data['transaction_id']=$return_transaction->id;
                $return_payment=TransactionPayment::create($payment_data);
            }
            if ($request->account_id) {
                $account = Account::find($request->account_id);
                $this->account_transaction($return_payment->id,$request->account_id);

                /* $acc_transaction1 = new AccountTransaction;
                $acc_transaction1->account_id = $customer_account_id;
                $acc_transaction1->transaction_id = $return_transaction->id;
                $acc_transaction1->transaction_payment_id = $return_payment->id;
                $acc_transaction1->type = 'Debit';
                $acc_transaction1->sub_type = 'Sale Return';
                $acc_transaction1->amount = $request->total_return;
                $acc_transaction1->reff_no = $ref;
                $acc_transaction1->operation_date = date('Y-m-d');
                $acc_transaction1->note = 'Sale Return From ' . $account->name;
                $acc_transaction1->save(); */
            }



            //update payment status
            $this->transactionUtil->updatePaymentStatus($return_transaction->id, $return_transaction->net_total);

            $sale->return=true;
            $sale->save();

            $acc_transaction = new AccountTransaction;
            $acc_transaction->account_id =  Account::where('name', 'Product')->first()->id;
            $acc_transaction->transaction_id = $return_transaction->id;
            $acc_transaction->transaction_payment_id = $return_payment->id;
            $acc_transaction->type = 'Debit';
            $acc_transaction->sub_type = 'Sale Return';
            $acc_transaction->amount = $request->total_return;
            $acc_transaction->reff_no = $ref;
            $acc_transaction->operation_date = date('Y-m-d');
            $acc_transaction->note = 'Sale Return ';
            $acc_transaction->save();

            return response()->json(['success' => true, 'status' => 'success', 'message' =>'Information Updated','window'=>route('admin.sale_voucher.return_print',$sale->id)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $model = Transaction::with(['return_parent', 'sell_lines', 'sell_lines.product'])->find($id);
        return view('admin.sale_return.show',compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $sale_return = Transaction::where('id', $id)
                                ->where('transaction_type', 'sale_return')
                                ->with(['sell_lines'])
                                ->first();

                DB::beginTransaction();

                    $parent_sale = Transaction::where('id', $sale_return->return_parent_id)
                                ->where('transaction_type', 'Sale')
                                ->with(['sell_lines'])
                                ->first();

                    $updated_sale_lines = $parent_sale->sell_lines;
                    foreach ($updated_sale_lines as $sale_line) {
                        $this->transactionUtil->updateProductQuantity($sale_line->product_id, $sale_line->quantity_returned, 0, null, false);
                        $sale_line->quantity_returned = 0;
                        $sale_line->save();
                    }

                //Delete account transactions
                AccountTransaction::where('transaction_id', $id)->delete();
                //Delete Transaction
                $sale_return->delete();

                //Delete account transactions
                // AccountTransaction::where('transaction_id', $id)->delete();

                DB::commit();

                return response()->json(['status' => 'success', 'message' => 'Data is deleted successfully']);
    }

    private function account_transaction($payment_id,$account_id)
    {
        $payment = TransactionPayment::findOrFail($payment_id);
        $payment->account_id = $account_id;
        $payment->save();
        $payment_type = !empty($payment->transaction->transaction_type) ? $payment->transaction->transaction_type : null;
        if (empty($payment_type)) {
            $child_payment = TransactionPayment::where('parent_id', $payment->id)->first();
            $payment_type = !empty($child_payment->transaction->transaction_type) ? $child_payment->transaction->transaction_type : null;
        }

        AccountTransaction::updateAccountTransaction($payment, $payment_type);
    }


     public function view($id)
    {

        $model = Transaction::with(['return_parent', 'sell_lines', 'sell_lines.product'])->find($id);
        return view('admin.sale_return.view',compact('model'));
    }
}
