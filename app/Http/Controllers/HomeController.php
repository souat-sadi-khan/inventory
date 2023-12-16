<?php

namespace App\Http\Controllers;

use App\InvoiceLayout;
use App\Models\Admin\Account;
use App\Models\Admin\AccountTransaction;
use App\Models\Products\Product;
use App\Transaction;
use App\TransactionPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
               //top 5 products
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $stock_value_by_cost = 0;
        $stock_value_by_price = 0;
        $products = Product::select('id','product_name','product_cost', 'product_price', 'stock')->get();
        foreach($products as $product){
           $top_products_all[$product->product_name] =  $product->sale_line->sum('quantity');
           $top_products_month[$product->product_name] =  $product->sale_line()->whereBetween('created_at',[$start,$end])->sum('quantity');
           
           //cost & sell value of stock
           $stock_value_by_cost = $stock_value_by_cost + $product->stock * $product->product_cost;
           
           $stock_value_by_price = $stock_value_by_price + $product->stock * $product->product_price;
        }
        
        if($products->count() != 0){
            arsort($top_products_month);
            $top_products =  array_slice($top_products_month, 0, 5);
        }else{
            $top_products = [];
        }
        
        $top_product_name = [];
        $selling_quantity = [];
        foreach($top_products as $x => $top_product){
            $top_product_name[] = '"'.$x.'"';
            $selling_quantity[] = $top_product;
        }
        /*top products ends*/
            
        //stock value by cost price and mrp
        $profit_estimate = $stock_value_by_price - $stock_value_by_cost;
        $stock = [$stock_value_by_cost, $stock_value_by_price, $profit_estimate];

        $dayNames = [];
        $lastSevenDaySells = [];
        $lastSevenDayPurchases = [];
        $lastSevenDayTransactions = [];

       for($i = 0; $i <= 5; $i++)
        {
            $dayNames[] = now()->subDays($i)->format('D');

            //check if today or not
            if($i == 0)
            {
                $getNow = now()->format("Y-m-d");
                $getStarts = Carbon::createFromFormat('Y-m-d', $getNow)->startOfDay();
                $getStarts =date_format($getStarts,"Y-m-d");
                $getEnds = Carbon::createFromFormat('Y-m-d', $getNow)->endOfDay();
                $getEnds =date_format($getEnds,"Y-m-d");
            }else
            {
                $getNow = now()->subDays($i)->format('Y-m-d');
                $getStarts = Carbon::createFromFormat('Y-m-d', $getNow)->startOfDay();
                $getStarts =date_format($getStarts,"Y-m-d");
                $getEnds = Carbon::createFromFormat('Y-m-d', $getNow)->endOfDay();
                $getEnds =date_format($getEnds,"Y-m-d");
            }

            $lastSevenDaySells[] = Transaction::whereBetween('date' , [$getStarts , $getEnds])->where('transaction_type', 'Sale')->sum('net_total');
            $lastSevenDayPurchases[] = Transaction::whereBetween('date' , [$getStarts , $getEnds])->where('transaction_type', 'Purchase')->sum('net_total');
            $lastSevenDayTransactions[] = TransactionPayment::whereBetween('payment_date',[$getStarts,$getEnds])->sum('amount');

        }

                            //today's total transaction
        $todays_stats['total_transactions_today'] = $lastSevenDayTransactions[0];
        //today's total selling price
        $todays_stats['total_selling_price'] = $lastSevenDaySells[0];
        //today's total purchasing price
        $todays_stats['total_purchasing_price'] = $lastSevenDayPurchases[0];
        //get the name of last seven days
        $daynames = implode("', '",array_reverse($dayNames));
        $daynames = "'".$daynames."'";

        $lastSevenDaySells = implode(',', array_reverse($lastSevenDaySells));
        $lastSevenDayPurchases = implode(',', array_reverse($lastSevenDayPurchases));
        $lastSevenDayTransactions = implode(',', array_reverse($lastSevenDayTransactions));
        return view('home',compact('top_product_name','selling_quantity','daynames','lastSevenDaySells','lastSevenDayPurchases','lastSevenDayTransactions'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function myTestAddToLog()
    {
        \SadikLog::addToLog('My Testing Add To Log.');
    }

    public function today()
    {
        $accounts = Account::where('category', 'Direct_Income')->get()->pluck('id');
        $my_bank = AccountTransaction::whereIn('account_id', $accounts)->where('operation_date',date('y-m-d'));
        $my_bank = accountCheck($my_bank->sum('amount'));
        $receipt =AccountTransaction::where('sub_type','Receipt')->where('operation_date',date('y-m-d'))->sum('amount');
        $receipt_amt =accountCheck($receipt);

        $total_receipt =AccountTransaction::where('sub_type','Receipt')->sum('amount');
        $total_receipt_amt =accountCheck($total_receipt);


        $total_payment =AccountTransaction::where('sub_type','Payment')->sum('amount');
        $total_payment_amt =accountCheck($total_payment);
        $payment =AccountTransaction::where('sub_type','Payment')->where('operation_date',date('y-m-d'))->sum('amount');
        $payment_amt =accountCheck($payment);

        $my_cash_credit =AccountTransaction::where('account_id',1)->where('type','Credit')->where('operation_date',date('y-m-d'))->sum('amount');
        $my_cash_debit =AccountTransaction::where('account_id',1)->where('type','Debit')->where('operation_date',date('y-m-d'))->sum('amount');
        $my_cash =accountCheck($my_cash_debit-$my_cash_credit);

        $current_cash_credit =AccountTransaction::where('account_id',1)->where('type','Credit')->sum('amount');
        $current_cash_debit =AccountTransaction::where('account_id',1)->where('type','Debit')->sum('amount');
        $current_cash =accountCheck($current_cash_debit-$current_cash_credit);
        return view('admin.report.today',compact('my_bank','receipt_amt','payment_amt','total_receipt_amt','total_payment_amt','my_cash','current_cash'));
    }


    public function invoice_layout()
    {
        return view('admin.settings.invoice_layout');
    }

    public function invoice_layout_create(Request $request)
    {
        $type =$request->type;
        if ($type=='invoice') {
          return view('admin.settings.invoice_layout_create',compact('type'));
        }

        elseif ($type=='voucher') {
           return view('admin.settings.receipt_layout_create',compact('type'));
        }
    }

    public function invoice_layout_update(Request $request)
    {
        $type =$request->type;
        $name =$request->name;
        $invoice['company_name'] =$request->company_name;
        $invoice['header'] =$request->header;
        $invoice['top_header'] =$request->top_header;
        $invoice['mobile_no'] =$request->mobile_no;
        $invoice['phone'] =$request->phone;
        $invoice['email'] =$request->email;
        $invoice['owner_sign'] =$request->owner_sign;
        $invoice['owner_sign'] =$request->owner_sign;
        if ($type=='invoice') {
            $invoice['product'] =$request->product;
            $invoice['quantity'] =$request->quantity;
            $invoice['price'] =$request->price;
            $invoice['total'] =$request->total;
            $invoice['sub_total'] =$request->sub_total;
            $invoice['net_total'] =$request->net_total;
            $invoice['discount'] =$request->discount;
            $invoice['tax'] =$request->tax;
            $invoice['shipping'] =$request->shipping;
            $invoice['paid'] =$request->paid;
            $invoice['due'] =$request->due;
            $invoice['return'] =$request->return;
            $invoice['return_total'] =$request->return_total;
            $invoice['customer_sign'] =$request->customer_sign;
            $invoice['c_name'] =$request->c_name;
            $invoice['c_address'] =$request->c_address;

             InvoiceLayout::updateOrCreate(
                ['type'=>$type],
                ['name'=>$name],
                ['value' => json_encode($invoice)]
            );

             return response()->json(['success' => true, 'status' => 'success', 'message' => 'Update Successfully.']);
        }
    }
}
