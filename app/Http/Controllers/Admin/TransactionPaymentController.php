<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Account;
use App\Models\Admin\AccountTransaction;
use App\Transaction;
use App\TransactionPayment;
use App\Utilities\TransactionUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class TransactionPaymentController extends Controller
{
  protected $transactionUtil;
   public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }

    public function purchase_payment(Request $request)
    {
         $validator = $request->validate([
            'payment_date'=>'required',
            'amount'=>'required|numeric',
        ]);

         $transaction = Transaction::find($request->get('transaction_id'));
        $supplier = Account::where('supplier_id', $transaction->supplier_id)->first();
        $supplier_account_id = $supplier->id;

        if ($transaction->paid+$request->amount>$transaction->net_total) {
             throw ValidationException::withMessages(['message' => __('Payble Amount Not> Net Total')]);
          }

            $ref_no = $request->get('reference_no');
            $previously_paid = $transaction->paid;
            $previously_due = $transaction->due;
            $transaction->paid = round(($previously_paid + $request->get('amount')), 2);
            $transaction->due = $previously_due-$request->get('amount');
            $transaction->save();

               //saving paid amount into payment table
            $payment =new TransactionPayment;
            $payment->transaction_id=$transaction->id;
            $payment->account_id =$request->account_id;
            $payment->supplier_id=$transaction->supplier_id;
            $payment->method =$request->method;
            $payment->payment_date =$request->payment_date;
            $payment->transaction_no =$request->check_no;
            $payment->amount =$request->amount;
            $payment->note =$request->note;
            $payment->type ='Debit';
            $payment->payment_ref_no =$request->payment_ref_no;
            $payment->created_by =auth()->user()->id;
            $payment->save();

            if ($request->account_id) {
                $account = Account::find($request->account_id);
                $acc_transaction = new AccountTransaction;
                $acc_transaction->account_id = $request->account_id;
                $acc_transaction->transaction_id = $transaction->id;
                $acc_transaction->transaction_payment_id = $payment->id;
                $acc_transaction->type = check_debit_credit($request->account_id);
                $acc_transaction->sub_type = 'Purchase';
                $acc_transaction->amount = $request->amount;
                $acc_transaction->reff_no = $transaction->reference_no;
                $acc_transaction->operation_date = $request->payment_date;
                $acc_transaction->note = 'Purchase Paid To Supplier Account';
                $acc_transaction->save();

                $acc_transaction1 = new AccountTransaction;
                $acc_transaction1->account_id = $supplier_account_id;
                $acc_transaction1->transaction_id = $transaction->id;
                $acc_transaction1->transaction_payment_id = $payment->id;
                $acc_transaction1->type = 'Debit';
                $acc_transaction1->sub_type = 'Purchase';
                $acc_transaction1->amount = $request->amount;
                $acc_transaction1->reff_no = $transaction->reference_no;
                $acc_transaction1->operation_date = $request->payment_date;
                $acc_transaction1->note = 'Purchase Paid From ' . $account->name;
                $acc_transaction1->save();
             }


            $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->net_total);
            return response()->json(['success' => true, 'status' => 'success', 'message' => 'Payment Successfully.', 'window' => route('admin.pur_voucher.purchase.printpayment',$payment->id)]);
    }



  public function sale_payment(Request $request)
    {
         $validator = $request->validate([
            'payment_date'=>'required',
            'amount'=>'required|numeric',
        ]);
        $transaction = Transaction::find($request->get('transaction_id'));

        $customer = Account::where('customer_id', $transaction->customer_id)->first();
        $customer_account_id = $customer->id;

        if ($transaction->paid+$request->amount>$transaction->net_total) {
             throw ValidationException::withMessages(['message' => __('Payble Amount Not> Net Total')]);
          }

            $ref_no = $request->get('reference_no');
            $previously_paid = $transaction->paid;
            $previously_due = $transaction->due;
            $transaction->paid = round(($previously_paid + $request->get('amount')), 2);
            $transaction->due = $previously_due-$request->get('amount');
            $transaction->save();

               //saving paid amount into payment table
            $payment =new TransactionPayment;
            $payment->transaction_id=$transaction->id;
            $payment->account_id =$request->account_id;
            $payment->customer_id=$transaction->customer_id;
            $payment->method =$request->method;
            $payment->payment_date =$request->payment_date;
            $payment->transaction_no =$request->check_no;
            $payment->amount =$request->amount;
            $payment->note =$request->note;
            $payment->type ='Credit';
            $payment->payment_ref_no =$request->payment_ref_no;
            $payment->created_by =auth()->user()->id;
            $payment->save();
             if ($request->account_id) {
                $account = Account::find($request->account_id);
                $acc_transaction = new AccountTransaction;
                $acc_transaction->account_id = $request->account_id;
                $acc_transaction->transaction_id = $transaction->id;
                $acc_transaction->transaction_payment_id = $payment->id;
                $acc_transaction->type = check_debit_credit($request->account_id, 'to');
                $acc_transaction->sub_type = 'Sale';
                $acc_transaction->amount = $request->amount;
                $acc_transaction->reff_no = $transaction->reference_no;
                $acc_transaction->operation_date = $request->payment_date;
                $acc_transaction->note = 'Sale Paid To Customer Account';
                $acc_transaction->save();

                $acc_transaction1 = new AccountTransaction;
                $acc_transaction1->account_id = $customer_account_id;
                $acc_transaction1->transaction_id = $transaction->id;
                $acc_transaction1->transaction_payment_id = $payment->id;
                $acc_transaction1->type = 'Credit';
                $acc_transaction1->sub_type = 'Purchase';
                $acc_transaction1->amount = $request->amount;
                $acc_transaction1->reff_no = $transaction->reference_no;
                $acc_transaction1->operation_date = $request->payment_date;
                $acc_transaction1->note = 'Sale Paid From ' . $account->name;
                $acc_transaction1->save();

             }

            $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->net_total);
            return response()->json(['success' => true, 'status' => 'success', 'message' => 'Payment Successfully.', 'window' => route('admin.sale_voucher.sale.printpayment',$payment->id)]);
    }

            /**
     * Adds Payments for Contact due
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaySupplierDue(Request  $request)
    {

           $validator = $request->validate([
            'payment_date'=>'required',
            'amount'=>'required|numeric',
           ]);
            $supplier_id = $request->input('supplier_id');
            $inputs = $request->only(['amount', 'method', 'note','payment_date','transaction_no']);
            $inputs['created_by'] = auth()->user()->id;
            $inputs['supplier_id'] = $supplier_id;
            $inputs['type'] = 'Debit';
            $due_payment_type = $request->input('due_payment_type');


            if (!empty($request->input('account_id'))) {
                $inputs['account_id'] = $request->input('account_id');
            }

             if ($request->amount>$request->hidden_amount) {
             throw ValidationException::withMessages(['message' => __('Pay Amount Not> Total Total')]);
             }


            DB::beginTransaction();

            $parent_payment = TransactionPayment::create($inputs);

            $inputs['transaction_type'] = $due_payment_type;


            //Distribute above payment among unpaid transactions

            $this->transactionUtil->SupplierPayAtOnce($parent_payment, $due_payment_type);

            DB::commit();

        return response()->json(['success' => true, 'status' => 'success', 'message' => 'Payment Successfully.']);
    }



    public function postPayCustomerDue(Request  $request)
    {

           $validator = $request->validate([
            'payment_date'=>'required',
            'amount'=>'required|numeric',
           ]);
            $customer_id = $request->input('customer_id');
            $inputs = $request->only(['amount', 'method', 'note','payment_date','transaction_no']);
            $inputs['created_by'] = auth()->user()->id;
            $inputs['customer_id'] = $customer_id;
            $inputs['type'] = 'Credit';
            $due_payment_type = $request->input('due_payment_type');


            if (!empty($request->input('account_id'))) {
                $inputs['account_id'] = $request->input('account_id');
            }

             if ($request->amount>$request->hidden_amount) {
             throw ValidationException::withMessages(['message' => __('Pay Amount Not> Total Total')]);
             }


            DB::beginTransaction();

            $parent_payment = TransactionPayment::create($inputs);

            $inputs['transaction_type'] = $due_payment_type;


            //Distribute above payment among unpaid transactions

            $this->transactionUtil->CustomerPayAtOnce($parent_payment, $due_payment_type);

            DB::commit();

        return response()->json(['success' => true, 'status' => 'success', 'message' => 'Payment Successfully.']);
    }

    public function getSupplierPayment($id)
    {
        if (request()->ajax()) {
            $query = TransactionPayment::leftjoin('transactions as t', 'transaction_payments.transaction_id', '=', 't.id')
                // ->where('t.type', 'opening_balance')
                ->where('t.supplier_id', $id)
                ->select(
                    'transaction_payments.amount',
                    'method',
                    'payment_date',
                    'transaction_payments.payment_ref_no',
                    'transaction_payments.id',
                    't.transaction_type',
                    't.return_parent_id as parent'
                )
                ->groupBy('transaction_payments.id');
            return Datatables::of($query)
                ->editColumn('amount', function ($row) {
                    return '<span class="display_currency paid-amount" data-orig-value="' . $row->amount . '" data-currency_symbol = true>' . $row->amount . '</span>';
                })
                ->editColumn('action', function ($model) {
                    return view('admin.supplier.show_action',compact('model'));
                })
                ->rawColumns(['amount', 'method', 'action'])
                ->make(true);
        }
    }


    public function getCustomerPayment($id)
    {
        if (request()->ajax()) {
            $query = TransactionPayment::leftjoin('transactions as t', 'transaction_payments.transaction_id', '=', 't.id')
                // ->where('t.type', 'opening_balance')
                ->where('t.customer_id', $id)
                ->select(
                    'transaction_payments.amount',
                    'method',
                    'payment_date',
                    'transaction_payments.payment_ref_no',
                    'transaction_payments.id',
                    't.transaction_type',
                    't.return_parent_id as parent'
                )
                ->groupBy('transaction_payments.id');
            return Datatables::of($query)
                ->editColumn('amount', function ($row) {
                    return '<span class="display_currency paid-amount" data-orig-value="' . $row->amount . '" data-currency_symbol = true>' . $row->amount . '</span>';
                })
                ->editColumn('action', function ($model) {
                    return view('admin.customer.show_action',compact('model'));
                })
                ->rawColumns(['amount', 'method', 'action'])
                ->make(true);
        }
    }

    public function customer_opening_payment_print($id)
    {
        $model =TransactionPayment::find($id);
        $payment_type ='Customer Opening Balance';
        return view('admin.payment_account.paymentPrint',compact('model','payment_type'));
    }

    public function supplier_opening_payment_print($id)
    {
        $model =TransactionPayment::find($id);
        $payment_type ='Supplier Opening Balance';
        return view('admin.payment_account.paymentPrint',compact('model','payment_type'));
    }
}
