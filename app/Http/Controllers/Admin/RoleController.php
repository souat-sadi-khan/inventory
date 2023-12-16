<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        authorize(['role.view', 'role.create']);
        $permissions = Permission::all();
        return view('admin.role.index', compact('permissions'));
    }

    // Datatable Data
	public function datatable(Request $request) {
        $roles = Role::where('name', '!=', config('system.default_role.admin'))->where('id', '!=', 1)->get();
        return Datatables::of($roles)
            ->addIndexColumn()
            ->editColumn('edit', function ($model) {
                return '<a href="'.route('admin.user.role.edit',$model->id).'"  class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i></a>';
            })
            ->editColumn('delete', function ($model) {
                return '<button id="delete_item" data-id ="'.$model->id.'" data-url="'. route('admin.user.role.delete',$model->id) .'"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['edit', 'delete'])->make(true);
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
        authorize(['role.create'], true);
        // validate the data coming from form
        $validator = $this->validate($request, [
            'name' => 'required|unique:roles,name|max:255',
        ]);

        // create role & assigned Permission
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
        $role->givePermissionTo($request->permissions);

        // Activity Log
        \SadikLog::addToLog('Created a Role - ' . $request->name .'.');

        return response()->json(['status' => 'success', 'message' => 'New Role is stored successfully']);

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

        authorize(['role.create']);
                // Abort the id number 1
        if ($id == 1) {
            return abort(404);
        }

        // find the role & edit
        $role = Role::with(['permissions'])
            ->find($id);
        $role_permissions = [];
        foreach ($role->permissions as $role_perm) {
            $role_permissions[] = $role_perm->name;
        }

        // sent the role on edit page
        $role = Role::where('id', $id)->firstOrFail();

        $permissions = Permission::all();
        return view('admin.role.edit', compact(['role', 'permissions', 'role_permissions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        authorize(['role.create'], true);
                // Unauthorized Action Check
        if (!auth()->user()->can('role.update')) {
            abort(403, 'Unauthorized action.');
        }

        // find the role columd
        $role = Role::where('id', $request->id)->firstOrFail();

        // Check the validation
        $validator = $request->validate([
            'name' => ['required', 'max:255',
                Rule::unique('roles', 'name')->ignore($role->id)],
        ]);
        // dd($request->permissions);
        // Update the roll & permission
        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permissions);

        // Activity Log

        return response()->json(['success' => true, 'status' => 'success', 'message' => __('Role And Permission Updated'), 'goto' => route('admin.user.role')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        authorize(['role.delete'], true);
        // Check Unauthorized Action
		if (!auth()->user()->can('role.delete')) {
			abort(403, 'Unauthorized action.');
		}

		if (request()->ajax()) {
			// Find the role & delete
			$role = Role::where('id', $id)->firstOrFail();
			$role->delete();

			// Activity Log
			\SadikLog::AddToLog('Deleted a role - '. $role->name);

            return response()->json(['status' => 'success', 'message' => 'Role is deleted successfully']);

		}
    }
}
