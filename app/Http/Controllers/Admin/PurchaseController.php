<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Account;
use App\Models\Admin\AccountTransaction;
use App\Models\Products\Product;
use App\Models\Supplier;
use App\Purchase;
use App\Transaction;
use App\TransactionPayment;
use App\User;
use App\Utilities\TransactionUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class PurchaseController extends Controller
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
        authorize(['purchase.view', 'purchase.create']);
        if ($request->ajax()) {
            $q=Transaction::query();

            if (!empty(request()->input('supplier_id'))) {
                $q=$q->where('supplier_id',request()->input('supplier_id'));
            }

            if (!empty(request()->input('payment_status'))) {
                $q=$q->where('payment_status',request()->input('payment_status'));
            }

            if (!empty(request()->input('created_by'))) {
                $q=$q->where('created_by',request()->input('created_by'));
            }

            $q =$q->where('transaction_type','Purchase');
            $document =$q->get();

            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn('date', function ($model) {
                   $return ='';
                    if ($model->return_parent) {
                        $return='<span class="badge badge-info"><i class="fa fa-reply-all" aria-hidden="true"></i></span>';
                    }
                  return formatDate($model->date).$return;
                 })
                 ->editColumn('supplier', function ($model) {
                  return $model->supplier?$model->supplier->sup_name:'';
                 })
                 ->editColumn('paid', function ($model) {
                    return $model->payment->sum('amount') . get_option('currency_symbol') ;
                 })
                ->editColumn('due', function ($model) {
                    return $model->net_total-($model->payment()->sum('amount')) . get_option('currency_symbol') ;

                 })
                ->editColumn('return', function ($model) {
                    $return="";
                    if ($model->return_parent) {
                    $return = '<a href="#" data-url="' . route('admin.pur_voucher.return.show', $model->return_parent->return_parent_id) . '" id="btn_modal">' . ($model->net_total-($model->payment()->sum('amount')+$model->return_parent->net_total)). '</a>';
                    }
                    return $return;

                 })
                 ->editColumn('net_total', function ($model) {
                    return $model->net_total. get_option('currency_symbol') ;

                 })
                ->editColumn('reference_no', function ($model) {
                  return '<a title="view Details" data-url="'.route('admin.pur_voucher.purchase.show',$model->id).'" id="btn_modal" style="cursor:pointer;color:#12f">'.$model->reference_no.'</a>';
                 })
                 ->editColumn('payment_status', function ($model) {
                   if ($model->payment_status=='paid') {
                     return '<a title="view Payment" data-url="'.route('admin.pur_voucher.purchase_payment',$model->id).'" id="btn_modal" style="cursor:pointer;color:#12f"><span class="badge badge-success">Paid</span></a>';
                   }
                   elseif($model->payment_status=='partial'){
                      return '<a title="view Payment" data-url="'.route('admin.pur_voucher.purchase_payment',$model->id).'" id="btn_modal" style="cursor:pointer;color:#12f"><span class="badge badge-success">Partial</span></a>';
                   }
                   else{
                     return '<a title="view Payment" data-url="'.route('admin.pur_voucher.purchase_payment',$model->id).'" id="btn_modal" style="cursor:pointer;color:#12f"><span class="badge badge-success">Due</span></a>';
                   }
                 })
                ->addColumn('action', function ($model) {
                    return view('admin.purchase.action', compact('model'));
                })->rawColumns(['action','supplier','date','paid','due','payment_status','reference_no','return'])->make(true);
        }
        $suppliers =Supplier::orderBy('id','DESC')->select('sup_name','id')->get();
        $user =User::orderBy('id','DESC')->select('email','id')->get();
       return view('admin.purchase.index',compact('suppliers','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        authorize(['purchase.create']);
        $suppliers = Supplier::orderBy('id','desc')->get();
        $products =Product::orderBy('id','desc')->get();
        $accounts =Account::all();
        $supplier=request()->input('supplier')?request()->input('supplier'):'';
        return view('admin.purchase.create',compact('suppliers','products','supplier','accounts'));
    }

    public function product(Request $request)
    {
        $product =Product::find($request->product);
        return response()->json($product);
    }

    public function product_row(Request $request)
    {
        if(!intval($request->quantity)) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' =>'Quantity is must be the Numeric Number']);

        }
        $product = $request->product;
        $quantity = $request->quantity;
        $product_cost = $request->product_cost;
        $product_price = $request->product_price;
        $row = $request->row;
        $model = Product::find($product);
        return view('admin.purchase.partial.itemlist', compact('model', 'quantity', 'product_cost','product_price','row'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        authorize(['purchase.create']);
        $request->validate([
                'supplier_id' => 'required',
                'date' => 'required'
            ]);
        $supplier = Account::where('supplier_id', $request->input('supplier_id'))->first();
        $supplier_account_id = $supplier->id;

        $input = $request->except('_token','variation');

         if (empty($request->input('date'))) {
                    $input['date'] =  date('Y-m-d');
                } else {
                    $input['date'] =$request->input('date');
         }

        if (empty($request->input('supplier_id'))) {
                    $input['supplier_id'] = 1;
                } else {
                    $input['supplier_id'] =$request->input('supplier_id');
         }

        $input['transaction_type']='Purchase';
        $input['type']='Debit';
        $user_id =auth()->user()->id;

        $ym = Carbon::now()->format('Y/m');

        $row = Transaction::where('transaction_type', 'Purchase')->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', 'Purchase')->withTrashed()->get()->count() + 1 : 1;

        $ref_no = $ym.'/P-'.ref($row);

        if($request->invoice_no){
            $invoice_no = $request->invoice_no;
        }else{
            $invoice_no = $ref_no;
        }

        $variations =$request->variation;
        if (isset($variations)) {
        $transaction = $this->transactionUtil->createSellPurcahaseTransaction($input,$user_id,$ref_no,$invoice_no);
        $purchase_line =$this->transactionUtil->createPurchaseLines($transaction,$variations);


        foreach ($variations as $value) {
            $decrease_qty = $value['qty'];
             $this->transactionUtil->IncreaseVariationQty(
                                $value['product_id'],
                                $decrease_qty
                            );
        }

        if (!empty($input['paid'])) {
            $payment =new TransactionPayment;
            $payment->transaction_id=$transaction->id;
            $payment->account_id=$request->account_id;
            $payment->supplier_id=$transaction->supplier_id;
            $payment->method =$request->method;
            $payment->payment_date =$input['date'];
            $payment->transaction_no =$input['check_no'];
            $payment->amount =$request->paid;
            $payment->note =$request->transaction_note;
            $payment->type ='Debit';
            $payment->payment_ref_no =$transaction->reference_no;
            $payment->created_by =$user_id;
            $payment->save();

             if ($request->account_id) {
               $acc_transaction =new AccountTransaction;
               $acc_transaction->account_id = $request->account_id;
               $acc_transaction->transaction_id =$transaction->id;
               $acc_transaction->transaction_payment_id =$payment->id;
               $acc_transaction->type = check_debit_credit($request->account_id);
               $acc_transaction->sub_type ='Purchase';
               $acc_transaction->amount =$request->paid;
               $acc_transaction->reff_no =$transaction->reference_no;
               $acc_transaction->operation_date =$input['date'];
               $acc_transaction->note ='Purchase Paid To Supplier Account';
               $acc_transaction->save();
            }
        }

            $account = Account::find($request->account_id);

            $acc_transaction1 = new AccountTransaction;
            $acc_transaction1->account_id = $supplier_account_id;
            $acc_transaction1->transaction_id = $transaction->id;
            $acc_transaction1->type = 'Debit';
            $acc_transaction1->sub_type = 'Purchase';
            $acc_transaction1->amount = $request->due;
            $acc_transaction1->reff_no = $transaction->reference_no;
            $acc_transaction1->operation_date = $input['date'];
            $acc_transaction1->note = 'Purchase Due From '.$transaction->reference_no;
            $acc_transaction1->save();



            $acc_transaction2 = new AccountTransaction;
            $acc_transaction2->account_id = Account::where('name', 'Product')->first()->id;
            $acc_transaction2->transaction_id = $transaction->id;
            $acc_transaction2->type = 'Debit';
            $acc_transaction2->sub_type = 'Purchase';
            $acc_transaction2->amount = $transaction->sub_total;
            $acc_transaction2->reff_no = $transaction->reference_no;
            $acc_transaction2->operation_date = $input['date'];
            $acc_transaction2->note = 'Purchase Product From ' . $transaction->reference_no;
            $acc_transaction2->save();

            if($transaction->discount_amount){
                $acc_transaction3 = new AccountTransaction;
                $acc_transaction3->account_id = Account::where('name', 'Product Purchase Discount')->first()->id;
                $acc_transaction3->transaction_id = $transaction->id;
                $acc_transaction3->type = 'Credit';
                $acc_transaction3->sub_type = 'Purchase';
                $acc_transaction3->amount = $transaction->discount_amount;
                $acc_transaction3->reff_no = $transaction->reference_no;
                $acc_transaction3->operation_date = $input['date'];
                $acc_transaction3->note = 'Purchase Discount From ' . $transaction->reference_no;
                $acc_transaction3->save();
            }

            if($transaction->tax){
                $acc_transaction4 = new AccountTransaction;
                $acc_transaction4->account_id = Account::where('name', 'Purchase Tax')->first()->id;
                $acc_transaction4->transaction_id = $transaction->id;
                $acc_transaction4->type = 'Debit';
                $acc_transaction4->sub_type = 'Purchase';
                $acc_transaction4->amount = ($transaction->sub_total - $transaction->discount_amount) * ($transaction->tax / 100);
                $acc_transaction4->reff_no = $transaction->reference_no;
                $acc_transaction4->operation_date = $input['date'];
                $acc_transaction4->note = 'Purchase Tax From ' . $transaction->reference_no;
                $acc_transaction4->save();
            }

            if($transaction->shipping_charges){
                $acc_transaction5 = new AccountTransaction;
                $acc_transaction5->account_id = Account::where('name', 'Sale Shipping Charge')->first()->id;
                $acc_transaction5->transaction_id = $transaction->id;
                $acc_transaction5->type = 'Debit';
                $acc_transaction5->sub_type = 'Purchase';
                $acc_transaction5->amount = $transaction->shipping_charges;
                $acc_transaction5->reff_no = $transaction->reference_no;
                $acc_transaction5->operation_date = $input['date'];
                $acc_transaction5->note = 'Purchase Shipping Charge From ' . $transaction->reference_no;
                $acc_transaction5->save();
            }


        //Update payment status
        $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->net_total);
        return response()->json(['success' => true, 'status' => 'success', 'message' =>'Information Updated','goto'=>route('admin.pur_voucher.view',$transaction->id)]);

    }

    else
    {
      throw ValidationException::withMessages(['message' =>'Please Select atlest one item to Purchase']);
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model =Transaction::find($id);
        return view('admin.purchase.partial.show',compact('model'));
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
        authorize(['purchase.create'], true);
         if (request()->ajax()) {
                //Check if return exist then not allowed
                if ($this->transactionUtil->isReturnExist($id)) {
                   throw ValidationException::withMessages(['message' => __('This Transaction has return Item')]);
                }

                $transaction = Transaction::where('id', $id)
                                ->with(['purchase'])
                                ->first();

                $delete_purchase_lines = $transaction->purchase;
                DB::beginTransaction();

                $transaction_status = $transaction->status;
                if ($transaction_status != 'received') {
                    $transaction->delete();
                } else {
                    //Delete purchase lines first
                    $delete_purchase_line_ids = [];
                    foreach ($delete_purchase_lines as $purchase_line) {
                        $delete_purchase_line_ids[] = $purchase_line->id;
                        $this->transactionUtil->decreaseProductQuantity(
                            $purchase_line->product_id,
                            $purchase_line->qty
                        );
                    }
                    Purchase::where('transaction_id', $transaction->id)
                                ->whereIn('id', $delete_purchase_line_ids)
                                ->delete();
                }

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
        authorize(['purchase.view']);
        $model =Transaction::find($id);
        return view('admin.purchase.partial.view',compact('model'));
    }

    public function payment(Request $request, $id)
    {
        if (request()->ajax()) {
            $transaction = Transaction::where('id', $id)
                                        ->with(['supplier'])
                                        ->first();
            $payments_query = TransactionPayment::where('transaction_id', $id);

            // $accounts_enabled = false;
            // if ($this->moduleUtil->isModuleEnabled('account')) {
            //     $accounts_enabled = true;
            //     $payments_query->with(['payment_account']);
            // }

            $payments = $payments_query->get();
            $accounts =  Account::where('status', 'Active')->get();


            return view('admin.purchase.partial.show_payments')
                    ->with(compact('transaction', 'payments','accounts'));
        }
    }

    public function printpayment($id)
    {
        $model =TransactionPayment::find($id);
        $payment_type ='Purchase Payment Voucher';
        return view('admin.payment_account.paymentPrint',compact('model','payment_type'));
    }
}
