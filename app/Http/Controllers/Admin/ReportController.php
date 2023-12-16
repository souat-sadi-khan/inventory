<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Account;
use App\Models\Admin\AccountTransaction;
use App\Models\Customer;
use App\Models\Products\Product;
use App\Models\Supplier;
use App\Models\Vehicle\VehicleTransaction;
use App\Purchase;
use App\Transaction;
use App\TransactionSellLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ReportController extends Controller
{
    //

    public function index()
    {
        authorize(['report.view']);
        return view('admin.report.index');
    }

    public function trial_balance()
    {
        authorize(['report.view']);
        return view('admin.report.trial-balance');
    }


    public function trial_balance_show(Request $request)
    {

        $date = $request->operation_date;
        $accounts = Account::groupBy('category')->get();
        $data = [];
        foreach ($accounts as $account) {
            $category = $account->category;
            $data[$category] = [
                'Debit' => $this->account_calculation($category, 'Debit', $date),
                'Credit' => $this->account_calculation($category, 'Credit', $date),
            ];
        }

        /*$data['Purchase'] = [
            'Credit' => $this->sell_calculation('Purchase', $date),
            'Debit' => $this->sell_calculation('purchase_return', $date),
        ];

        $data['Sale'] = [
            'Credit' => $this->sell_calculation('sale_return', $date),
            'Debit' => $this->sell_calculation('Sale', $date),
        ];*/


       /* $data['Opening_Balance'] = [
            'Debit' => $this->opening_balance_calculation('Credit', $date),
            'Credit' => $this->opening_balance_calculation('Debit', $date),
        ];*/

        /*$data['Vehicle_Transaction'] = [
            'Debit' => $this->vehicle_calculation('Income', $date),
            'Credit' => $this->vehicle_calculation('Expence', $date),
        ];*/

        return view('admin.report.trial-balance-table', compact('data', 'date'));

    }


    protected function sell_calculation($sub_type, $start_date = Null, $end_date = Null)
    {
        $q = AccountTransaction::where('sub_type', $sub_type);
        if ($start_date and $end_date) {
            $q = $q->where('sub_type', $sub_type)->where('operation_date', '>=', $start_date)->where('operation_date', '<=', $end_date);
        } elseif ($start_date) {
            $q = $q->where('sub_type', $sub_type)->where('operation_date', $start_date);
        }
        return $q->sum('amount');
    }

    protected function product_opening_stock($start_date = Null, $end_date = Null)
    {
        $q = AccountTransaction::where('sub_type', $sub_type);
        if ($start_date and $end_date) {
            $q = $q->where('sub_type', $sub_type)->where('operation_date', '>=', $start_date)->where('operation_date', '<=', $end_date);
        } elseif ($start_date) {
            $q = $q->where('sub_type', $sub_type)->where('operation_date', $start_date);
        }
        return $q->sum('amount');
    }

    protected function vehicle_calculation($sub_type, $start_date = Null, $end_date = Null)
    {
        $q = VehicleTransaction::where('type', $sub_type);
        if ($start_date and $end_date) {
            $q = $q->where('type', $sub_type)->where('date', '>=', $start_date)->where('date', '<=', $end_date);
        } elseif ($start_date) {
            $q = $q->where('type', $sub_type)->where('date', $start_date);
        }
        return $q->sum('amount');
    }


    protected function account_calculation($account, $type, $start_date = Null, $end_date = Null)
    {

        $account = Account::where('category', $account)->get()->pluck('id');
        $trans = AccountTransaction::whereIn('account_id', $account)->where('type', $type);
        if ($start_date and $end_date) {
            $trans = $trans->where('operation_date', '>=', $start_date)->where('operation_date', '<=', $end_date);
        } elseif ($start_date) {
            $trans = $trans->where('operation_date', $start_date);
        } else {
            $trans = $trans;
        }

        return $trans->sum('amount');
    }


    public function day_book(Request $request)
    {
        $accounts = Account::where('status', 'Active')->get();
        return view('admin.report.day-book', compact('accounts'));
    }


    public function day_book_show(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account = $request->account;


        if ($account == 'Account') {


            $accounts = Account::groupBy('category')->get();
            $data = [];
            foreach ($accounts as $account) {
                $category = $account->category;
                $data[$category] = [
                    'Debit' => $this->account_calculation($category, 'Debit', $start_date, $end_date),
                    'Credit' => $this->account_calculation($category, 'Credit', $start_date, $end_date),
                ];
            }

            /*$data['Purchase'] = [
                'Credit' => $this->sell_calculation('Purchase', $start_date, $end_date),
                'Debit' => $this->sell_calculation('purchase_return', $start_date, $end_date),
            ];

            $data['Sale'] = [
                'Credit' => $this->sell_calculation('sale_return', $start_date, $end_date),
                'Debit' => $this->sell_calculation('Sale', $start_date, $end_date),
            ];*/

           /* $data['Opening_Balance'] = [
                'Debit' => $this->opening_balance_calculation('Credit', $start_date, $end_date),
                'Credit' => $this->opening_balance_calculation('Debit', $start_date, $end_date),
            ];*/

            return view('admin.report.day-book-account-wise', compact('data', 'start_date', 'end_date'));

            // dd($data);
        } elseif ($account == 'Customer') {
            // find all the customer
            $customers = Customer::all();
            $data = [];
            foreach ($customers as $customer) {
                $customer_id = $customer->id;
                $data[$customer_id] = [
                    'Debit' => $this->account_calculation_customer($customer_id, 'sale_return', $start_date, $end_date),
                    'Credit' => $this->account_calculation_customer($customer_id, 'Sale', $start_date, $end_date),
                ];
            }
            // dd($data);
            return view('admin.report.day-book-customer-wise', compact('data', 'start_date', 'end_date'));

        } elseif ($account == 'Supplier') {
            $suppliers = Supplier::all();
            $data = [];
            foreach ($suppliers as $supplier) {
                $supplier_id = $supplier->id;
                $data[$supplier_id] = [
                    'Debit' => $this->account_calculation_supplier($supplier_id, 'Purchase', $start_date, $end_date),
                    'Credit' => $this->account_calculation_supplier($supplier_id, 'purchase_return', $start_date, $end_date),
                ];
            }

            // dd($data);
            return view('admin.report.day-book-supplier-wise', compact('data', 'start_date', 'end_date'));
        }


    }

    protected function account_calculation_supplier($supplier_id, $tran_type = Null, $start_date = Null, $end_date = Null)
    {
        $trans = Transaction::where('supplier_id', $supplier_id)->where('transaction_type', $tran_type)->get();
        if ($start_date and $end_date) {
            $trans = $trans->where('operation_date', '>=', $start_date)->where('operation_date', '<=', $end_date);
        } elseif ($start_date) {
            $trans = $trans->where('date', $start_date);
        } else {
            $trans = $trans;
        }
        // dd($trans);

        return $trans->sum('net_total');
    }

    // account_calculation_customer
    protected function account_calculation_customer($customer_id, $tran_type, $start_date = null, $end_date = null)
    {
        $trans = Transaction::where('customer_id', $customer_id)->where('transaction_type', $tran_type)->get();
        // dd($trans);

        if ($start_date and $end_date) {
            $trans = $trans->where('date', '>=', $start_date)->where('date', '<=', $end_date);
        } elseif ($start_date) {
            $trans = $trans->where('date', $start_date);
        } else {
            $trans = $trans;
        }
        // dd($trans);

        return $trans->sum('net_total');
    }

    protected function opening_balance_calculation($type = Null, $start_date = Null, $end_date = Null)
    {
        $q = AccountTransaction::where('sub_type', 'Opening_balance');
        if ($type) {
            $q->where('type', $type);
        }
        if ($start_date and $end_date) {
            $q = $q->where('sub_type', 'Opening_balance')->where('operation_date', '>=', $start_date)->where('operation_date', '<=', $end_date);
        } elseif ($start_date) {
            $q = $q->where('sub_type', 'Opening_balance')->where('operation_date', $start_date);
        }
        return $q->sum('amount');
    }

    // ledger_book_category
    public function ledger_book_category($category)
    {
        if ($category == 'Purchase') {
            return Redirect()->route('admin.report.purchase');
        }

        if ($category == 'Sale') {
            return Redirect()->route('admin.report.sales');
        }


        if (isset($_GET['start_date'])) {
            $start_date = $_GET['start_date'];
        } else {
            return Redirect::back()->withErrors(['message', 'Start Date is Required']);
        }

        if (isset($_GET['end_date'])) {
            $end_date = $_GET['end_date'];
        } else {
            return Redirect::back()->withErrors(['message', 'End Date is Required']);
        }

        // find all the account using the cateogyy
        $accounts = Account::with(['account' => function ($q) use ($end_date, $start_date) {
            return $q->where('operation_date', '>=', $start_date)->where('operation_date', '<=', $end_date)->get();
        }])->where('category', $category)->get();

        $data = [];
        foreach ($accounts as $account) {
            $data[$account->id] = [
                'Debit' => $this->account_calc_while_category_name($account->id, 'Debit', $start_date, $end_date),
                'Credit' => $this->account_calc_while_category_name($account->id, 'Credit', $start_date, $end_date),
            ];
        }

        return view('admin.report.ledger.category', compact('data', 'category', 'start_date', 'end_date'));
    }

    // account_calc_while_category_name
    protected function account_calc_while_category_name($category_id, $type, $start_date = Null, $end_date = Null)
    {
        $q = AccountTransaction::where('account_id', $category_id)->where('type', $type);
        if ($start_date and $end_date) {
            $q = $q->where('operation_date', '>=', $start_date)->where('operation_date', '<=', $end_date);
        } else {
            $q = $q->where('operation_date', $start_date);
        }
        return $q->sum('amount');
    }

    public function ledger_book_name($id)
    {

        // find the acount
        $account = Account::findOrFail($id);

        if (isset($_GET['start_date'])) {
            $start_date = $_GET['start_date'];
        } else {
            return Redirect::back()->withErrors(['message', 'Start Date is Required']);
        }

        if (isset($_GET['end_date'])) {
            $end_date = $_GET['end_date'];
        } else {
            return Redirect::back()->withErrors(['message', 'Start Date is Required']);
        }

        $models = AccountTransaction::where('account_id', $id)->where('operation_date', '>=', $start_date)->where('operation_date', '<=', $end_date)->get();
        return view('admin.report.ledger.name', compact('models', 'account', 'start_date', 'end_date'));
    }

    // ledger_book_supplier
    public function ledger_book_supplier($id)
    {
        if (isset($_GET['start_date'])) {
            $start_date = $_GET['start_date'];
        } else {
            return Redirect::back()->withErrors(['message', 'Start Date is Required']);
        }

        if (isset($_GET['end_date'])) {
            $end_date = $_GET['end_date'];
        } else {
            return Redirect::back()->withErrors(['message', 'Start Date is Required']);
        }

        // dd('hello');

        // find the supplier
        $supplier = Supplier::findOrFail($id);

        $models = Transaction::groupBy('date')->where('date', '>=', $start_date)->where('date', '<=', $end_date)->where('supplier_id', $id)->get();
        $data = [];
        foreach ($models as $item) {
            $date = $item->date;
            $trans = Transaction::where('date', $date)->where('supplier_id', $id)->get();
            $data[$date] = [
                'Debit' => $trans->where('transaction_type', 'Purchase')->sum('net_total'),
                'Credit' => $trans->where('transaction_type', 'purchase_return')->sum('net_total'),
            ];
        }

        return view('admin.report.ledger.supplier_date', compact('data', 'supplier', 'start_date', 'end_date'));
    }

    // ledger_book_customer
    public function ledger_book_customer($id)
    {
        if (isset($_GET['start_date'])) {
            $start_date = $_GET['start_date'];
        } else {
            return Redirect::back()->withErrors(['message', 'Start Date is Required']);
        }

        if (isset($_GET['end_date'])) {
            $end_date = $_GET['end_date'];
        } else {
            return Redirect::back()->withErrors(['message', 'Start Date is Required']);
        }

        // find the supplier
        $customer = Customer::findOrFail($id);

        $models = Transaction::groupBy('date')->where('date', '>=', $start_date)->where('date', '<=', $end_date)->where('customer_id', $id)->get();
        $data = [];
        foreach ($models as $item) {
            $date = $item->date;
            $trans = Transaction::where('date', $date)->where('customer_id', $id)->get();
            $data[$date] = [
                'Debit' => $trans->where('transaction_type', 'sale_return')->sum('net_total'),
                'Credit' => $trans->where('transaction_type', 'Sale')->sum('net_total'),
            ];
        }

        return view('admin.report.ledger.customer_data', compact('data', 'customer', 'start_date', 'end_date'));
    }

    public function cashbank_book()
    {
        $bank = Account::whereIn('category', ['Bank_Account', 'Cash_in_hand'])->where('status', 'Active')->get();
        return view('admin.report.cashbank-book', compact('bank'));
    }


    public function recept_payment(Request $request)
    {
        return view('admin.report.recept-payment');
    }


    public function recept_payment_show(Request $request)
    {
        $type = $request->type;
        $models = AccountTransaction::where('sub_type', $type)->where('operation_date', '>=', $request->start_date)->where('operation_date', '<=', $request->end_date)->get();
        return view('admin.report.recept-payment-show', compact('models', 'type'));
    }

    public function loan(Request $request)
    {
        return view('admin.report.loan');
    }


    public function loan_show(Request $request)
    {
        // $type = $request->type;
        $data = [];
        $sdate = $request->start_date;
        $edate = $request->end_date;

        // find all the accut
        $accouts = Account::where('category', 'Unsecured_Loans')->get();
        foreach($accouts as $account) {
            $debit = AccountTransaction::where('account_id', $account->id)->where('type', 'Debit')->where('operation_date', '>=', $request->start_date)->where('operation_date', '<=', $request->end_date)->sum('amount');
            $credit = AccountTransaction::where('account_id', $account->id)->where('type', 'Credit')->where('operation_date', '>=', $request->start_date)->where('operation_date', '<=', $request->end_date)->sum('amount');

            $data[] =[
                'id' => $account->id,
                'account_name' => $account->name,
                'debit' => $debit,
                'credit' => $credit,
            ];
        }

        // $models = AccountTransaction::where('sub_type', $type)->where('operation_date', '>=', $request->start_date)->where('operation_date', '<=', $request->end_date)->get();
        return view('admin.report.loan-show', compact('data', 'sdate', 'edate'));
    }

    // loan_unique
    public function loan_unique(Request $request, $id) {
        $account = Account::findOrFail($id);
        $sdate = $request->sdate;
        $edate = $request->edate;
        $data = [];

        $models = AccountTransaction::where('account_id', $id)->where('operation_date', '>=', $request->sdate)->where('operation_date', '<=', $request->edate)->get();
        foreach($models as $model) {

            $data[] = [
                'Date' => formatDate($model->operation_date),
                'Type' => toWord($model->sub_type),
                'Debit' => $model->type == 'Debit' ? $model->amount : '0.00',
                'Credit' =>  $model->type == 'Credit' ? $model->amount : '0.00',
                'note' => $model->note,
            ];
        }

        return view('admin.report.loan-unique', compact('data', 'sdate', 'edate', 'account'));
    }


    public function balance_sheet()
    {
        $asset['Cash_in_hand'] = $this->balancesheet_calculation('Cash_in_hand', true);

        $asset['My_bank_Cash'] = $this->balancesheet_calculation('Bank_Account', true);

        // $asset['Cost_Of_Good'] = $this->cost_of_good_calculation();
//        $asset['Account_Receivable'] = Transaction::where('customer_id', '!=', Null)->sum('due');
        $asset['Account_Receivable'] = $this->balancesheet_calculation('Customer', true);

        $asset['Current_assets'] = $this->balancesheet_calculation('Current_Assets', true);
        $asset['Direct_Expense'] = $this->balancesheet_calculation('Direct_Expanses', true);
        $asset['Employee_Salary'] = $this->balancesheet_calculation('Employee', true);
        $asset['Fixed_Assets'] = $this->balancesheet_calculation('Fixed_Assets', true);
        $asset['Duties_Taxes'] = $this->balancesheet_calculation('Duties_Taxes', true);
        $asset['Sale_Discount'] = Transaction::where('transaction_type', 'Sale')->sum('discount_amount');
        $asset['Purchase_Tax'] = $this->purchase_tax();
        $asset['Purchase_Shipping_Charge'] = Transaction::where('transaction_type', 'Purchase')->sum('shipping_charges');;

        $liabilities['Current_Liabilities'] = $this->balancesheet_calculation('Current_Liabilities');
//        $liabilities['Opening_Balance'] = $this->opening_balance_calculation();

//         $liabilities['Sale_Income'] = $this->sale_income();
        $liabilities['Sale_Tax'] = $this->sale_tax();
        $liabilities['Sale_Shipping_Charge'] = Transaction::where('transaction_type', 'Sale')->sum('shipping_charges');
//        $liabilities['Account_Payable'] = Transaction::where('supplier_id', '!=', Null)->sum('due');
        $liabilities['Account_Payable'] = $this->balancesheet_calculation('Supplier');
//        $liabilities['Purchase_discount'] = Transaction::where('supplier_id', '!=', Null)->sum('discount_amount');

        $liabilities['Direct_Income'] = $this->balancesheet_calculation('Direct_Income');
        $liabilities['Unsecured_Loans'] = $this->balancesheet_calculation('Unsecured_Loans');
//        $liabilities['Bank_Loan'] = $this->balancesheet_calculation('Unsecured_Loans');
        $liabilities['Capital_Account'] = $this->balancesheet_calculation('Capital_Account');
        $liabilities['Investment'] = $this->balancesheet_calculation('Investment');
        $liabilities['Purchase_Discount'] = Transaction::where('transaction_type', 'Purchase')->sum('discount_amount');

//        dd($asset);

        return view('admin.report.balance-sheet', compact('asset', 'liabilities'));
    }

    protected function sale_tax(){
        $transaction = Transaction::where('transaction_type', 'Sale')->get();
        $return_transaction = Transaction::where('transaction_type', 'sale_return')->get();
        $total_tax = 0;
        foreach($transaction as $tran){
            $total_tax += ($tran->sub_total - $tran->discount_amount) * ($tran->tax / 100);
        }

        foreach($return_transaction as $rtran){
            $total_tax -= $rtran->tax;
        }



        return $total_tax;
    }

    protected function purchase_tax(){
        $transaction = Transaction::where('transaction_type', 'Purchase')->get();
        $total_tax = 0;
        foreach($transaction as $tran){
            $total_tax += ($tran->sub_total - $tran->discount_amount) * ($tran->tax / 100);
        }

        return $total_tax;
    }

    protected function sale_income(){

        return  TransactionSellLine::all()->map(function($q){
            $sale_qty = $q->quantity - $q->quantity_returned;
            $sale_price = $sale_qty * $q->unit_price;
            $cost_price = $sale_qty * $q->cost_price;

            return $sale_price - $cost_price;
        })->sum();


    }
    protected function cost_of_good_calculation()
    {
        $cost_of_good = 0;
        $purchase = Purchase::all()->map(function ($p){
            $purchase_qty = $p->qty - $p->quantity_returned;
            return $purchase_qty * $p->price;
        })->sum();
        $sale = TransactionSellLine::all()->map(function($s){
            $sale_qty = $s->quantity - $s->quantity_returned;
            return  $sale_qty * $s->cost_price;
        })->sum();

        $product_opening_stock = Product::all()->sum('opening_value');
        $cost_of_good = ($purchase + $product_opening_stock) - $sale;


        return $cost_of_good;
    }



    protected function balancesheet_calculation($account, $asset = false)
    {
        $account = Account::where('category', $account)->get()->pluck('id');
        $trans = AccountTransaction::whereIn('account_id', $account)->get();

        $credit = $trans->where('type', 'Credit')->sum('amount');
        $debit = $trans->where('type', 'Debit')->sum('amount');

        $opening_balance = 0;
        if ($asset){
            return $debit - $credit;
        }
        return $credit - $debit;
    }


    public function profit_loss(Request $request)
    {
        if ($request->ajax()) {
            $sdate = $request->sdate;
            $edate = $request->edate;
            $sell = Transaction::where('transaction_type', 'Sale');

            if (!empty($sdate) && !empty($edate)) {
                $sell->whereBetween(DB::raw('date(date)'), [$sdate, $edate]);
            }
            $sell_transaction = $sell->get()->pluck('id');


            $sell_lines = TransactionSellLine::whereIn('transaction_id', $sell_transaction)->get();


            $total_selling_price = 0;
            $total_purchase_price = 0;

            foreach($sell_lines as $sell_line){
                $sell_qty = $sell_line->quantity - $sell_line->quantity_returned;
                $total_selling_price += $sell_line->unit_price * $sell_qty;
                $total_purchase_price += $sell_line->cost_price * $sell_qty;
            }


            $gross_profit = $total_selling_price - $total_purchase_price;



            return view('admin.report.get_profit_loss', compact('total_selling_price', 'total_purchase_price', 'gross_profit'));
        }
        return view('admin.report.profit_loss');
    }


    public function product_report(Request $request)
    {
        if ($request->ajax()) {
            $product_id = $request->get('product_id');
            if ($product_id != 'all') {
                $products = Product::find($product_id);
            } else {
                $products = Product::all();
            }

            return view('admin.report.get_product_report', compact('products', 'product_id'));
        }
        $products = Product::all();
        return view('admin.report.product_report', compact('products'));
    }


    // original_day_book_show
    public function original_day_book_show()
    {
        return view('admin.report.day-book.index');
    }

    // get_day_book_report
    public function get_day_book_report(Request $request)
    {
        $start_date = $request->sdate;
        $end_date = $request->edate;

        $data = [];
        $query = AccountTransaction::where('operation_date', '>=', $start_date)->where('operation_date', '<=', $end_date)->get();
        foreach ($query as $item) {

            if ($item->type == 'Debit') {
                $debit = $item->amount;
                $credit = 0;
            } else {
                $debit = 0;
                $credit = $item->amount ;
            }

            $account_id = $item->account_id;

            $data[] = [
                'Account' => $item->account ? $item->account->name : 'No Account',
                'Description' => $item->note,
                'voucher' => $item->sub_type,
                'voucher_no' => $item->reff_no,
                'Debit' => $debit,
                'Credit' => $credit
            ];
        }

        $report_type = 'Day Book Report';

        return view('admin.report.day-book.data', compact('data', 'start_date', 'end_date', 'report_type'));
    }

    // customer_due
    public function customer_due() {
        // find all the customr
        $customers = Customer::all();

        return view('admin.report.customer-due.index', compact('customers'));

    }

    // customer_due_ajax
    public function customer_due_ajax(Request $request) {

        $id = $request->val;

        // find all the customr
        $customers = Customer::all();

        $data = [];
        $total = 0;
        $total_paid = 0;
        $total_due = 0;
        $total_return = 0;

        if($id == 'all') {

            foreach($customers as $customer) {
                $customer_id = $customer->id;

                // find the customer due amount
                $due = Transaction::whereIn('transaction_type', ['Sale', 'cus_opening'])->where('customer_id', $customer_id)->sum('due');
                $payable = Transaction::whereIn('transaction_type', ['Sale', 'cus_opening'])->where('customer_id', $customer_id)->sum('net_total');
                $paid = Transaction::whereIn('transaction_type', ['Sale', 'cus_opening'])->where('customer_id', $customer_id)->sum('paid');
                $return = Transaction::whereIn('transaction_type', ['sale_return'])->where('customer_id', $customer_id)->sum('net_total');
                $invoice = Transaction::where('customer_id', $customer_id)->count();

                $data[] = [
                    'ID' => $customer_id,
                    'Invoice' => $invoice,
                    'Payable' => $payable,
                    'Paid' => $paid,
                    'Name' => $customer->customer_name,
                    'Amount' => $due,
                    'Return' => $return,
                ];

                $total += $payable;
                $total_paid += $paid;
                $total_due += $due;
                $total_return += $return;
            }

        } else {

            $customer_id = $id;
            $customer = Customer::findOrFail($customer_id);
            // find the customer due amount
            $due = Transaction::whereIn('transaction_type', ['Sale', 'cus_opening'])->where('customer_id', $customer_id)->sum('due');
            $payable = Transaction::whereIn('transaction_type', ['Sale', 'cus_opening'])->where('customer_id', $customer_id)->sum('net_total');
            $paid = Transaction::whereIn('transaction_type', ['Sale', 'cus_opening'])->where('customer_id', $customer_id)->sum('paid');
            $return = Transaction::whereIn('transaction_type', ['sale_return'])->where('customer_id', $customer_id)->sum('net_total');
            $invoice = Transaction::where('customer_id', $customer_id)->count();

            $data[] = [
                'ID' => $customer_id,
                'Invoice' => $invoice,
                'Payable' => $payable,
                'Paid' => $paid,
                'Name' => $customer->customer_name,
                'Amount' => $due,
                'Return' => $return,
            ];

            $total += $payable;
            $total_paid += $paid;
            $total_due += $due;
            $total_return += $invoice;

        }


        return view('admin.report.customer-due.show', compact('data', 'customers', 'total', 'total_paid', 'total_due', 'total_return'));

    }

    // supplier_due
    public function supplier_due() {
        // find all the customr
        $suppliers = Supplier::all();

        return view('admin.report.supplier-due.index', compact('suppliers'));

    }

    // supplier_due_ajax
    public function supplier_due_ajax(Request $request) {

        $id = $request->val;

        // find all the customr
        $suppliers = supplier::all();

        $data = [];
        $total = 0;
        $total_paid = 0;
        $total_due = 0;
        $total_return = 0;

        if($id == 'all') {

            foreach($suppliers as $supplier) {
                $supplier_id = $supplier->id;

                // find the customer due amount
                $due = Transaction::whereIn('transaction_type', ['Purchase', 'sup_opening'])->where('supplier_id', $supplier_id)->sum('due');
                $payable = Transaction::whereIn('transaction_type', ['Purchase', 'sup_opening'])->where('supplier_id', $supplier_id)->sum('net_total');
                $paid = Transaction::whereIn('transaction_type', ['Purchase', 'sup_opening'])->where('supplier_id', $supplier_id)->sum('paid');
                $return = Transaction::whereIn('transaction_type', ['purchase_return'])->where('supplier_id', $supplier_id)->sum('net_total');
                $invoice = Transaction::where('supplier_id', $supplier_id)->count();

                $data[] = [
                    'ID' => $supplier_id,
                    'Invoice' => $invoice,
                    'Payable' => $payable,
                    'Paid' => $paid,
                    'Name' => $supplier->sup_name,
                    'Amount' => $due,
                    'Return' => $return,
                ];

                $total += $payable;
                $total_paid += $paid;
                $total_due += $due;
                $total_return += $return;

            }

        } else {

            $supplier_id = $id;
            $supplier = Supplier::findOrFail($supplier_id);
            // find the customer due amount
            $due = Transaction::whereIn('transaction_type', ['Purchase', 'sup_opening'])->where('supplier_id', $supplier_id)->sum('due');
                $payable = Transaction::whereIn('transaction_type', ['Purchase', 'sup_opening'])->where('supplier_id', $supplier_id)->sum('net_total');
                $paid = Transaction::whereIn('transaction_type', ['Purchase', 'sup_opening'])->where('supplier_id', $supplier_id)->sum('paid');
                $return = Transaction::whereIn('transaction_type', ['purchase_return'])->where('supplier_id', $supplier_id)->sum('net_total');
                $invoice = Transaction::where('supplier_id', $supplier_id)->count();

            $data[] = [
                'ID' => $supplier_id,
                'Invoice' => $invoice,
                'Payable' => $payable,
                'Paid' => $paid,
                'Name' => $supplier->sup_name,
                'Amount' => $due,
                'Return' => $return,
            ];

            $total += $payable;
            $total_paid += $paid;
            $total_due += $due;
            $total_return += $return;

        }


        return view('admin.report.supplier-due.show', compact('data', 'suppliers', 'total', 'total_paid', 'total_due', 'total_return'));

    }

    // direct_income
    public function direct_income() {

        return view('admin.report.income.index');

    }

    // direct_income_show
    public function direct_income_show(Request $request) {
        $sdate = $request->sdate;
        $edate = $request->edate;

        // find the Direct Income  Accont
        $accounts = Account::where('category', 'Direct_Income')->get();
        $data = [];

        foreach($accounts as $account) {

            $debit = AccountTransaction::where('account_id', $account->id)->where('type', 'Debit')->where('operation_date', '>=', $sdate)->where('operation_date', '<=', $edate)->sum('amount');
            $credit = AccountTransaction::where('account_id', $account->id)->where('type', 'Credit')->where('operation_date', '>=', $sdate)->where('operation_date', '<=', $edate)->sum('amount');

            $data[] = [
                'account_name' => $account->name,
                'account_id' => $account->id,
                'Debit' => $debit,
                'Credit' => $credit,
            ];
        }

        return view('admin.report.income.show', compact('sdate', 'edate', 'data'));
    }

    // direct_expense
    public function direct_expense() {

        return view('admin.report.expense.index');
    }

    // direct_expense_show
    public function direct_expense_show(Request $request) {
        $sdate = $request->sdate;
        $edate = $request->edate;

        // find the Direct Income  Accont
        $accounts = Account::where('category', 'Direct_Expanses')->get();
        $data = [];

        foreach($accounts as $account) {

            $debit = AccountTransaction::where('account_id', $account->id)->where('type', 'Debit')->where('operation_date', '>=', $sdate)->where('operation_date', '<=', $edate)->sum('amount');
            $credit = AccountTransaction::where('account_id', $account->id)->where('type', 'Credit')->where('operation_date', '>=', $sdate)->where('operation_date', '<=', $edate)->sum('amount');

            $data[] = [
                'account_name' => $account->name,
                'account_id' => $account->id,
                'Debit' => $debit,
                'Credit' => $credit,
            ];
        }

        return view('admin.report.expense.show', compact('sdate', 'edate', 'data'));
    }



  public function today_product_report(Request $request)
    {
        if ($request->ajax()) {

         $products = Product::all();
         $data =[];
         foreach ($products as $product) {
             $data[$product->product_name]=[
            'sale'=>$product->sale_line()->whereDate('created_at',$request->date)->sum('quantity'),
             'purchase'=>$product->purchase()->whereDate('created_at',$request->date)->sum('qty')
             ];

         }
            return view('admin.report.get_today_product_report', compact('data'));
        }
        return view('admin.report.today_product_report');
    }


    // unique_customer
    public function unique_customer($id) {
        // find the cusstoemr opening balance
        $models = Transaction::where('customer_id', $id)->get();

        // find the custoemr
        $customer = Customer::findOrFail($id);

        $data = [];

        foreach($models as $model) {
            $data[] = [
                'Date' => formatDate($model->operation_date),
                'Ref' => $model->reference_no,
                'Type' => toWord($model->transaction_type),
                'Debit' => $model->type == 'Debit' ? $model->net_total : '0.00',
                'Credit' => $model->type == 'Credit' ? $model->net_total : '0.00',
            ];
        }

        return view('admin.report.customer-due.unique', compact('data', 'customer'));

    }

    // unique_supplier
    public function unique_supplier($id) {
        // find the cusstoemr opening balance
        $models = Transaction::where('supplier_id', $id)->get();

        // find the custoemr
        $supplier = Supplier::findOrFail($id);

        $data = [];

        foreach($models as $model) {
            $data[] = [
                'Date' => formatDate($model->operation_date),
                'Ref' => $model->reference_no,
                'Type' => toWord($model->transaction_type),
                'Debit' => $model->type == 'Debit' ? $model->net_total : '0.00',
                'Credit' => $model->type == 'Credit' ? $model->net_total : '0.00',
            ];
        }

        return view('admin.report.supplier-due.unique', compact('data', 'supplier'));

    }


}

