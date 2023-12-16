<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LoanPayment;
use Illuminate\Support\Facades\Storage;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.loan.index');
    }

    public function datatable() {
        if (request()->ajax()) {
            $ips = Loan::all();

			return Datatables::of($ips)
                ->addIndexColumn()
                ->editColumn('date', function($model){
                    return formatDate($model->date);
                })
                ->editColumn('amount', function($model){
                    return get_option('currency_symbol'). ' '. number_format($model->amount, 2);
                })
                ->editColumn('interest', function($model){
                    return $model->interest.'%';
                })
                ->editColumn('paid', function($model){
                    $payable = $model->payable;
                    $due = $model->due;
                    if($due == NULL) {
                        $due = 0;
                    }

                    $paid = $payable - $due;
                    return '<span class="text-success">'. get_option('currency_symbol'). ''. number_format($paid, 2). '</span>';
                })
                ->editColumn('due', function($model){
                    $due = $model->due;
                    if($due == NULL) {
                        $due = 0;
                    }
                    return '<span class="text-danger">'. get_option('currency_symbol') . ''. number_format($due, 2). '</span>';
                })
                ->addColumn('action', function ($model) {
                    return view('admin.loan.action', compact('model'));
				})
				->rawColumns(['interest', 'amount', 'date', 'paid', 'due', 'action'])->make(true);

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
        $request->validate([
            'date' => 'required',
            'loan_from' => 'required',
            'title' => 'required',
            'amount' => 'required',
            'interest' => 'required',
            'payable' => 'required',
            'attatchment' => 'mimes:jpeg,jpg,png,pdf,doc,docx|max:5000'
        ]);

        // $date = Helper::formatDate($request->date);

        $model = new Loan;
        $model->date = $request->date;
        $model->loan_from = $request->loan_from;
        $model->ref_no = $request->ref_no;
        $model->title = $request->title;
        $model->amount = $request->amount;
        $model->interest = $request->interest;
        $model->payable = $request->payable;
        $model->due = $request->payable;
        $model->details = $request->details;
        $model->created_by = auth()->user()->id;

        $fileName="";
        if($request->hasFile('attatchment')) {
            $storagepath = $request->file('attatchment')->store('public/file/loan');
            $fileName = basename($storagepath);
            $model->attatchment = $fileName;
        }

        $model->save();

        \SadikLog::addToLog('Created a Loan - ' . $request->title .'.');

        return response()->json(['status' => 'success', 'message' => 'New Loan is stored successfully']);

    }

    public function pay($id) {
        $model = Loan::findOrFail($id);
        return view('admin.loan.pay', compact('model'));
    }

    public function pay_amount(Request $request) {
        $request->validate([
            'paid' => 'required',
            'loan_id' => 'required',
        ]);

        $loan = Loan::findOrFail($request->loan_id);
        $payable = $loan->payable;
        $due = $loan->due;

        if($request->paid > $due) {
            return response()->json(['status' => 'danger', 'message' => 'Paid Amount is Greater then Due Amount']);
        }

        $paid = $due - $request->paid;
        $new_due = $paid;
        $loan->due = $new_due;
        $loan->save();

        $model = new LoanPayment;
        $model->loan_id = $request->loan_id;
        $model->ref_no = $request->ref_no;
        $model->paid = $request->paid;
        $model->note = $request->note;
        $model->created_by = auth()->user()->id;
        $model->save();

        \SadikLog::addToLog('Pay a Loan - ' . $loan->title .'.');


        return response()->json(['status' => 'success', 'message' => 'New Loan Payment is stored successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Loan::findOrFail($id);
        return view('admin.loan.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Loan::findOrFail($id);
        return view('admin.loan.edit', compact('model'));
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
        $request->validate([
            'loan_from' => 'required',
            'ref_no' => 'required',
            'title' => 'required',
            'amount' => 'required',
            'interest' => 'required',
            'payable' => 'required',
        ]);

        $model = Loan::findOrFail($id);
        $model->loan_from = $request->loan_from;
        $model->ref_no = $request->ref_no;
        $model->title = $request->title;
        $model->amount = $request->amount;
        $model->interest = $request->interest;
        $model->payable = $request->payable;

        $fileName="";
        if($request->hasFile('attatchment')) {
            $storagepath = $request->file('attatchment')->store('public/file/loan');
            $fileName = basename($storagepath);

            //if file chnage then delete old one
            $oldFile = $request->get('old_attatchment','');
            if( $oldFile != ''){
                $file_path = "public/file/loan/".$oldFile;
                Storage::delete($file_path);
            }
            $model->attatchment = $fileName;
        }
        $model->save();

        \SadikLog::addToLog('Updated a Loan - ' . $request->title .'.');

        return response()->json(['status' => 'success', 'message' => 'Loan is updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete the loan payment
        $items = LoanPayment::where('loan_id', $id)->get();
        foreach($items as $item) {
            $item->delete();
        }

        // delete The Loan
        $model = Loan::findOrFail($id);
        $model->delete();

        \SadikLog::addToLog('Deleted a Loan - ' . $model->title .'.'); 

        return response()->json(['status' => 'success', 'message' => 'Loan is deleted successfully']);
    }

    public function summery() {
        $total = Loan::sum('payable');
        $due = Loan::sum('due');
        $paid = $total - $due;

        return view('admin.loan.summery', compact('total', 'paid', 'due'));
    }

    public function summaryDatatable() {
        if (request()->ajax()) {
            $ips = Loan::all();

			return Datatables::of($ips)
                ->addIndexColumn()
                ->editColumn('date', function($model){
                    return formatDate($model->date);
                })
                ->editColumn('amount', function($model){
                    return get_option('currency_symbol'). ' '. number_format($model->amount, 2);
                })
                ->editColumn('interest', function($model){
                    return $model->interest.'%';
                })
                ->editColumn('paid', function($model){
                    $payable = $model->payable;
                    $due = $model->due;
                    if($due == NULL) {
                        $due = 0;
                    }

                    $paid = $payable - $due;
                    return '<span class="text-success">'. get_option('currency_symbol'). ''. number_format($paid, 2). '</span>';
                })
                ->editColumn('due', function($model){
                    $due = $model->due;
                    if($due == NULL) {
                        $due = 0;
                    }
                    return '<span class="text-danger">'. get_option('currency_symbol') . ''. number_format($due, 2). '</span>';
                })
				->rawColumns(['interest', 'amount', 'date', 'paid', 'due'])->make(true);
		}
    }
}
