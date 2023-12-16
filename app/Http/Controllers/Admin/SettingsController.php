<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function general_settings() {
        authorize(['settings.view']);
        return view('admin.settings.general');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
			'logo' => 'mimes:jpeg,bmp,png,jpg|max:500',
			'favicon' => 'mimes:jpeg,bmp,png,jpg|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'status' => 'danger', 'message' => $validator->errors()]);
        }

            $input = $request->all();
            $config_type = $request->config_type;
            $old_configs = Setting::all();

            $boolean_system_setting = config('system.boolean.'.$config_type);

            if($boolean_system_setting){
                foreach($boolean_system_setting as $v){
                    $config = Setting::firstOrCreate(['name' => $v]);
                    $config->value = 0;
                    $config->save();
                }
            }



            foreach($_POST as $key => $value){
                if($key == "_token"){
                    continue;
                }

                $data = array();
                $data['value'] = $value;

                $data['updated_at'] = Carbon::now();
                if(Setting::where('name', $key)->exists()){
                    Setting::where('name','=',$key)->update($data);

                    // Activity Log
                    activity()->log('Look mum, I logged something');
                }else{
                    $data['name'] = $key;
                    $data['created_at'] = Carbon::now();

                    Setting::insert($data);
                }
            }

            if($request->hasFile('logo')) {

                $data = getimagesize($request->file('logo'));
                $width = $data[0];
                $height = $data[0];

                if($width > 33 && $height > 33) {
			        return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Logo Width and height is wrong']);
                }

                $storagepath = $request->file('logo')->store('public/images/logo');
                $fileName = basename($storagepath);
                $logo['name']='logo';
                $logo['value'] = $fileName;

                //if file chnage then delete old one
                $oldFile = $request->get('oldLogo','');
                if( $oldFile != ''){
                    $file_path = "public/images/logo/".$oldFile;
                    Storage::delete($file_path);
                }
            } else {
            	$logo['name']='logo';
                $logo['value'] = $request->get('oldLogo','');
            }

            if($request->hasFile('favicon')) {
                $storagepath = $request->file('favicon')->store('public/images/logo');
                $fileName = basename($storagepath);
                $data1['name']='favicon';
                $data1['value'] = $fileName;

                //if file chnage then delete old one
                $oldFile = $request->get('oldfavicon','');
                if( $oldFile != ''){
                    $file_path = "public/images/logo/".$oldFile;
                    Storage::delete($file_path);
                }
            } else {
            	$data1['name']='favicon';
                $data1['value'] = $request->get('oldfavicon','');
            }

            // check enable_http
            // $enable_http = get_option('enable_https');
            // dd($enable_http);



            // dd($request->enable_https);

            if(Setting::where('name', "logo")->exists()){
				Setting::where('name','=',"logo")->update($logo);
			} else {
				$logo['created_at'] = Carbon::now();
				Setting::insert($logo);
			}

			if(Setting::where('name', "favicon")->exists()){
				Setting::where('name','=',"favicon")->update($data1);
			} else {
				$data1['created_at'] = Carbon::now();
				Setting::insert($data1);
			}
			return response()->json(['success' => true, 'status' => 'success', 'message' => 'Configuration Updated', 'load' => true]);
    }
}
