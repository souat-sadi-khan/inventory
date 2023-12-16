<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Account;
use App\Models\Admin\AccountTransaction;
use App\Models\Customer;
use App\Models\Products\Product;
use App\Transaction;
use App\TransactionPayment;
use App\TransactionSellLine;
use App\User;
use App\Utilities\TransactionUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class SaleController extends Controller
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

    public function index(Request $request)
    {
        authorize(['sale.create', 'sale.view']);
        if ($request->ajax()) {
            $q = Transaction::query();
            if (!empty(request()->input('sale_type'))) {
                $q = $q->where('sale_type', request()->input('sale_type'));
            }

            if (!empty(request()->input('customer_id'))) {
                $q = $q->where('customer_id', request()->input('customer_id'));
            }

            if (!empty(request()->input('payment_status'))) {
                $q = $q->where('payment_status', request()->input('payment_status'));
            }

            if (!empty(request()->input('sale_type'))) {
                $q = $q->where('sale_type', request()->input('sale_type'));
            }

            if (!empty(request()->input('created_by'))) {
                $q = $q->where('created_by', request()->input('created_by'));
            }

            $q = $q->where('transaction_type', 'Sale');
            $document = $q->get();

            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('date', function ($model) {
                    $return = '';
                    if ($model->return_parent) {
                        $return = '<span class="badge badge-info"><i class="fa fa-reply-all" aria-hidden="true"></i></span>';
                    }
                    return formatDate($model->date) . $return;
                })
                ->editColumn('customer', function ($model) {
                    return $model->customer ? $model->customer->customer_name : '';
                })
                ->editColumn('paid', function ($model) {
                    return $model->payment()->sum('amount') . get_option('currency_symbol');
                })
                ->editColumn('reference_no', function ($model) {
                    return '<a title="view Details" data-url="' . route('admin.sale_voucher.sale.show', $model->id) . '" id="btn_modal" style="cursor:pointer;color:#12f">' . $model->reference_no . '</a>';
                })
                ->editColumn('due', function ($model) {
                    return $model->net_total - ($model->payment()->sum('amount')) . get_option('currency_symbol');
                })
                ->editColumn('return', function ($model) {
                    $return = "";
                    if ($model->return_parent) {
                        $return = '<a href="#" data-url="' . route('admin.sale_voucher.return.show', $model->return_parent->return_parent_id) . '" id="btn_modal">' . ($model->net_total - ($model->payment()->sum('amount') + $model->return_parent->net_total)) . '</a>';
                    }
                    return $return;
                })
                ->editColumn('payment_status', function ($model) {
                    if ($model->payment_status == 'paid') {
                        return '<a title="view Payment" data-url="' . route('admin.sale_voucher.sale_payment', $model->id) . '" id="btn_modal" style="cursor:pointer;color:#12f"><span class="badge badge-success">Paid</span></a>';
                    } elseif ($model->payment_status == 'partial') {
                        return '<a title="view Payment" data-url="' . route('admin.sale_voucher.sale_payment', $model->id) . '" id="btn_modal" style="cursor:pointer;color:#12f"><span class="badge badge-success">Partial</span></a>';
                    } else {
                        return '<a title="view Payment" data-url="' . route('admin.sale_voucher.sale_payment', $model->id) . '" id="btn_modal" style="cursor:pointer;color:#12f"><span class="badge badge-success">Due</span></a>';
                    }
                })
                ->addColumn('action', function ($model) {
                    return view('admin.sale.action', compact('model'));
                })->rawColumns(['action', 'customer', 'date', 'paid', 'due', 'payment_status', 'reference_no', 'return'])->make(true);
        }
        $customers = Customer::orderBy('id', 'DESC')->get();
        $user = User::orderBy('id', 'DESC')->get();
        return view('admin.sale.index', compact('customers', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        authorize(['sale.create']);
        $customers = Customer::orderBy('id', 'desc')->get();
        $products = Product::orderBy('id', 'desc')->get();
        $sale_type = request()->sale_type;
        $accounts = Account::all();
        return view('admin.sale.create', compact('customers', 'products', 'sale_type', 'accounts'));
    }

    public function product(Request $request)
    {
        $product = Product::find($request->product);
        return response()->json($product);
    }

    public function product_row(Request $request)
    {
        $product = $request->product;
        $quantity = $request->quantity;
        $product_price = $request->product_price;
        $product_cost_price = $request->product_cost_price;
        $row = $request->row;
        $model = Product::find($product);
        return view('admin.sale.partial.itemlist', compact('model', 'quantity', 'product_price', 'row', 'product_cost_price'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        authorize(['sale.create'], true);
        $request->validate([
            'customer_id' => 'required',
            'date' => 'required'
        ]);


        $customer = Account::where('customer_id', $request->input('customer_id'))->first();
        $customer_account_id = $customer->id;

        $input = $request->except('_token', 'variation');

        if (empty($request->input('date'))) {
            $input['date'] = date('Y-m-d');
        } else {
            $input['date'] = $request->input('date');
        }

        if (empty($request->input('customer_id'))) {
            $input['customer_id'] = 1;
        } else {
            $input['customer_id'] = $request->input('customer_id');
        }

        $input['transaction_type'] = 'Sale';
        $input['type'] = 'Credit';
        $input['sale_type'] = $request->sale_type;
        if ($request->sale_type !== 'retail' && $request->sale_type !== 'wholesale') {
            throw ValidationException::withMessages(['message' => 'URL Mismatch Only Retail & WholeSale Accept']);
        }
        $user_id = auth()->user()->id;
        $ref_no = $this->transactionUtil->setReference('Sale');

        if ($request->invoice_no) {
            $invoice_no = $request->invoice_no;
        } else {
            $invoice_no = $ref_no;
        }

        $variations = $request->variation;
        if (isset($variations)) {
            $transaction = $this->transactionUtil->createSellPurcahaseTransaction($input, $user_id, $ref_no, $invoice_no);
            $purchase_line = $this->transactionUtil->createSellLines($transaction, $variations);

            foreach ($variations as $value) {
                $decrease_qty = $value['quantity'];
                $this->transactionUtil->decreaseProductQuantity(
                    $value['product_id'],
                    $decrease_qty
                );
            }

            if (!empty($input['paid'])) {
                $payment = new TransactionPayment;
                $payment->transaction_id = $transaction->id;
                $payment->customer_id = $transaction->customer_id;
                $payment->account_id = $request->account_id;
                $payment->method = $request->method;
                $payment->payment_date = $input['date'];
                $payment->transaction_no = $input['check_no'];
                $payment->amount = $request->paid;
                $payment->note = $request->transaction_note;
                $payment->type = 'Credit';
                $payment->payment_ref_no = $transaction->reference_no;
                $payment->created_by = $user_id;
                $payment->save();

                if ($request->account_id) {
                    $account = Account::find($request->account_id);
                    $acc_transaction = new AccountTransaction;
                    $acc_transaction->account_id = $request->account_id;
                    $acc_transaction->transaction_id = $transaction->id;
                    $acc_transaction->transaction_payment_id = $payment->id;
                    $acc_transaction->type = check_debit_credit($request->account_id,'to');
                    $acc_transaction->sub_type = 'Sale';
                    $acc_transaction->amount = $request->paid;
                    $acc_transaction->reff_no = $transaction->reference_no;
                    $acc_transaction->operation_date = $input['date'];
                    $acc_transaction->note = 'Sale Paid To Customer Account';
                    $acc_transaction->save();

                }
            }

            $acc_transaction1 = new AccountTransaction;
            $acc_transaction1->account_id = $customer_account_id;
            $acc_transaction1->transaction_id = $transaction->id;
            $acc_transaction1->type = 'Debit';
            $acc_transaction1->sub_type = 'Sale';
            $acc_transaction1->amount = $request->due;
            $acc_transaction1->reff_no = $transaction->reference_no;
            $acc_transaction1->operation_date = $input['date'];
            $acc_transaction1->note = 'Sale Due From '.$transaction->reference_no;
            $acc_transaction1->save();

            $account = Account::find($request->account_id);
            $acc_transaction1 = new AccountTransaction;
            $acc_transaction1->account_id = Account::where('name', 'Product')->first()->id;
            $acc_transaction1->transaction_id = $transaction->id;
            $acc_transaction1->type = 'Credit';
            $acc_transaction1->sub_type = 'Sale';
            $acc_transaction1->amount = $request->purchase_value_sub_total;
            $acc_transaction1->reff_no = $transaction->reference_no;
            $acc_transaction1->operation_date = $input['date'];
            $acc_transaction1->note = 'Sale Product From ' . $transaction->reference_no;
            $acc_transaction1->save();

            $acc_transaction2 = new AccountTransaction;
            $acc_transaction2->account_id = Account::where('name', 'Product Sale Income')->first()->id;
            $acc_transaction2->transaction_id = $transaction->id;
            $acc_transaction2->type = 'Credit';
            $acc_transaction2->sub_type = 'Sale';
            $acc_transaction2->amount = $request->sub_total - $request->purchase_value_sub_total;
            $acc_transaction2->reff_no = $transaction->reference_no;
            $acc_transaction2->operation_date = $input['date'];
            $acc_transaction2->note = 'Sale Product From ' . $transaction->reference_no;
            $acc_transaction2->save();

            if($transaction->discount_amount){
                $acc_transaction3 = new AccountTransaction;
                $acc_transaction3->account_id = Account::where('name', 'Product Sale Discount')->first()->id;
                $acc_transaction3->transaction_id = $transaction->id;
                $acc_transaction3->type = 'Credit';
                $acc_transaction3->sub_type = 'Sale';
                $acc_transaction3->amount = $transaction->discount_amount;
                $acc_transaction3->reff_no = $transaction->reference_no;
                $acc_transaction3->operation_date = $input['date'];
                $acc_transaction3->note = 'Sale Product From ' . $transaction->reference_no;
                $acc_transaction3->save();
            }

            if($transaction->tax){
                $acc_transaction4 = new AccountTransaction;
                $acc_transaction4->account_id = Account::where('name', 'Sale Tax')->first()->id;
                $acc_transaction4->transaction_id = $transaction->id;
                $acc_transaction4->type = 'Credit';
                $acc_transaction4->sub_type = 'Sale';
                $acc_transaction4->amount = ($transaction->sub_total - $transaction->discount_amount) * ($transaction->tax / 100);
                $acc_transaction4->reff_no = $transaction->reference_no;
                $acc_transaction4->operation_date = $input['date'];
                $acc_transaction4->note = 'Sale Tax From ' . $transaction->reference_no;
                $acc_transaction4->save();
            }

            if($transaction->shipping_charges){
                $acc_transaction5 = new AccountTransaction;
                $acc_transaction5->account_id = Account::where('name', 'Sale Shipping Charge')->first()->id;
                $acc_transaction5->transaction_id = $transaction->id;
                $acc_transaction5->type = 'Credit';
                $acc_transaction5->sub_type = 'Sale';
                $acc_transaction5->amount = $transaction->shipping_charges;
                $acc_transaction5->reff_no = $transaction->reference_no;
                $acc_transaction5->operation_date = $input['date'];
                $acc_transaction5->note = 'Sale Shipping Charge From ' . $transaction->reference_no;
                $acc_transaction5->save();
            }


            //Update payment status
            $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->net_total);

            return response()->json(['success' => true, 'status' => 'success', 'message' => 'Information Updated', 'goto' => route('admin.sale_voucher.view', $transaction->id)]);

        } else {
            throw ValidationException::withMessages(['message' => 'Please Select atlest one item to Sale']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Transaction::find($id);
        return view('admin.sale.partial.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        authorize(['sale.delete'], true);
        if (request()->ajax()) {
            //Check if return exist then not allowed
            if ($this->transactionUtil->isReturnExist($id)) {
                throw ValidationException::withMessages(['message' => __('This Transaction has return Item')]);
            }

            $transaction = Transaction::where('id', $id)
                ->with(['sell_lines'])
                ->first();

            $delete_sale_lines = $transaction->sell_lines;
            DB::beginTransaction();

            $transaction_status = $transaction->status;

            //Delete sell_lines lines first
            $delete_sale_line_ids = [];
            foreach ($delete_sale_lines as $purchase_line) {
                $delete_sale_line_ids[] = $purchase_line->id;
            }

            TransactionSellLine::where('transaction_id', $transaction->id)
                ->whereIn('id', $delete_sale_line_ids)
                ->delete();

            //Delete Transaction
            $transaction->payment()->delete();
            $transaction->delete();

            //Delete account transactions
            AccountTransaction::where('transaction_id', $id)->delete();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Data is deleted successfully']);
        }
    }

    public function view($id)
    {
        authorize(['sale.view']);
        $model = Transaction::find($id);
        return view('admin.sale.partial.view', compact('model'));
    }

    public function payment(Request $request, $id)
    {
        if (request()->ajax()) {
            $transaction = Transaction::where('id', $id)
                ->with(['customer'])
                ->first();
            $payments_query = TransactionPayment::where('transaction_id', $id);

            // $accounts_enabled = false;
            // if ($this->moduleUtil->isModuleEnabled('account')) {
            //     $accounts_enabled = true;
            //     $payments_query->with(['payment_account']);
            // }

            $payments = $payments_query->get();
            $accounts =  Account::where('status', 'Active')->get();

            return view('admin.sale.partial.show_payments')
                ->with(compact('transaction', 'payments', 'accounts'));
        }
    }


    public function printpayment($id)
    {
        $model = TransactionPayment::find($id);
        $payment_type = 'Sale Payment Voucher';
        return view('admin.payment_account.paymentPrint', compact('model', 'payment_type'));
    }

}
