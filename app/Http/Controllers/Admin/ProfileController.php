<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Rules\MatchOldPassword;
use App\UserInformation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index() {
        $id = Auth::user()->id;
        $model = User::where('id', $id)->with('info')->first();
        return view('admin.profile.index', compact('model'));
    }

    // datatable
    public function datatable() {
        if (request()->ajax()) {
            $models = \SadikLog::logActivityLists();
			return Datatables::of($models)
                ->addIndexColumn()
                ->editColumn('url', function($model){
                    return '<sapn class="text-success">'. $model->url . '</span>';
                })
                ->editColumn('method', function($model){
                    return ($model->method == 'GET' ? '<span class="badge badge-info">GET</span>' : '<span class="badge badge-danger">POST</span>' ) ;
                })
                ->editColumn('ip', function($model){
                    return '<sapn class="text-warning">'. $model->ip . '</span>';
                })
                ->editColumn('agent', function($model){
                    return '<sapn class="text-danger">'. $model->agent . '</span>';
                })
                ->editColumn('user_id', function($model){
                    return '<sapn>'. $model->user->username . '</span>';
                })
				->rawColumns(['url', 'method', 'ip', 'agent', 'user_id'])->make(true);

		}
    }

    // changepassword
    public function changepassword(Request $request) {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return response()->json(['status' => 'success', 'message' => 'Password is Successfully Changed']);
    }

    // changesocial
    public function changesocial(Request $request) {
        $user_id = Auth::user()->id;

        $user = UserInformation::where('user_id', $user_id)->first();
        $user->facebook_link = $request->facebook_link;
        $user->twitter_link = $request->twitter_link;
        $user->skype_link = $request->skype_link;
        $user->website_link = $request->website_link;
        $user->save();
        return response()->json(['status' => 'success', 'message' => 'Data Updated Successfully', 'load'=> true]);
    }

    // changeother 
    public function changeother (Request $request) {

        $user = UserInformation::where('user_id', Auth::user()->id)->first();
        if($request->hasFile('image')) {

            request()->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
            $model = User::findOrFail(Auth::user()->id);
            $storagepath = $request->file('image')->store('public/images/user');
            $fileName = basename($storagepath);

            $model->image = $fileName;

            //if file chnage then delete old one
            $oldFile = $request->get('old_image','');
            if( $oldFile != ''){
                $file_path = "public/images/user/".$oldFile;
                Storage::delete($file_path);
            }

            $model->save();
        }

        $note = $request->notes;
        $education = $request->education;

        if($user) {
            $user->notes = $note;
            $user->education = $education;
            $user->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Data Updated Successfully', 'load'=> true]);

    }

    // personal_info_change
    public function personal_info_change(Request $request) {
        $id = Auth::user()->id;

        $user = UserInformation::where('user_id', $id)->first();
        
        $model = User::where('id', $id)->first();
        $model->name = $request->name;
        $model->save();
        
        
        $user->birth_date = $request->birth_date;
        $user->gender = $request->gender;
        $user->marital_status = $request->marital_status;
        $user->present_address = $request->present_address;
        $user->present_additional_address = $request->present_additional_address;
        $user->present_city = $request->present_city;
        $user->present_postcode = $request->present_postcode;
        $user->present_state = $request->present_state;
        $user->present_country = $request->present_country;

        if($request->present_as_per == 'on') {
            $user->parmanent_address = $request->present_address;
            $user->parmanent_additional_address = $request->present_additional_address;
            $user->parmanent_city = $request->present_city;
            $user->parmanent_postcode = $request->present_postcode;
            $user->parmanent_state = $request->present_state;
            $user->parmanent_country = $request->present_country;
        } else {
            $user->parmanent_address = $request->parmanent_address;
            $user->parmanent_additional_address = $request->parmanent_additional_address;
            $user->parmanent_city = $request->parmanent_city;
            $user->parmanent_postcode = $request->parmanent_postcode;
            $user->parmanent_state = $request->parmanent_state;
            $user->parmanent_country = $request->parmanent_country;
        }

        $user->save();
        return response()->json(['status' => 'success', 'message' => 'Data Updated Successfully', 'load'=> true]);

    }
}
