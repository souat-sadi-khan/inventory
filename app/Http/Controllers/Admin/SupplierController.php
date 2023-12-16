<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Account;
use App\Models\Supplier;
use App\Transaction;
use App\TransactionPayment;
use App\Utilities\TransactionUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
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
        authorize(['supplier.view', 'supplier.create']);
        return view('admin.supplier.index');
    }

    public function datatable() {
        if (request()->ajax()) {
            $ips = Supplier::leftjoin('transactions AS t', 'suppliers.id', '=', 't.supplier_id')
                    ->select(['suppliers.id','suppliers.sup_name','suppliers.sup_mobile','suppliers.status',
                        DB::raw("SUM(IF(t.transaction_type = 'Purchase', net_total, 0)) as total_purchase"),
                        DB::raw("SUM(IF(t.transaction_type = 'Purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_paid"),
                        DB::raw("SUM(IF(t.transaction_type = 'purchase_return', net_total, 0)) as total_purchase_return"),
                        DB::raw("SUM(IF(t.transaction_type = 'purchase_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_return_paid"),
                        DB::raw("SUM(IF(t.transaction_type = 'sup_opening', net_total, 0)) as opening_balance"),
                        DB::raw("SUM(IF(t.transaction_type = 'sup_opening', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid")
                        ])
                    ->groupBy('suppliers.id');

			return DataTables::of($ips)
                ->addIndexColumn()
                ->editColumn('due', function($model){
                    return $model->total_purchase - $model->purchase_paid;
                })
                ->editColumn('return_due', function($model){
                    return $model->total_purchase_return - $model->purchase_return_paid;
                })
                ->editColumn('status', function($model){
                    if($model->status == 1) {
                        return '<span class="badge badge-primary">Active</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($model) {
					return view('admin.supplier.action', compact('model'));
				})
				->rawColumns(['due', 'return_due', 'status', 'action'])->make(true);
		}
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        authorize(['supplier.create']);
        $request->validate([
            'sup_name' => 'required',
            'code_name' => 'required',
            'sup_mobile' => 'required',
            'net_total' => 'nullable|numeric',
            'status' => 'required',
        ]);

        $model = new Supplier;
        $model->sup_name = $request->sup_name;
        $model->code_name = $request->code_name;
        $model->sup_mobile = $request->sup_mobile;
        $model->sup_email = $request->sup_email;
        $model->sup_address = $request->sup_address;
        $model->sup_city = $request->sup_city;
        $model->sup_state = $request->sup_state;
        $model->sup_country = $request->sup_country;
        $model->status = $request->status;
        $model->save();

        // Add Account TAble
        $model1 = new Account();
        $model1->category = 'Supplier';
        $model1->name = $request->sup_name;
        $model1->phone = $request->sup_mobile;
        $model1->email = $request->sup_email;
        $model1->address = $request->sup_address;
        $model1->supplier_id = $model->id;
        $model1->status = 'Active';
        $model1->save();

        $customer =null;
        $supplier =$model->id;
        $type ='Debit';
        $trans_type ='sup_opening';
         //Add opening balance
        if (!empty($request->input('net_total'))) {
                    $this->transactionUtil->createOpeningBalanceTransaction($customer,$supplier, $request->input('net_total'),$type,$trans_type);
            }

        \SadikLog::addToLog('Created a Suppler - ' . $request->sup_name .'.');

        return response()->json(['status' => 'success', 'message' => 'New Supplier is stored successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        authorize(['supplier.view']);
             $model = Supplier::where('suppliers.id', $id)
                            ->join('transactions AS t', 'suppliers.id', '=', 't.supplier_id')
                            ->select(
                                DB::raw("SUM(IF(t.transaction_type = 'Purchase', net_total, 0)) as total_purchase"),
                                DB::raw("SUM(IF(t.transaction_type = 'purchase_return', net_total, 0)) as purchase_return"),
                                DB::raw("SUM(IF(t.transaction_type = 'Purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_paid"),
                                DB::raw("SUM(IF(t.transaction_type = 'purchase_return', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as return_paid"),
                                DB::raw("SUM(IF(t.transaction_type = 'sup_opening', net_total, 0)) as opening_balance"),
                                DB::raw("SUM(IF(t.transaction_type = 'sup_opening', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid"),
                                'suppliers.*'
                            )->first();
        return view('admin.supplier.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        authorize(['supplier.create']);
        $model = Supplier::findOrFail($id);
            $ob_transaction =  Transaction::where('supplier_id', $id)
                                            ->where('transaction_type', 'sup_opening')
                                            ->first();
            $opening_balance = !empty($ob_transaction->net_total) ? $ob_transaction->net_total : 0;

            //Deduct paid amount from opening balance.
            if (!empty($opening_balance)) {
                $opening_balance_paid = $this->transactionUtil->getTotalAmountPaid($ob_transaction->id);
                if (!empty($opening_balance_paid)) {
                    $opening_balance = $opening_balance - $opening_balance_paid;
                }

            }
        return view('admin.supplier.edit', compact('model','opening_balance'));
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
        authorize(['supplier.create'], true);
        $request->validate([
            'sup_name' => 'required',
            'code_name' => 'required',
            'sup_mobile' => 'required',
            'status' => 'required',
            'net_total' => 'nullable|numeric',
        ]);

        $model = Supplier::findOrFail($id);
        $model->sup_name = $request->sup_name;
        $model->code_name = $request->code_name;
        $model->sup_mobile = $request->sup_mobile;
        $model->sup_email = $request->sup_email;
        $model->sup_address = $request->sup_address;
        $model->sup_city = $request->sup_city;
        $model->sup_state = $request->sup_state;
        $model->sup_country = $request->sup_country;
        $model->status = $request->status;
        $model->save();

        // Edit Account TAble
        $model1 = Account::where('supplier_id',$id)->first();
        $model1->name = $request->sup_name;
        $model1->phone = $request->sup_mobile;
        $model1->email = $request->sup_email;
        $model1->address = $request->sup_address;
        $model1->save();

        $ob_transaction =  Transaction::where('supplier_id', $id)
                                        ->where('transaction_type', 'sup_opening')
                                        ->first();

      if (!empty($ob_transaction)) {
                $amount =$request->input('net_total');
                $opening_balance_paid = $this->transactionUtil->getTotalAmountPaid($ob_transaction->id);
                if (!empty($opening_balance_paid)) {
                    $amount += $opening_balance_paid;
                }

                $ob_transaction->net_total = $amount;
                $ob_transaction->due = $amount;
                $ob_transaction->save();
                 $this->transactionUtil->updatePaymentStatus($ob_transaction->id, $ob_transaction->net_total);
                //Update opening balance payment status
                $this->transactionUtil->updatePaymentStatus($ob_transaction->id, $ob_transaction->net_total);
            } else {
                //Add opening balance
                if (!empty($request->input('net_total'))) {
                   $customer =null;
                   $supplier =$model->id;
                   $type ='Debit';
                   $trans_type ='sup_opening';
                    $this->transactionUtil->createOpeningBalanceTransaction($customer,$supplier, $request->input('net_total'),$type,$trans_type);

                }
            }

        \SadikLog::addToLog('Created a Suppler - ' . $request->sup_name .'.');

        return response()->json(['status' => 'success', 'message' => 'New Supplier is Update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        authorize(['supplier.delete'], true);
          $count = Transaction::where('supplier_id', $id)->count();
          if ($count == 0) {
                    $model = Supplier::findOrFail($id);
                        \SadikLog::addToLog('Deleted a Supplier - '. $model->sup_name);
                    $model->delete();
                       return response()->json(['status' => 'success', 'message' => 'Supplier is deleted successfully']);
                } else {
                    throw ValidationException::withMessages(['message' =>'Supplier Can not Deleted Because Transaction Exit This Supplier']);
        }
    }


      /**
     * Shows contact's payment due modal
     *
     * @param  int  $supplier_id
     * @return \Illuminate\Http\Response
     */
    public function make_payment($supplier_id)
    {

        if (request()->ajax()) {

            $due_payment_type = request()->input('type');
            $query = Supplier::where('suppliers.id', $supplier_id)
                            ->join('transactions AS t', 'suppliers.id', '=', 't.supplier_id');
            if ($due_payment_type == 'Purchase') {
                $query->select(
                        DB::raw("SUM(IF(t.transaction_type = 'Purchase', net_total, 0)) as total_purchase"),
                        DB::raw("SUM(IF(t.transaction_type = 'Purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_paid"),
                        'suppliers.sup_name',
                        'suppliers.id as supplier_id'
                    );
            } elseif ($due_payment_type == 'purchase_return') {
                $query->select(
                        DB::raw("SUM(IF(t.transaction_type = 'purchase_return', net_total, 0)) as total_purchase_return"),
                        DB::raw("SUM(IF(t.transaction_type = 'purchase_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_return_paid"),
                        'suppliers.sup_name',
                        'suppliers.id as supplier_id'
                    );
            }

            //Query for opening balance details
            $query->addSelect(
                DB::raw("SUM(IF(t.transaction_type = 'sup_opening', net_total, 0)) as opening_balance"),
                DB::raw("SUM(IF(t.transaction_type = 'sup_opening', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid")
            );
            $contact_details = $query->first();

            $payment_line = new TransactionPayment();
            if ($due_payment_type == 'Purchase') {
                $contact_details->total_purchase = empty($contact_details->total_purchase) ? 0 : $contact_details->total_purchase;
                $payment_line->amount = $contact_details->total_purchase -
                                    $contact_details->total_paid;
            } elseif ($due_payment_type == 'purchase_return') {
                $payment_line->amount = $contact_details->total_purchase_return -
                                    $contact_details->total_return_paid;
            }

            //If opening balance due exists add to payment amount
            $contact_details->opening_balance = !empty($contact_details->opening_balance) ? $contact_details->opening_balance : 0;
            $contact_details->opening_balance_paid = !empty($contact_details->opening_balance_paid) ? $contact_details->opening_balance_paid : 0;
            $ob_due = $contact_details->opening_balance - $contact_details->opening_balance_paid;
            if ($ob_due > 0) {
                $payment_line->amount += $ob_due;
            }

            $amount_formated = $payment_line->amount;

            $contact_details->total_paid = empty($contact_details->total_paid) ? 0 : $contact_details->total_paid;

            $payment_line->method = 'cash';
            $payment_line->payment_date = Carbon::now()->toDateString();

            if ($payment_line->amount > 0) {
                return view('admin.supplier.pay_due_modal')
                        ->with(compact('contact_details', 'payment_line', 'due_payment_type', 'ob_due', 'amount_formated'));
            }
        }
    }


}
