<?php

namespace App\Http\Controllers\Admin\vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\Vehicle;
use App\Models\Vehicle\VehicleTransaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VehicleTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Vehicle::where('status', 'Active')->get();
        return view('admin.vehicle.transaction.index', compact('models'));
    }

    public function datatable()
    {

        if (request()->ajax()) {

            $models = VehicleTransaction::with('truck')->get();

            return DataTables::of($models)
                ->addIndexColumn()

                ->editColumn('vehicle', function ($model) {
                    $type = $model->truck->type->name;
                    $name = $model->truck->name;
                    return $name . ' ('. $type .')';
                })

                ->editColumn('action', function ($model) {
                    return view('admin.vehicle.transaction.action', compact('model'));
                })
                ->rawColumns(['vehicle', 'action'])->make(true);
        }
    }



    public function data(Request $request)
    {
        $vehicle = Vehicle::where('status', 'Active')->find($request->vehicle_id);
        $description = $request->description;
        $amount = $request->amount;
        $date = $request->date;
        $type = $request->type;
        return view('admin.vehicle.transaction.itemlist', compact('vehicle', 'description', 'date', 'amount', 'type'));
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
        if ($request->vehicle_id != null) {

            $count = count($request->vehicle_id);

            for ($i = 0; $i < $count; $i++) {

                $data = new VehicleTransaction;
                $data['type'] = $request->type[$i];
                $data['vehicle_id'] = $request->vehicle_id[$i];
                $data['description'] = $request->description[$i];
                $data['amount'] = $request->amount[$i];
                $data['date'] = $request->date[$i];
                $data->save();

            }

            \SadikLog::addToLog('Vehicle Transaction - ');

            return response()->json(['status' => 'success', 'message' => 'Save successfully']);
        } else {
            return response()->json(['status' => 'danger', 'message' => 'Please Added Data First']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = Vehicle::where('status', 'Active')->get();
        $data = VehicleTransaction::findOrFail($id);
        return view('admin.vehicle.transaction.edit', compact('data', 'vehicle'));
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
            'vehicle_id' => 'required',
            'type' => 'required',
            'amount' => 'required',
        ]);


        $model = VehicleTransaction::findOrFail($id);
        $model->vehicle_id = $request->vehicle_id;
        $model->type = $request->type;
        $model->amount = $request->amount;
        $model->description = $request->description;
        $model->date = $request->date;
        $model->save();

        \SadikLog::addToLog('Update a Vehicle Transaction - ');

        return response()->json(['status' => 'success', 'message' => 'Vehicle Transaction is Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = VehicleTransaction::findOrFail($id);
        $model->delete();

        \SadikLog::addToLog('Deleted a Vehicle Transaction - ');

        return response()->json(['status' => 'success', 'message' => 'Vehicle Transaction is deleted successfully']);
    }
}
