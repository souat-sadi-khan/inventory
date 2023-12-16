<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Products\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.unit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable() {
        if (request()->ajax()) {
            $ips = Unit::all();

			return DataTables::of($ips)
                ->addIndexColumn()
                ->editColumn('products', function($model){
                    return 0;
                })
                ->editColumn('date', function($model){
                    return formatDate($model->created_at);
                })
                ->editColumn('status', function($model){
                    if($model->status == 1) {
                        return '<span class="badge badge-primary">Active</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($model) {
                    return view('admin.product.unit.action', compact('model'));
                })
				->rawColumns(['action', 'products', 'date', 'status'])->make(true);
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
            'unit_name' => 'required',
            'status' => 'required',
        ]);

        $model = new Unit;
        $model->unit_name = $request->unit_name;
        $model->unit_code_name = $request->unit_code_name;
        $model->unit_details = $request->unit_details;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('Created a Unit - ' . $request->unit_name .'.');

        return response()->json(['status' => 'success', 'message' => 'New Unit is stored successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Unit::findOrFail($id);
        return view('admin.product.unit.edit', compact('model'));
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
            'unit_name' => 'required',
            'status' => 'required',
        ]);

        $model = Unit::findOrFail($id);
        $model->unit_name = $request->unit_name;
        $model->unit_code_name = $request->unit_code_name;
        $model->unit_details = $request->unit_details;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('Updated a Unit - ' . $request->unit_name .'.');

        return response()->json(['status' => 'success', 'message' => 'Unit is updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Unit::findOrFail($id);
        $model->delete();

        \SadikLog::addToLog('Deleted a Unit - ' . $model->unit_name .'.');

        return response()->json(['status' => 'success', 'message' => 'Unit is deleted successfully']);

    }
}
