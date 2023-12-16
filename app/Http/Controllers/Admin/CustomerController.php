<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Account;
use App\Models\Customer;
use App\Models\SadikLog;
use App\Transaction;
use App\TransactionPayment;
use App\Utilities\TransactionUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
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
        authorize(['customer.view', 'customer.create']);
        return view('admin.customer.index');
    }

    public function datatable() {
        if (request()->ajax()) {
              $ips = Customer::leftjoin('transactions AS t', 'customers.id', '=', 't.customer_id')
                    ->select(['customers.id','customers.customer_name','customers.customer_mobile','customers.status',
                        DB::raw("SUM(IF(t.transaction_type = 'Sale', net_total, 0)) as total_sale"),
                        DB::raw("SUM(IF(t.transaction_type = 'Sale', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as sale_paid"),
                        DB::raw("SUM(IF(t.transaction_type = 'sale_return', net_total, 0)) as total_sale_return"),
                        DB::raw("SUM(IF(t.transaction_type = 'sale_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as sale_return_paid"),
                        DB::raw("SUM(IF(t.transaction_type = 'cus_opening', net_total, 0)) as opening_balance"),
                        DB::raw("SUM(IF(t.transaction_type = 'cus_opening', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid")
                        ])
                    ->groupBy('customers.id');

            return DataTables::of($ips)
                ->addIndexColumn()
                ->editColumn('due', function($model){
                    return $model->total_sale - $model->sale_paid;
                })
                ->editColumn('return_due', function($model){
                    return $model->total_sale_return - $model->sale_return_paid;
                })
                ->editColumn('status', function($model){
                    if($model->status == 1) {
                        return '<span class="badge badge-primary">Active</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($model) {
                    return view('admin.customer.action', compact('model'));
                })
                ->rawColumns(['due', 'return_due', 'status', 'action'])->make(true);
		}
    }


    public function quick_add()
    {
        authorize(['customer.create']);
        return view('admin.customer.quick_add');
    }


    public function postquick_add(Request $request)
    {
        authorize(['customer.create']);
        $request->validate([
            'customer_name' => 'required',
            'status' => 'required',
            'customer_mobile' => 'required',
        ]);

        $model = new Customer;
        $model->uuid = Str::uuid();
        $model->customer_name = $request->customer_name;
        $model->customer_mobile = $request->customer_mobile;
        $model->date_of_birth = $request->date_of_birth;
        $model->customer_email = $request->customer_email;
        $model->customer_sex = $request->customer_sex;
        $model->customer_age = $request->customer_age;
        $model->gtin = $request->gtin;
        $model->customer_city = $request->customer_city;
        $model->customer_state = $request->customer_state;
        $model->customer_country = $request->customer_country;
        $model->status = $request->status;
        $model->save();

        // Add Account TAble
        $model1 = new Account;
        $model1->category = 'Customer';
        $model1->name = $request->customer_name;
        $model1->phone = $request->customer_mobile;
        $model1->email = $request->customer_email;
        $model1->address = $request->customer_city;
        $model1->customer_id = $model->id;
        $model1->status = 'Active';
        $model1->save();

        \SadikLog::addToLog('Created a Customer - ' . $request->customer_name .'.');

        return response()->json(['status' => 'success', 'id' => $model->id, 'text' => $model->customer_name, 'message' => 'New Customer is stored successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        authorize(['customer.create']);
        $request->validate([
            'customer_name' => 'required',
            'status' => 'required',
            'customer_mobile' => 'required',
            'net_total' => 'nullable|numeric',
        ]);

        $model = new Customer;
        $model->uuid = Str::uuid();
        $model->customer_name = $request->customer_name;
        $model->customer_mobile = $request->customer_mobile;
        $model->date_of_birth = $request->date_of_birth;
        $model->customer_email = $request->customer_email;
        $model->customer_sex = $request->customer_sex;
        $model->customer_age = $request->customer_age;
        $model->gtin = $request->gtin;
        $model->customer_city = $request->customer_city;
        $model->customer_state = $request->customer_state;
        $model->customer_country = $request->customer_country;
        $model->status = $request->status;
        $model->save();

        // Add Account TAble
        $model1 = new Account;
        $model1->category = 'Customer';
        $model1->name = $request->customer_name;
        $model1->phone = $request->customer_mobile;
        $model1->email = $request->customer_email;
        $model1->address = $request->customer_city;
        $model1->customer_id = $model->id;
        $model1->status = 'Active';
        $model1->save();

        $customer =$model->id;
        $supplier =null;
        $type ='Credit';
        $trans_type ='cus_opening';
         //Add opening balance
        if (!empty($request->input('net_total'))) {
                    $this->transactionUtil->createOpeningBalanceTransaction($customer,$supplier, $request->input('net_total'),$type,$trans_type);
            }

        \SadikLog::addToLog('Created a Customer - ' . $request->customer_name .'.');

        return response()->json(['status' => 'success', 'message' => 'New Customer is stored successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        authorize(['customer.view']);
        $model = Customer::where('customers.id', $id)
                ->join('transactions AS t', 'customers.id', '=', 't.customer_id')
                ->select(
                    DB::raw("SUM(IF(t.transaction_type = 'Sale', net_total, 0)) as total_sale"),
                    DB::raw("SUM(IF(t.transaction_type = 'sale_return', net_total, 0)) as sale_return"),
                    DB::raw("SUM(IF(t.transaction_type = 'Sale', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as sale_paid"),
                    DB::raw("SUM(IF(t.transaction_type = 'sale_return', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as return_paid"),
                    DB::raw("SUM(IF(t.transaction_type = 'cus_opening', net_total, 0)) as opening_balance"),
                    DB::raw("SUM(IF(t.transaction_type = 'cus_opening', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid"),
                    'customers.*'
                )->first();
        return view('admin.customer.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        authorize(['customer.create']);
        $model = Customer::findOrFail($id);
            $ob_transaction =  Transaction::where('customer_id', $id)
                                            ->where('transaction_type', 'opening_balance')
                                            ->first();
            $opening_balance = !empty($ob_transaction->net_total) ? $ob_transaction->net_total : 0;

            //Deduct paid amount from opening balance.
            if (!empty($opening_balance)) {
                $opening_balance_paid = $this->transactionUtil->getTotalAmountPaid($ob_transaction->id);
                if (!empty($opening_balance_paid)) {
                    $opening_balance = $opening_balance - $opening_balance_paid;
                }

            }
        return view('admin.customer.edit', compact('model','opening_balance'));
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

        authorize(['customer.create']);
        $request->validate([
            'customer_name' => 'required',
            // 'credit_balance' => 'required',
            'status' => 'required',
            'customer_mobile' => 'required',
            'net_total' => 'nullable|numeric',
        ]);

        $model = Customer::findOrFail($id);
        $model->customer_name = $request->customer_name;
        $model->customer_mobile = $request->customer_mobile;
        $model->date_of_birth = $request->date_of_birth;
        $model->customer_email = $request->customer_email;
        $model->customer_sex = $request->customer_sex;
        $model->customer_age = $request->customer_age;
        $model->gtin = $request->gtin;
        $model->customer_city = $request->customer_city;
        $model->customer_state = $request->customer_state;
        $model->customer_country = $request->customer_country;
        $model->status = $request->status;
        $model->save();

        // Edit Account TAble
        $model1 = Account::where('customer_id', $id)->first();
        $model1->name = $request->customer_name;
        $model1->phone = $request->customer_mobile;
        $model1->email = $request->customer_email;
        $model1->address = $request->customer_city;
        $model1->save();


        $ob_transaction =  Transaction::where('customer_id', $id)
                                        ->where('transaction_type', 'cus_opening')
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
                   $customer =$model->id;
                   $supplier =null;
                   $type ='Credit';
                   $trans_type ='cus_opening';
                    $this->transactionUtil->createOpeningBalanceTransaction($customer,$supplier, $request->input('net_total',$type,$trans_type));

                }
            }

        \SadikLog::addToLog('Updated a Customer - ' . $request->customer_name .'.');

        return response()->json(['status' => 'success', 'message' => ' Customer is updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        authorize(['delete.create'], true);
          $count = Transaction::where('customer_id', $id)->count();
          if ($count == 0) {
                    $model = Customer::findOrFail($id);
                        \SadikLog::addToLog('Deleted a Customer - '. $model->customer_name);
                    $model->delete();
                       return response()->json(['status' => 'success', 'message' => 'Customer is deleted successfully']);
                } else {
                    throw ValidationException::withMessages(['message' =>'Customer Can not Deleted Because Transaction Exit This Customer']);
            }

    }


          /**
     * Shows contact's payment due modal
     *
     * @param  int  $customer_id
     * @return \Illuminate\Http\Response
     */
    public function make_payment($customer_id)
    {

        if (request()->ajax()) {

            $due_payment_type = request()->input('type');
            $query = Customer::where('customers.id', $customer_id)
                            ->join('transactions AS t', 'customers.id', '=', 't.customer_id');
            if ($due_payment_type == 'Sale') {
                $query->select(
                        DB::raw("SUM(IF(t.transaction_type = 'Sale', net_total, 0)) as total_sale"),
                        DB::raw("SUM(IF(t.transaction_type = 'Sale', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_paid"),
                        'customers.customer_name',
                        'customers.id as customer_id'
                    );
            } elseif ($due_payment_type == 'sale_return') {
                $query->select(
                        DB::raw("SUM(IF(t.transaction_type = 'sale_return', net_total, 0)) as total_sale_return"),
                        DB::raw("SUM(IF(t.transaction_type = 'sale_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_return_paid"),
                        'customers.customer_name',
                        'customers.id as customer_id'
                    );
            }

            //Query for opening balance details
            $query->addSelect(
                DB::raw("SUM(IF(t.transaction_type = 'cus_opening', net_total, 0)) as opening_balance"),
                DB::raw("SUM(IF(t.transaction_type = 'cus_opening', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid")
            );
            $contact_details = $query->first();

            $payment_line = new TransactionPayment();
            if ($due_payment_type == 'Sale') {
                $contact_details->total_sale = empty($contact_details->total_sale) ? 0 : $contact_details->total_sale;
                $payment_line->amount = $contact_details->total_sale -
                                    $contact_details->total_paid;
            } elseif ($due_payment_type == 'sale_return') {
                $payment_line->amount = $contact_details->total_sale_return -
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
                return view('admin.customer.pay_due_modal')
                        ->with(compact('contact_details', 'payment_line', 'due_payment_type', 'ob_due', 'amount_formated'));
            }
        }
    }
}
