<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Products\TaxRate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaxRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.tax.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable() {
        if (request()->ajax()) {
            $ips = TaxRate::all();

			return DataTables::of($ips)
                ->addIndexColumn()
                ->editColumn('date', function($model){
                    return formatDate($model->created_at);
                })
                ->editColumn('rules', function($model){
                    return ($model->tax_rules == 'plus' ? '<span class="text-success">Addition</span>' : '<span class="text-warning">Parcentage</span>');
                })
                ->editColumn('status', function($model){
                    if($model->status == 1) {
                        return '<span class="badge badge-primary">Active</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($model) {
                    return view('admin.product.tax.action', compact('model'));
                })
				->rawColumns(['date', 'status', 'action', 'rules'])->make(true);
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
            'tax_name' => 'required',
            'tax_rate' => 'required|numeric',
            'tax_rules' => 'required',
            'status' => 'required',
        ]);

        $model = new TaxRate;
        $model->tax_name = $request->tax_name;
        $model->tax_code_name = $request->tax_code_name;
        $model->tax_rate = $request->tax_rate;
        $model->tax_rules = $request->tax_rules;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('Created a Tax - ' . $request->tax_name .'.');

        return response()->json(['status' => 'success', 'message' => 'New Tax is stored successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $model = TaxRate::findOrFail($id);
       return view('admin.product.tax.edit', compact('model'));
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
            'tax_name' => 'required',
            'tax_rules' => 'required',
            'tax_rate' => 'required|numeric',
            'status' => 'required',
        ]);

        $model = TaxRate::findOrFail($id);
        $model->tax_name = $request->tax_name;
        $model->tax_code_name = $request->tax_code_name;
        $model->tax_rate = $request->tax_rate;
        $model->tax_rules = $request->tax_rules;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('Updated a Tax - ' . $request->tax_name .'.');

        return response()->json(['status' => 'success', 'message' => 'Tax is updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = TaxRate::findOrFail($id);
        $model->delete();
        
        \SadikLog::addToLog('Deleted a Tax - ' . $model->tax_name .'.');

        return response()->json(['status' => 'success', 'message' => 'Tax is deleted successfully']);
    }
}
