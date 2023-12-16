<?php

namespace App\Http\Controllers\Admin\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\Vehicle;
use App\Models\Vehicle\VehicleTransaction;
use App\Models\Vehicle\VehicleType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Session;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = VehicleType::where('status','Active')->get();
        return view('admin.vehicle.vehicle.index',compact('models'));
    }

    public function datatable()
    {

        if (request()->ajax()) {

            $models = Vehicle::with('type')->get();

            return DataTables::of($models)
                ->addIndexColumn()

                ->editColumn('vehicle_type_id', function ($model) {
                    // dd($model);
                    return $model->type->name;
                })
                ->editColumn('status', function ($model) {
                    if ($model->status == 'Active') {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })

                ->editColumn('action', function ($model) {
                    return view('admin.vehicle.vehicle.action', compact('model'));
                })
                ->rawColumns(['vehicle_type_id','status', 'action'])->make(true);
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
            'vehicle_type_id' => 'required',
            'regi_no' => 'required',
            'model_no' => 'required',
            'investment' => 'required',
        ]);

        $model = new Vehicle;
        $model->name = $request->name;
        $model->vehicle_type_id = $request->vehicle_type_id;
        $model->regi_no = $request->regi_no;
        $model->chassis_no = $request->chassis_no;
        $model->model_no = $request->model_no;
        $model->engine_no = $request->engine_no;
        $model->road_permit = $request->road_permit;
        $model->license_no = $request->license_no;
        $model->license_validity = $request->license_validity;
        $model->investment = $request->investment;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('Created a Vehicle -');

        return response()->json(['status' => 'success', 'message' => 'New Vehicle is stored successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Vehicle::with('invest')->findOrFail($id);
        $income = VehicleTransaction::where('type','Income')->sum('amount');
        $expence = VehicleTransaction::where('type', 'Expence')->sum('amount');
        $balance = $income - ($model->investment + $expence);

        // $trans = VehicleTransaction::where('type', 'Income')->get();
        return view('admin.vehicle.vehicle.show', compact('model','income', 'expence','balance'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $types = VehicleType::where('status', 'Active')->get();
        $model = Vehicle::findOrFail($id);
        return view('admin.vehicle.vehicle.edit', compact('model','types'));
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
            'vehicle_type_id' => 'required',
            'regi_no' => 'required',
            'model_no' => 'required',
            'investment' => 'required',
        ]);

        $model = Vehicle::findOrFail($id);
        $model->vehicle_type_id = $request->vehicle_type_id;
        $model->name = $request->name;
        $model->regi_no = $request->regi_no;
        $model->chassis_no = $request->chassis_no;
        $model->model_no = $request->model_no;
        $model->engine_no = $request->engine_no;
        $model->road_permit = $request->road_permit;
        $model->license_no = $request->license_no;
        $model->license_validity = $request->license_validity;
        $model->investment = $request->investment;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('Update a Vehicle - ');

        return response()->json(['status' => 'success', 'message' => 'Vehicle is Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Vehicle::findOrFail($id);
        $model->delete();

        \SadikLog::addToLog('Deleted a Vehicle - ');

        return response()->json(['status' => 'success', 'message' => 'Vehicle is deleted successfully']);
    }



    // Report


    public function report_income(Request $request)
    {
        $vehicles = Vehicle::where('status', 'Active')->get();
        return view('admin.report.vehicle-ie', compact('vehicles'));
    }

    public function vehicle_income_show(Request $request)
    {
        if ($request->ajax()) {
            $sdate = $request->sdate;
            $edate = $request->edate;
            $vehicle = $request->vehicle;
            if ($vehicle) {
                $vehicle = $request->vehicle;
            } else {
                $vehicle = 'all';
            }
            $vehicle_name = '';

            if (!empty($sdate) && !empty($edate) && !empty($vehicle)) {

                if ($vehicle == 'all') {
                    $total_income = VehicleTransaction::whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Income')->get();
                    $total_expence = VehicleTransaction::whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Expence')->get();
                } else {
                    $vehicle_name =  Vehicle::findOrFail($vehicle);
                    $total_income = VehicleTransaction::where('vehicle_id', $vehicle)->whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Income')->get();
                    $total_expence = VehicleTransaction::where('vehicle_id', $vehicle)->whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Expence')->get();
                }
            } else {
                $total_income = VehicleTransaction::where('type', 'Income')->get();
                $total_expence = VehicleTransaction::where('type', 'Expence')->get();
            }

            return view('admin.report.vehicle-income-show', compact( 'total_income', 'total_expence', 'vehicle_name'));
        }
        return view('admin.report.vehicle-income');
    }




    public function report(Request $request)
    {
        $vehicles = Vehicle::where('status', 'Active')->get();
        return view('admin.report.vehicle', compact('vehicles'));
    }

    public function vehicle_show_income($id)
    {
        $sdate = Session::get('sdate');
        $edate = Session::get('edate');
        $type = 'Income';

        if ($sdate and $edate) {
            if ($id = 'all') {
                $total_income = VehicleTransaction::whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Income')->get();
            } else {
                $total_income = VehicleTransaction::where('vehicle_id', $id)->whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Income')->get();
            }
        }else{
            if ($id = 'all') {
                $total_income = VehicleTransaction::where('type', 'Income')->get();
            } else {
                $total_income = VehicleTransaction::where('vehicle_id', $id)->where('type', 'Income')->get();
            }
        }

        return view('admin.report.vehicle-income', compact('total_income','type'));
    }


    public function vehicle_show_expence($id)
    {
        $sdate = Session::get('sdate');
        $edate = Session::get('edate');
        $type = 'Expence';

        if ($sdate and $edate) {
            if ($id = 'all') {
                $total_income = VehicleTransaction::whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Expence')->get();
            } else {
                $total_income = VehicleTransaction::where('vehicle_id', $id)->whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Expence')->get();
            }
        } else {
            if ($id = 'all') {
                $total_income = VehicleTransaction::where('type', 'Expence')->get();
            } else {
                $total_income = VehicleTransaction::where('vehicle_id', $id)->where('type', 'Expence')->get();
            }
        }

        return view('admin.report.vehicle-income', compact('total_income', 'type'));
    }


    public function vehicle_show(Request $request)
    {
        if ($request->ajax()) {
            $sdate = $request->sdate;
            $edate = $request->edate;
            $vehicle = $request->vehicle;
            if ($vehicle) {
                $vehicle = $request->vehicle;
            }else{
                $vehicle = 'all';
            }

            $request->session()->put('sdate', $sdate);
            $request->session()->put('edate', $edate);

            if (!empty($sdate) && !empty($edate)&& !empty($vehicle)) {

                if ($vehicle == 'all') {
                    $total_investment = Vehicle::sum('investment');
                    $total_income = VehicleTransaction::whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Income')->sum('amount');
                    $total_expence = VehicleTransaction::whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Expence')->sum('amount');
                    $balance = $total_income - ($total_investment + $total_expence);
                }else{
                    $total_investment = Vehicle::where('id', $vehicle)->sum('investment');
                    $total_income = VehicleTransaction::where('vehicle_id', $vehicle)->whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Income')->sum('amount');
                    $total_expence = VehicleTransaction::where('vehicle_id', $vehicle)->whereBetween(DB::raw('date(date)'), [$sdate, $edate])->where('type', 'Expence')->sum('amount');
                    $balance = $total_income - ($total_investment + $total_expence);
                }

            }else{
                $total_investment = Vehicle::sum('investment');
                $total_income = VehicleTransaction::where('type', 'Income')->sum('amount');
                $total_expence = VehicleTransaction::where('type', 'Expence')->sum('amount');
                $balance = $total_income -($total_investment + $total_expence);
            }

            return view('admin.report.vehicle-show', compact('total_investment', 'total_income', 'total_expence', 'balance' , 'vehicle'));
        }
        return view('admin.report.vehicle');
    }
 
}
