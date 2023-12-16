<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use App\Models\Admin\Account;
use App\Models\Admin\AccountTransaction;
use App\Models\SadikLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        authorize(['account.create', 'account.view']);
        return view('admin.account.index');
    }

    public function datatable()
    {

        if (request()->ajax()) {

            $models = Account::groupBy('category')
                    ->selectRaw('id, count(*) as total, category');


            return Datatables::of($models)
                ->addIndexColumn()

                ->editColumn('category', function ($model) {
                    return toWord($model->category);
                })

                ->addColumn('count', function ($model) {

                   return $model->total;
                })

                ->editColumn('action', function ($model) {
                    return view('admin.account.action', compact('model'));
                })
                ->rawColumns(['category,action'])->make(true);
        }
    }



    public function table($id)
    {
        if (request()->ajax()) {
            $ips = Account::where('category',$id)->get();

            return Datatables::of($ips)
                ->addIndexColumn()
                ->editColumn('amount', function ($model) {
                    $debit = $model->account->where('type',"Debit")->sum('amount');
                    $credit = $model->account->where('type',"Credit")->sum('amount');
                    $data = dabit_credit($debit , $credit);
                    return $data;
                })
                ->editColumn('status', function ($model) {
                    if ($model->status == 'Active') {
                        $output = '<span class="badge badge-success">Active</span>';
                    } else {
                        $output = '<span class="badge badge-danger">InActive</span>';
                    }

                    return $output;
                })

                ->editColumn('action', function ($model) {
                    return view('admin.account.account-action', compact('model'));
                })

                ->rawColumns(['status','action', 'amount'])->make(true);
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
        authorize(['account.view'], true);
            $request->validate([
                'category' => 'required',
                'account_name' => 'required',
            ]);

        $model = new Account;
        $model->category = $request->category;
        $model->name = $request->account_name;
        $model->display_name = $request->display_name;
        $model->alias = $request->alias;
        $model->phone = $request->phone;
        $model->email = $request->email;
        $model->salary = $request->salary;
        $model->address = $request->address;
        $model->account_no = $request->account_no;
        $model->check_form = $request->check_form;
        $model->check_to = $request->check_to;
        $model->opening_date = $request->opening_date;
        $model->is_liabilities = check_liabilities($request->category);
        $model->status = 'Active';
        $model->save();

        \SadikLog::addToLog('Created a Account - ' . $request->account_name . '.');

        return response()->json(['status' => 'success', 'message' => 'New Account is stored successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        authorize(['account.view']);
        return view('admin.account.table', compact('id'));
    }

    public function show_data($id)
    {
        $model = Account::with('account')->findOrFail($id);
        return view('admin.account.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        authorize(['account.create']);
        $model = Account::findOrFail($id);
        return view('admin.account.edit', compact('model'));
    }

    public function trans_index()
    {
        return view('admin.account.trans-index');
    }
    
    public function trans_edit($id)
    {
        $model = AccountTransaction::findOrFail($id);
        $bank = Account::where('status', 'Active')->get();
        if ($model->sub_type == 'Deposit') {
            return view('admin.account.deposit', compact('model', 'bank'));
        }elseif($model->sub_type == 'Withdraw'){
            return view('admin.account.withdraw', compact('model','bank'));
        }else{
            return view('admin.account.trans-edit', compact('model'));
        }
    }

    public function trans_update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required',
        ]);

        $model = AccountTransaction::findOrFail($id);
        $model->type = $request->type;
        $model->sub_type = $request->sub_type;
        $model->amount = $request->amount;
        $model->reff_no = $request->reff_no;
        $model->operation_date = $request->operation_date;
        $model->note = $request->note;
        $model->save();

        \SadikLog::addToLog('updated a Account Transaction - ');

        return response()->json(['status' => 'success', 'message' => 'Account Transaction updated successfully']);
    }


    public function deposit_update(Request $request, $id)
    {
        $request->validate([
            'bank' => 'required',
            'amount' => 'required',
        ]);

        if ($request->voucher_number) {
            $voucher_number = $request->voucher_number;
        } else {
            $voucher_number = acrandom_num('Deposit');
        }

        if ($request->note) {
            $note = $request->note;
        } else {
            $note = 'Deposit To cash';
        }

        $account = Account::find($request->bank);

        $model = AccountTransaction::findOrFail($id);
        $model->account_id = $request->bank;
        $model->type = check_debit_credit($request->bank);
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $note;
        $model->reff_no = $voucher_number;
        $model->save();

        $model = AccountTransaction::where('parent_id',$id)->first();
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = 'Cash Deposit From ' . $account->name;
        $model->reff_no = $voucher_number;
        $model->save();
        \SadikLog::addToLog('Deposit - ');

        return response()->json(['status' => 'success', 'message' => 'Account Transaction is Update successfully']);
    }


    public function withdraw_update(Request $request, $id)
    {
        $request->validate([
            'bank' => 'required',
            'amount' => 'required',
        ]);

        if ($request->voucher_number) {
            $voucher_number = $request->voucher_number;
        } else {
            $voucher_number = acrandom_num('Withdraw');
        }

        if ($request->note) {
            $note = $request->note;
        } else {
            $note = 'Withdraw To cash';
        }

        $account = Account::find($request->bank);

        $model = AccountTransaction::findOrFail($id);
        $model->account_id = $request->bank;
        $model->type = check_debit_credit($request->bank);
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = $note;
        $model->reff_no = $voucher_number;
        $model->save();

        $model = AccountTransaction::where('parent_id', $id)->first();
        $model->amount = $request->amount;
        $model->operation_date = $request->operation_date;
        $model->note = 'Cash Withdraw to ' . $account->name;
        $model->reff_no = $voucher_number;
        $model->save();
        \SadikLog::addToLog('Withdraw - ');

        return response()->json(['status' => 'success', 'message' => 'Account Transaction is Update successfully']);
    }

    public function trans_destroy($id)
    {
            $model = AccountTransaction::findOrFail($id);
            $model->delete();

            \SadikLog::addToLog('Deleted a Account Transaction - ' . $model->name);

            return response()->json(['status' => 'success', 'message' => 'Account Transaction is deleted successfully']);
    }


    public function trans_datatable()
    {
        if (request()->ajax()) {
            $ips = AccountTransaction::WhereNull('transaction_id')->WhereNull('parent_id')->get();
            return Datatables::of($ips)
                ->addIndexColumn()
                ->editColumn('action', function ($model) {
                    return view('admin.account.account-trans-action', compact('model'));
                })

                ->rawColumns(['action'])->make(true);
        }
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
        authorize(['account.create'], true);
        $request->validate([
            'category' => 'required',
            'account_name' => 'required',
        ]);

        $model = Account::findOrFail($id);
        $model->name = $request->account_name;
        $model->display_name = $request->display_name;
        $model->alias = $request->alias;
        $model->phone = $request->phone;
        $model->email = $request->email;
        $model->salary = $request->salary;
        $model->address = $request->address;
        $model->account_no = $request->account_no;
        $model->check_form = $request->check_form;
        $model->check_to = $request->check_to;
        $model->opening_date = $request->opening_date;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('updated a Account - ' . $request->account_name . '.');

        return response()->json(['status' => 'success', 'message' => 'Account updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        authorize(['account.delete'], true);
        $model = Account::whereNull('is_default')->find($id);
        if ($model == null) {
            throw ValidationException::withMessages(['message' => 'Account Cannot be deleted because This is a Default Account']);
        }else{

            $account_id = $model->id;
            $accounts = AccountTransaction::where('account_id', $account_id)->get();
            if (count($accounts) == 0) {
                foreach ($accounts as $account) {
                    $account->delete();
                }
                $model->delete();
            } else {
                throw ValidationException::withMessages(['message' => 'Account Cannot be deleted because This Account has already Transaction']);
            }

            \SadikLog::addToLog('Deleted a Account - ' . $model->name);

            return response()->json(['status' => 'success', 'message' => 'Account is deleted successfully']);
        }
        
    }
}
