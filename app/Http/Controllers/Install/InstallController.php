<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Utilities\Installer;
use Hash;

class InstallController extends Controller
{
    // Constructor Method
    public function __construct()
    {
        if(env('APP_INSTALLED', false) == true) {
            Redirect::to('/')->send();
        }
    }

    // Pre Setup Index Page
    public function index()
    {
        $requirements = Installer::checkServerRequirements();
        return view('install.index',compact('requirements'));
    }

    // Database Setup
    public function database()
    {
		return view('install.database');
    }

    // Process Install
    public function process_install(Request $request)
    {
		$host = $request->hostname;
		$database = $request->database;
		$username = $request->username;
		$password = $request->password;
		
		if(Installer::createDbTables($host, $database, $username, $password) == false){
            return response()->json(['status' => 'danger', 'message' => 'Your Information Is wrong. Please Provide Correct Information']);
		}
        
        $html = view('install.user')->render();

        return response()->json(['status' => 'success', 'message' => 'Database Created Successfully. Create A Super Admin From Here', 'stepOver' => $html]);

    }

    // Store User Information
    public function store_user(Request $request)
    {
		$request->validate ([	
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
			'username' => 'required|string|max:20',
        ]);		
		
		$name = $request->name;
		$email = $request->email;
		$password = Hash::make($request->password);
		$username = $request->username;
		
        Installer::createUser($name, $email, $password,$username);

        $html = view('install.company')->render();
        return response()->json(['status' => 'success', 'message' => 'User Created Successfully. One More Step is to go', 'stepOver' => $html]);
    }

    public function final_touch(Request $request)
    {
        Installer::updateSettings($request->all());
        Installer::finalTouches();
        
        $html = view('install.end')->render();
        return response()->json(['status' => 'success', 'message' => 'Installation Process is successfully done !', 'stepOver' => $html]);
    }
}
