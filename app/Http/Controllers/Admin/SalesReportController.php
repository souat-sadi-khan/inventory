<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Transaction;
use App\TransactionPayment;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    public function index()
    {
    	return view('admin.report.sales.index');
    }

    public function sales()
    {
    	return view('admin.report.sales.sale');
    }

    public function get_sales_report(Request $request)
    {
    	if ($request->ajax()) {
    		$sdate =$request->sdate;
    		$edate =$request->edate;
    		$models = Transaction::where('transaction_type', 'Sale')->where('date', '>=', $sdate)->where('date', '<=', $edate)->get();
    		return view('admin.report.sales.get_sales_report',compact('models','sdate','edate'));
    	}
    }


    public function sales_payment()
    {
    	return view('admin.report.sales.sale_payment');
    }

    public function get_salespayment_report(Request $request)
    {
    	$sdate =$request->sdate;
    	$edate =$request->edate;
    	// $model = TransactionPayment::with(['transaction'=>function($q){
    	// 	return $q->where('transaction_type','Sale');
    	// }])->where('payment_date', '>=', $sdate)->where('payment_date', '<=', $edate)->get();
    	$transaction =Transaction::where('transaction_type','Sale')->get()->pluck('id');
    	$model =TransactionPayment::whereIn('transaction_id',$transaction)->where('payment_date', '>=', $sdate)->where('payment_date', '<=', $edate)->get();
       return view('admin.report.sales.get_salespayment_report',compact('model','sdate','edate'));
    }

    public function sales_return()
    {
    	return view('admin.report.sales.sales_return');
    }

    public function get_sale_return_report(Request $request)
    {
    	if ($request->ajax()) {
    		$sdate =$request->sdate;
    		$edate =$request->edate;
    		$models = Transaction::where('transaction_type', 'sale_return')->where('date', '>=', $sdate)->where('date', '<=', $edate)->get();
    		return view('admin.report.sales.get_sale_return_report',compact('models','sdate','edate'));
    	}
    }


    public function category_sale()
    {
    	$categories =Category::all();
    	return view('admin.report.sales.category_sale',compact('categories'));
    }

    public function get_category_sale_report(Request $request)
    {
    	$category_id =$request->category_id;
        if($category_id != 'all'){
            $categories = Category::where('id', $category_id)->get();
            $category = Category::where('id', $category_id)->first();
        }else{
            $categories = Category::all();
        }

        $data = [];
        $total_profit = 0;

        foreach($categories as $category){
        	   if ($category->products->count() == 0) {
                $data[$category->id] = [
                    'name' => $category->category_name,
                    'quantity' => '-',
                    // 'product' => '-',
                ];
                continue;
            }

            $products = 0;
            $quantity = 0;
            foreach($category->products as $product){
                $productSell = $product->sale_line()->get();
                foreach($productSell as $sell){
                    $mrp = $sell->total;
                    $quantity += $sell->quantity;
                    // $products=$product->product_name;
                }
            }


            $data[$category->id] = [
                'name' => $category->category_name,
                'quantity' => $quantity,
                // 'products'=>$products,
            ];
           
            unset($quantity);

        }

       return view('admin.report.sales.get_category_sale_report',compact('data'));

    }


    public function brand_sale()
    {
    	$brands =Brand::all();
    	return view('admin.report.sales.brand_sale',compact('brands'));
    }

    public function get_brand_sale_report(Request $request)
    {
    	$brand_id =$request->brand_id;
        if($brand_id != 'all'){
            $brands = Brand::where('id', $brand_id)->get();
            $brand = Brand::where('id', $brand_id)->first();
        }else{
            $brands = Brand::all();
        }

        $data = [];
        $total_profit = 0;

        foreach($brands as $brand){
        	   if ($brand->products->count() == 0) {
                $data[$brand->id] = [
                    'name' => $brand->brand_name,
                    'quantity' => '-',
                    'qty' => '-',
                    // 'product' => '-',
                ];
                continue;
            }

            $products = 0;
            $quantity = 0;
            $qty = 0;
            foreach($brand->products as $product){
                $productSell = $product->sale_line()->get();
                $productPurchase = $product->purchase()->get();
                foreach($productSell as $sell){
                    $mrp = $sell->total;
                    $quantity += $sell->quantity;
                    // $products=$product->product_name;
                }

                 foreach($productPurchase as $purchase){
                    $mrp = $purchase->line_total;
                    $qty += $purchase->qty;
                    // $products=$product->product_name;
                }
            }


            $data[$brand->id] = [
                'name' => $brand->brand_name,
                'quantity' => $quantity,
                'qty'=>$qty,
                // 'products'=>$products,
            ];
           
            unset($quantity);

        }

        return view('admin.report.sales.get_brand_sale_report',compact('data'));
    }
}
