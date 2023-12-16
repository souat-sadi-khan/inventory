<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use App\Models\Admin\Account;
use App\Models\Admin\FixedAsset;
use App\Models\Admin\FixedAssetsCategory;
use App\Models\SadikLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class FixedAssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $models = FixedAssetsCategory::all();
        return view('admin.vaucher.fixed-assets.index');
    }

    public function datatable()
    {

        if (request()->ajax()) {
            $ips = FixedAsset::all();

            return Datatables::of($ips)
                ->addIndexColumn()
                ->editColumn('name', function ($model) {
                    return '<strong class="h5">' . $model->category->name. '</strong> <span class="text-muted text-sm">'. $model->product_name.'</span>';
                })
                ->addColumn('action', function ($model) {
                    return view('admin.vaucher.fixed-assets.action', compact('model'));
                })
                ->rawColumns(['name', 'action'])->make(true);
        }
    }


    public function add_category()
    {
        return view('admin.vaucher.fixed-assets.category');
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'assets_category' => 'required',
        ]);

        $model = new FixedAssetsCategory();
        $model->name = $request->assets_category;
        $model->save();

        \SadikLog::addToLog('Created a Assets Category - ' . $request->name . '.');

        return response()->json(['status' => 'success', 'id' => $model->id, 'text' => $model->name, 'message' => 'New Assets Category is stored successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'category' => 'required',
            'product_name' => 'required',
            'cost' => 'required',
            'qty' => 'required',
        ]);

        $model = new FixedAsset();
        $model->category_id = $request->category;
        $model->product_name = $request->product_name;
        $model->details = $request->details;
        $model->cost = $request->cost;
        $model->qty = $request->qty;
        $model->total = $request->total;
        $model->depreciation = $request->depreciation;
        $model->save();

        \SadikLog::addToLog('Created a Fixed Assets - ' . $request->product_name . '.');

        return response()->json(['status' => 'success', 'message' => 'New Fixed Assets is stored successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = FixedAsset::findOrFail($id);
        return view('admin.vaucher.fixed-assets.edit', compact('model'));
    }

    public function category_edit($id)
    {
        $model = FixedAssetsCategory::find($id);
        return view('admin.vaucher.fixed-assets.category-edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function category_update(Request $request)
    {
        $request->validate([
            'category' => 'required',
        ]);
        $model = FixedAssetsCategory::find($request->id);
        $model->name = $request->category;
        $model->save();

        \SadikLog::addToLog('Update a Fixed Assets - ' . $request->category . '.');

        return response()->json(['status' => 'success', 'message' => 'Fixed Assets Category is Updated successfully']);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
            'product_name' => 'required',
            'cost' => 'required',
            'qty' => 'required',
        ]);
        $model = FixedAsset::findOrFail($id);
        $model->category_id = $request->category;
        $model->product_name = $request->product_name;
        $model->details = $request->details;
        $model->cost = $request->cost;
        $model->qty = $request->qty;
        $model->total = $request->total;
        $model->depreciation = $request->depreciation;
        $model->save();

        \SadikLog::addToLog('Created a Fixed Assets - ' . $request->product_name . '.');

        return response()->json(['status' => 'success', 'message' => 'Fixed Assets is Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
