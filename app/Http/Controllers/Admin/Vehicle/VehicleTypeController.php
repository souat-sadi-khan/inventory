<?php

namespace App\Http\Controllers\Admin\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\VehicleType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.vehicle.vehicle-type.index');
    }

    public function datatable()
    {

        if (request()->ajax()) {

            $models = VehicleType::all();

            return DataTables::of($models)
                ->addIndexColumn()

                ->editColumn('status', function ($model) {
                    if ($model->status == 'Active') {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })

                ->editColumn('action', function ($model) {
                    return view('admin.vehicle.vehicle-type.action', compact('model'));
                })
                ->rawColumns(['status','action'])->make(true);
        }
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
            'name' => 'required',
            'status' => 'required',
        ]);

        $model = new VehicleType;
        $model->name = $request->name;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('Created a Vehicle Type - ' . $request->name . '.');

        return response()->json(['status' => 'success', 'message' => 'New Vehicle Type is stored successfully']);
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
        $model = VehicleType::findOrFail($id);
        return view('admin.vehicle.vehicle-type.edit', compact('model'));
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
            'name' => 'required',
            'status' => 'required',
        ]);

        $model = VehicleType::findOrFail($id);
        $model->name = $request->name;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('Update a Vehicle Type - ' . $request->name . '.');

        return response()->json(['status' => 'success', 'message' => 'Vehicle Type is Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = VehicleType::findOrFail($id);
        $model->delete();

        \SadikLog::addToLog('Deleted a Vehicle Type - ' . $model->name);

        return response()->json(['status' => 'success', 'message' => 'Vehicle Type is deleted successfully']);
    }
}
