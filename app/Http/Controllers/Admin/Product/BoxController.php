<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Products\Box;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.box.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable() {
        if (request()->ajax()) {
            $ips = Box::all();

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
                    return view('admin.product.box.action', compact('model'));
                })
				->rawColumns(['products', 'date', 'status', 'action'])->make(true);
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
            'box_name' => 'required',
            'status' => 'required',
        ]);

        $model = new Box;
        $model->box_name = $request->box_name;
        $model->box_code_name = $request->box_code_name;
        $model->status = $request->status;
        $model->box_details = $request->box_details;
        $model->save();

        \SadikLog::addToLog('Created a Product Box - ' . $request->box_name .'.');

        return response()->json(['status' => 'success', 'message' => 'New Box is stored successfully']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Box::findOrFail($id);
        return view('admin.product.box.edit', compact('model'));
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
            'box_name' => 'required',
            'status' => 'required',
        ]);

        $model = Box::findOrFail($id);
        $model->box_name = $request->box_name;
        $model->box_code_name = $request->box_code_name;
        $model->status = $request->status;
        $model->box_details = $request->box_details;
        $model->save();

        \SadikLog::addToLog('Updated a Product Box - ' . $request->box_name .'.');

        return response()->json(['status' => 'success', 'message' => ' Box is updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Box::findOrFail($id);
        $model->delete();

        \SadikLog::addToLog('Deleted a Product Box - ' . $model->box_name .'.');

        return response()->json(['status' => 'success', 'message' => ' Box is deleted successfully']);
    }
}
