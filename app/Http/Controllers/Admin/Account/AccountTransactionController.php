<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use App\Models\Admin\Account;
use App\Models\Admin\AccountTransaction;
use App\TransactionPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AccountTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        authorize(['voucher.create']);
        return view('admin.vaucher.index');
    }

    public function opening_balance()
    {

        $models = Account::where('status', 'Active')->get();
        return view('admin.vaucher.opening-balance', compact('models'));
    }


    public function ob_store(Request $request)
    {
        $request->validate([
            'account' => 'required',
            'type' => 'required',
            'amount' => 'required|numeric',
        ]);


        $model = new AccountTransaction;
        $model->account_id = $request->account;
        $model->type = $request->type;
        $model->sub_type = 'Opening_balance';
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('AcOp');
        $model->save();

        \SadikLog::addToLog('Opening Balance - ');

        return response()->json(['status' => 'success', 'message' => 'Save successfully', 'window' => route('admin.vaucher.opening_balance.print', $model->id)]);
    }

    // opening_balance_print
    public function opening_balance_print($id) {
        $model = AccountTransaction::findOrFail($id);
        return view('admin.vaucher.print.opening-balance', compact('model'));
    }





    // Deposit Section
    public function deposit()
    {
        $bank = Account::where('status', 'Active')->get();
        return view('admin.vaucher.deposit', compact('bank'));
    }


    // Receipt Section


    public function balance_check(Request $request)
    {
        $model = Account::with('account')->findOrFail($request->value);

        $debit = $model->account->where('type','Debit')->sum('amount');
        $credit = $model->account->where('type','Credit')->sum('amount');
        $data = dabit_credit2($debit,$credit);
        return response()->json($data);
    }



    public function deposit_store(Request $request)
    {
        $request->validate([
            'bank' => 'required',
            'amount' => 'required',
        ]);

        if ($request->voucher_number){
            $voucher_number = $request->voucher_number;
        }else{
            $voucher_number = acrandom_num('Deposit');
        }

        if($request->note){
            $note = $request->note;
        }else{
            $note = 'Deposit To cash';
        }

        $account = Account::find($request->bank);

        $model = new AccountTransaction;
        $model->account_id = $request->bank;
        $model->type = check_debit_credit($request->bank);
        $model->sub_type = 'Deposit';
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $note;
        $model->reff_no= $voucher_number;
        $model->save();
        $id = $model->id;

        $model = new AccountTransaction;
        $model->account_id = 1;
        $model->parent_id = $id;
        $model->type = 'Debit';
        $model->sub_type = 'Deposit';
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = 'Cash Deposit From '. $account->name;
        $model->reff_no= $voucher_number;
        $model->save();
        $id = $model->id;
        \SadikLog::addToLog('Deposit - ');

        return response()->json(['status' => 'success', 'message' => 'Save successfully','window'=>route('admin.vaucher.deposit.print',$id)]);
    }


    public function deposit_print($id)
    {
        $model =AccountTransaction::find($id);
        return view('admin.vaucher.print.deposit_print', compact('model'));
    }


    // Payment Section

    public function withdraw()
    {
        $bank = Account::where('status', 'Active')->get();
        return view('admin.vaucher.withdraw', compact('bank'));
    }



    public function withdraw_store(Request $request)
    {
        $request->validate([
            'bank' => 'required',
            'amount' => 'required',
        ]);

        if ($request->voucher_number) {
            $voucher_number = $request->voucher_number;
        } else {
            $voucher_number = acrandom_num('Withdraw');
        }

        if ($request->note) {
            $note = $request->note;
        } else {
            $note = 'Withdraw From cash';
        }
        $account = Account::find($request->bank);

        $model = new AccountTransaction;
        $model->account_id = $request->bank;
        $model->type = check_debit_credit($request->bank,'to');
        $model->sub_type = 'Withdraw';
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $note;
        $model->reff_no = $voucher_number;
        $model->save();
        $id = $model->id;

        $model = new AccountTransaction;
        $model->account_id = 1;
        $model->parent_id = $id;
        $model->type = 'Credit';
        $model->sub_type = 'Withdraw';
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = 'Cash Withdraw To ' . $account->name;
        $model->reff_no= $voucher_number;
        $model->save();
         $id =$model->id;

        \SadikLog::addToLog('Withdraw - ');


        return response()->json(['status' => 'success', 'message' => 'Save successfully','window'=>route('admin.vaucher.withdraw.print',$id)]);
    }

    public function withdraw_print($id)
    {
        $model =AccountTransaction::find($id);
        return view('admin.vaucher.print.withdraw_print', compact('model'));
    }

    // Contra Section

    public function contra()
    {
        $bank = Account::whereIn('category', ['Bank_Account', 'Cash_in_hand'])->where('status', 'Active')->get();
        return view('admin.vaucher.contra', compact('bank'));
    }



    public function contra_store(Request $request)
    {
        $request->validate([
            'from_bank' => 'required',
            'to_bank' => 'required',
            'amount' => 'required',
        ]);

        $model = new AccountTransaction;
        $model->account_id = $request->to_bank;
        $model->type = 'Debit';
        $model->sub_type = 'Contra';
        $model->from = $request->from_bank;
        $model->to = $request->to_bank;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('Contra');
        $model->save();

        $model = new AccountTransaction;
        $model->account_id = $request->from_bank;
        $model->type = 'Credit';
        $model->sub_type = 'Contra';
        $model->from = $request->from_bank;
        $model->to = $request->to_bank;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('contra');
        $model->save();

        \SadikLog::addToLog('Contra - ');

        return response()->json(['status' => 'success', 'message' => 'Save successfully']);
    }


    // Journal Vaucher Section

    public function journal()
    {
        $bank = Account::whereIn('category', ['Bank_Account', 'Cash_in_hand'])->where('status', 'Active')->get();
        $models = Account::whereNotIn('category', ['Bank_Account', 'Cash_in_hand', 'Employee'])->where('status', 'Active')->get();
        return view('admin.vaucher.journal', compact('bank', 'models'));
    }


    public function journal_data(Request $request)
    {
        $bank = Account::where('status', 'Active')->find($request->bank);
        $type = $request->type;
        $amount = $request->amount;
        $account = Account::where('status', 'Active')->find($request->account);
        return view('admin.vaucher.partial.itemlist', compact('bank', 'account', 'type', 'amount'));
    }


    public function journal_store(Request $request)
    {

        if ($request->form_bank != null) {

        $date = date('Y-m-d');
        $count = count($request->form_bank);

        for ($i = 0; $i < $count; $i++) {

            $data = new AccountTransaction;
            $data['account_id'] = $request->to_bank[$i];
            $data['type'] = $request->sent_type[$i];
            $data['sub_type'] = 'Journal Vaucher';
            $data['from'] = $request->form_bank[$i];
            $data['to'] = $request->to_bank[$i];
            $data['amount'] = $request->sent_amount[$i];
            $data['operation_date'] = $date;

            $data['reff_no']=acrandom_num('Journal');
            $data->save();


            if ($request->sent_type[$i] == 'Debit') {
                $type = 'Credit';
            } else {
                $type = 'Debit';
            }

            $data = new AccountTransaction;
            $data['account_id'] = $request->form_bank[$i];
            $data['type'] = $type;
            $data['sub_type'] = 'Journal Vaucher';
            $data['from'] = $request->to_bank[$i];
            $data['to'] = $request->form_bank[$i];
            $data['amount'] =  $request->sent_amount[$i];
            $data['operation_date'] = $date;
            $data['reff_no']=acrandom_num('Journal');
            $data->save();

        }

        \SadikLog::addToLog('Journal Vaucher - ');

        return response()->json(['status' => 'success', 'message' => 'Save successfully']);
    }else{
            return response()->json(['status' => 'danger', 'message' => 'Please Added Data First']);
    }
}



    // Expense Section

    public function expense()
    {
        $bank = Account::whereIn('category', ['Bank_Account', 'Cash_in_hand'])->where('status', 'Active')->get();
        $expense = Account::where('category', 'Direct_Expanses')->where('status', 'Active')->get();
        return view('admin.vaucher.expense', compact('bank', 'expense'));
    }


    public function expense_store(Request $request)
    {
        $request->validate([
            'bank' => 'required',
            'expense' => 'required',
            'amount' => 'required',
        ]);

        $model = new AccountTransaction;
        $model->account_id = $request->bank;
        $model->type = 'Credit';
        $model->sub_type = 'Expense';
        $model->from = $request->expense;
        $model->to = $request->bank;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('Expense');
        $model->reff_no=acrandom_num('Exp');
        $model->save();

        $model = new AccountTransaction;
        $model->account_id = $request->expense;
        $model->type = 'Debit';
        $model->sub_type = 'Expense';
        $model->from = $request->expense;
        $model->to = $request->bank;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('Expense');
        $model->save();

        \SadikLog::addToLog('Expense - ');

        return response()->json(['status' => 'success', 'message' => 'Save successfully','window'=>route('admin.vaucher.expense.print',$model->id)]);
    }

     public function expense_print($id)
    {
        $model =AccountTransaction::find($id);
        return view('admin.vaucher.print.expense_print', compact('model'));
    }



    // Income Section

    public function loan()
    {
        $bank = Account::whereIn('category', ['Bank_Account', 'Cash_in_hand'])->where('status', 'Active')->get();
        $loan = Account::where('category', 'Unsecured_Loans')->where('status', 'Active')->get();
        return view('admin.vaucher.loan', compact('bank', 'loan'));
    }


    public function loan_store(Request $request)
    {
        $request->validate([
            'bank' => 'required',
            'loan' => 'required',
            'amount' => 'required',
        ]);

        $model = new AccountTransaction;
        $model->account_id = $request->loan;
        $model->type = 'Credit';
        $model->sub_type = 'Loan_Received';
        $model->from = $request->bank;
        $model->to = $request->loan;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('Loan');
        $model->save();

        $model = new AccountTransaction;
        $model->account_id = $request->bank;
        $model->type = 'Debit';
        $model->sub_type = 'Loan_Received';
        $model->from = $request->bank;
        $model->to = $request->loan;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('Loan');
        $model->save();

        \SadikLog::addToLog('Loan Received - ');

        return response()->json(['status' => 'success', 'message' => 'Save successfully','window'=>route('admin.vaucher.loan_received_print.print',$model->id)]);
    }

   public function loan_received_print($id)
   {
     $model=AccountTransaction::find($id);
     return view('admin.vaucher.print.loan_received_print',compact('model'));
   }


    public function loan_pay()
    {
        $bank = Account::whereIn('category', ['Bank_Account', 'Cash_in_hand'])->where('status', 'Active')->get();
        $loan = Account::where('category', 'Unsecured_Loans')->where('status', 'Active')->get();
        return view('admin.vaucher.loan_pay', compact('bank', 'loan'));
    }


    public function loan_pay_store(Request $request)
    {
        $request->validate([
            'bank' => 'required',
            'loan_pay' => 'required',
            'amount' => 'required',
        ]);

        $model = new AccountTransaction;
        $model->account_id = $request->loan_pay;
        $model->type = 'Debit';
        $model->sub_type = 'Loan_Pay';
        $model->from = $request->bank;
        $model->to = $request->loan;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('LP');
        $model->save();

        $model = new AccountTransaction;
        $model->account_id = $request->bank;
        $model->type = 'Credit';
        $model->sub_type = 'Loan_Pay';
        $model->from = $request->bank;
        $model->to = $request->loan;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('LP');
        $model->save();

        \SadikLog::addToLog('Loan Pay - ');

         return response()->json(['status' => 'success', 'message' => 'Save successfully','window'=>route('admin.vaucher.loan_pay_print.print',$model->id)]);
    }



    public function loan_pay_print($id)
   {
     $model=AccountTransaction::find($id);
     return view('admin.vaucher.print.loan_pay_print',compact('model'));
   }



    // Income Section

    public function income()
    {
        $bank = Account::whereIn('category', ['Bank_Account', 'Cash_in_hand'])->where('status', 'Active')->get();
        $income = Account::where('category', 'Direct_Income')->where('status', 'Active')->get();
        return view('admin.vaucher.income', compact('bank','income'));
    }


    public function income_store(Request $request)
    {
        $request->validate([
            'bank' => 'required',
            'income' => 'required',
            'amount' => 'required',
        ]);


        $model = new AccountTransaction;
        $model->account_id = $request->bank;
        $model->type = 'Debit';
        $model->sub_type = 'Income';
        $model->from = $request->income;
        $model->to = $request->bank;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('Income');
        $model->save();

        $model = new AccountTransaction;
        $model->account_id = $request->income;
        $model->type = 'Credit';
        $model->sub_type = 'Income';
        $model->from = $request->income;
        $model->to = $request->bank;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('Income');
        $model->save();

        \SadikLog::addToLog('Income - ');

        return response()->json(['status' => 'success', 'message' => 'Save successfully','window'=>route('admin.vaucher.income.print',$model->id)]);
    }

    public function income_print($id)
    {
       $model =AccountTransaction::find($id);
        return view('admin.vaucher.print.income_print', compact('model'));
    }


    // Debit Section

    public function debit()
    {
        $models = Account::where('status', 'Active')->get();
        return view('admin.vaucher.debit', compact('models'));
    }

    public function debit_store(Request $request)
    {
        $request->validate([
            'debit1' => 'required',
            'debit2' => 'required',
            'amount' => 'required',
        ]);

        $model = new AccountTransaction;
        $model->account_id = $request->debit1;
        $model->type = 'Debit';
        $model->sub_type = 'Debit_note';
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('deStore');
        $model->save();

        $amount = ($request->amount) * (-1);
        $model = new AccountTransaction;
        $model->account_id = 1;
        $model->type = 'Credit';
        $model->sub_type = 'Credit_note';
        $model->amount = $amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('crdnt');
        $model->save();

        $model = new AccountTransaction;
        $model->account_id = $request->debit2;
        $model->type = 'Debit';
        $model->sub_type = 'Debit_note';
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('DBST');
        $model->save();

        $amount = ($request->amount) * (-1);
        $model = new AccountTransaction;
        $model->account_id = 1;
        $model->type = 'Credit';
        $model->sub_type = 'Credit_note';
        $model->amount = $amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('CRDT');
        $model->save();

        \SadikLog::addToLog('Debit Note - ');

        return response()->json(['status' => 'success', 'message' => 'Save successfully']);

    }


    // Credit Section

    public function credit()
    {
        $models = Account::where('status', 'Active')->get();
        return view('admin.vaucher.credit', compact('models'));
    }

    // Vaucher Entry Section

    public function vaucher()
    {
        $models = Account::where('status', 'Active')->get();
        return view('admin.vaucher.vaucher-entry', compact('models'));
    }

    public function vaucher_store(Request $request)
    {
        $request->validate([
            'account1' => 'required',
            'account2' => 'required',
            'type1' => 'required',
            'type2' => 'required',
            'amount' => 'required',
        ]);

        if ($request->voucher_number) {
            $voucher_number = $request->voucher_number;
        } else {
            $voucher_number = acrandom_num('Vaucher');
        }

        $model = new AccountTransaction;
        $model->account_id = $request->account1;
        $model->type = $request->type1;
        $model->sub_type = 'Vaucher Entry';
        $model->from = $request->account1;
        $model->to = $request->account2;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no = $voucher_number;
        $model->save();

        $model = new AccountTransaction;
        $model->account_id = $request->account2;
        $model->type = $request->type2;
        $model->sub_type = 'Vaucher Entry';
        $model->from = $request->account1;
        $model->to = $request->account2;
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no = $voucher_number;
        $model->save();

        \SadikLog::addToLog('Vaucher Entry - ');

        return response()->json(['status' => 'success', 'message' => 'Save successfully']);
    }


    public function credit_store(Request $request)
    {
        $request->validate([
            'credit1' => 'required',
            'credit2' => 'required',
            'amount' => 'required',
        ]);

        $amount = ($request->amount) * (-1);
        $model = new AccountTransaction;
        $model->account_id = $request->credit1;
        $model->type = 'Credit';
        $model->sub_type = 'Credit_note';
        $model->amount = $amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('CRCR');
        $model->save();

        $model = new AccountTransaction;
        $model->account_id = 1;
        $model->type = 'Debit';
        $model->sub_type = 'Debit_note';
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('DBDB');
        $model->save();

        $model = new AccountTransaction;
        $model->account_id = $request->credit2;
        $model->type = 'Credit';
        $model->sub_type = 'Credit_note';
        $model->amount = $amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('crcr');
        $model->save();

        $model = new AccountTransaction;
        $model->account_id = 1;
        $model->type = 'Debit';
        $model->sub_type = 'Debit_note';
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->reff_no=acrandom_num('dbdb');
        $model->save();

        \SadikLog::addToLog('Credit Note - ');

        return response()->json(['status' => 'success', 'message' => 'Save successfully']);
    }



        /**
     * Displays payment account report.
     * @return Response
     */
    public function account_payment(Request $request)
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $query = TransactionPayment::whereNotNull('transaction_id')->get();


            return DataTables::of($query)
                    ->editColumn('payment_date', function ($row) {
                        return $row->payment_date;
                    })
                    ->addColumn('action', function ($row) {
                         if (auth()->user()->can("accounting.update")) {
                        $action = '<button type="button" class="btn btn-info
                        btn-sm" id="content_managment" data-url="' .route('admin.accounting.getLinkAccount',$row->id) .'" data-container=".view_modal">' . __('Link Account') .'</button>';
                        }
                        return $action;
                    })
                    ->addColumn('account', function ($row) {
                        $account = '';
                        if (!empty($row->account_id)) {
                            $account = $row->account?$row->account->name:'' ;
                        }
                        return $account;
                    })

                    ->addColumn('supplier', function ($row) {
                        $supplier = '';
                        if (!empty($row->supplier_id)) {
                            $supplier = $row->supplier?$row->supplier->sup_name:'' ;
                        }
                        return $supplier;
                    })

                    ->addColumn('customer', function ($row) {
                        $customer = '';
                        if (!empty($row->customer_id)) {
                            $customer = $row->customer?$row->customer->customer_name:'' ;
                        }
                        return $customer;
                    })
                    ->addColumn('transaction_number', function ($row) {
                        $html = '';
                        if ($row->transaction->transaction_type == 'Sale') {
                            $html = '<button type="button" class="btn btn-link"
                                    id="content_managment" data-url="' .route('admin.sale_voucher.sale.show',$row->transaction_id) .'" data-container=".view_modal">' . $row->transaction->reference_no . '</button>';
                        } elseif ($row->transaction->transaction_type == 'Purchase') {
                            $html = '<button type="button" class="btn btn-link"
                                    id="content_managment" data-url="' . route('admin.pur_voucher.purchase.show',$row->transaction_id) .'" data-container=".view_modal">' . $row->transaction->reference_no . '</button>';
                        }
                        elseif ($row->transaction->transaction_type == 'sale_return') {
                            $html = '<button type="button" class="btn btn-link"
                                    id="content_managment" data-url="' . route('admin.sale_voucher.return.show',$row->transaction->return_parent_id) .'" data-container=".view_modal">' . $row->transaction->reference_no . '</button>';
                        }

                        elseif ($row->transaction->transaction_type == 'purchase_return') {
                            $html = '<button type="button" class="btn btn-link"
                                    id="content_managment" data-url="' . route('admin.pur_voucher.return.show',$row->transaction->return_parent_id) .'" data-container=".view_modal">' . $row->transaction->reference_no . '</button>';
                        }

                         elseif ($row->transaction->transaction_type == 'opening_balance') {
                            $html =  $row->transaction->reference_no;
                        }
                        return $html;
                    })
                    ->editColumn('type', function ($row) {
                        $type = '';
                        if ($row->transaction->transaction_type == 'Sale') {
                            $type = __('Sale');
                        } elseif ($row->transaction->transaction_type == 'Purchase') {
                            $type = __('Purchase');
                        } elseif ($row->transaction->transaction_type == 'sale_return') {
                            $type = __('Sale Return');
                        }
                        elseif ($row->transaction->transaction_type == 'purchase_return') {
                            $type = __('Sale Return');
                        }
                        elseif ($row->transaction->transaction_type == 'opening_balance') {
                            $type = __('Opening Balance');
                        }
                        return $type;
                    })
                    ->rawColumns(['action', 'type','transaction_number','customer','supplier'])
                    ->make(true);
        }

        $accounts = Account::all();

        return view('admin.payment_account.index',compact('accounts'))
               ;
    }

    public function account_list($id)
    {

        if (request()->ajax()) {
            $payment = TransactionPayment::findOrFail($id);
            $accounts = Account::all();

            return view('admin.payment_account.link_account_modal')
                ->with(compact('accounts', 'payment'));
        }
    }


        /**
     * Links account with a payment.
     * @param  Request $request
     * @return Response
     */
    public function postLinkAccount(Request $request)
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }
            if (request()->ajax()) {
                $payment_id = $request->input('transaction_payment_id');
                $account_id = $request->input('account_id');

                $payment = TransactionPayment::findOrFail($payment_id);
                $payment->account_id = $account_id;
                $payment->save();

                $payment_type = !empty($payment->transaction->transaction_type) ? $payment->transaction->transaction_type : null;
                if (empty($payment_type)) {
                    $child_payment = TransactionPayment::where('parent_id', $payment->id)->first();
                    $payment_type = !empty($child_payment->transaction->transaction_type) ? $child_payment->transaction->transaction_type : null;
                }

                AccountTransaction::updateAccountTransaction($payment, $payment_type);
          return response()->json(['success' => true, 'status' => 'success', 'message' => __('Link To Account')]);
            }


    }
}
