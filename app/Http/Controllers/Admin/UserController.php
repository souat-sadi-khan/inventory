<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        authorize(['user.view', 'user.create']);
        if (request()->ajax()) {
            $users = User::all()->except(1);
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return view('admin.user.action', compact('model'));
                })
                ->addColumn('role', function ($model) {
                    return $role_name = getUserRoleName($model->id);
                })
                ->editColumn('status', function ($model) {

                    return view('admin.user.status', compact('model'));
                })
                ->rawColumns(['action', 'status'])->make(true);

        }
      $roles = Role::all()->except(1);

      return view('admin.user.index',compact('roles'));
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
        authorize(['user.create'], true);
            $validator = $request->validate([
                'name' => 'required', 'max:255',
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $user = new User;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->active = 1;

        if($request->hasFile('image')) {

            $data = getimagesize($request->file('image'));
            $width = $data[0];
            $height = $data[0];

            if($width > 1900 && $height > 1900) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Image Width and height is wrong']);
            }

            $storagepath = $request->file('image')->store('public/images/user');
            $fileName = basename($storagepath);

            $model->image = $fileName;
         }
            $user->save();

            $role_id = $request->input('role');
            $role = Role::findOrFail($role_id);
            $user->assignRole($role->name);

            return response()->json(['success' => true, 'status' => 'success', 'message' => __('User Created')]);
    }



        // User Status Change
    public function status(Request $request, $value, $id) {
        // Check Unauthorized Action
        if (!auth()->user()->can('user.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $user = User::find($id);
            $user->active = $value;
            $user->save();

            return response()->json(['success' => true, 'status' => 'success', 'message' => __('Status Updated')]);
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
        authorize(['user.create']);
        $model = User::find($id);
        $roles = Role::all()->except(1);
        return view('admin.user.edit', compact('model', 'roles'));
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
        authorize(['user.create'], true);
            $user = User::findOrFail($id);
            $validator = $request->validate([

                'name' => ['required', 'max:255'],
                'username' => ['required', 'string', 'max:255',
                    Rule::unique('users', 'username')->ignore($user->id)],
                'email' => ['required', 'string', 'email', 'max:255',
                    Rule::unique('users', 'email')->ignore($user->id)],

            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->active = 1;
         if($request->hasFile('image')) {

        if ($user->image) {
          $file_path = "public/images/user" . $user->image;
           Storage::delete($file_path);
          }

            $data = getimagesize($request->file('image'));
            $width = $data[0];
            $height = $data[0];

            if($width > 1900 && $height > 1900) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Image Width and height is wrong']);
            }

            $storagepath = $request->file('image')->store('public/images/user');
            $fileName = basename($storagepath);

            $user->image = $fileName;
         }
          else {
           $fileName= $user->image;
           $user->image = $fileName;
          }
            $user->save();

            $role_id = $request->input('role');
            $user_role = $user->roles->first();

            if ($user_role->id != $role_id) {
                $user->removeRole($user_role->name);

                $role = Role::findOrFail($role_id);
                $user->assignRole($role->name);
            }


            return response()->json(['success' => true, 'status' => 'success', 'message' => __('User Updated')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        authorize(['user.delete']);
        if (request()->ajax()) {
            $model = User::find($id);
            if ($model->image) {
            unlink('public/images/user/'.$model->image);
            }
            $user_role = $model->roles->first();
            $model->removeRole($user_role->name);
            $model->delete();

            return response()->json(['status' => 'success', 'message' => 'User  Delete successfully']);
        }
    }
}
