<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use App\TransactionPayment;
use Illuminate\Http\Request;

class PurchaseReportController extends Controller
{
    public function index()
    {
    	return view('admin.report.purchase.index');
    }

    public function purchase()
    {
    	return view('admin.report.purchase.purchase');
    }

    public function get_purchase_report(Request $request)
    {
    	if ($request->ajax()) {
    		$sdate =$request->sdate;
    		$edate =$request->edate;
    		$models = Transaction::where('transaction_type', 'Purchase')->where('date', '>=', $sdate)->where('date', '<=', $edate)->get();
    		return view('admin.report.purchase.get_purchase_report',compact('models','sdate','edate'));
    	}
    }

    public function purchase_payment()
    {
    	return view('admin.report.purchase.purchase_payment');
    }

    public function get_purchasepayment_report(Request $request)
    {
    	$sdate =$request->sdate;
    	$edate =$request->edate;
    	// $model = TransactionPayment::with(['transaction'=>function($q){
    	// 	return $q->where('transaction_type','Sale');
    	// }])->where('payment_date', '>=', $sdate)->where('payment_date', '<=', $edate)->get();
    	$transaction =Transaction::where('transaction_type','Purchase')->get()->pluck('id');
    	$model =TransactionPayment::whereIn('transaction_id',$transaction)->where('payment_date', '>=', $sdate)->where('payment_date', '<=', $edate)->get();
       return view('admin.report.purchase.get_purchasepayment_report',compact('model','sdate','edate'));
    }

     public function purchase_return()
    {
    	return view('admin.report.purchase.purchase_return');
    }

    public function get_purchase_return_report(Request $request)
    {
    	if ($request->ajax()) {
    		$sdate =$request->sdate;
    		$edate =$request->edate;
    		$models = Transaction::where('transaction_type', 'purchase_return')->where('date', '>=', $sdate)->where('date', '<=', $edate)->get();
    		return view('admin.report.purchase.get_purchase_return_report',compact('models','sdate','edate'));
    	}
    }

}
