<?php


namespace App\Helpers;
use App\Models\SadikLog;
use Illuminate\Http\Request;
use Auth;

class LogActivity
{


    public static function addToLog($subject)
    {
        $url = \Request::fullUrl();
        $method = \Request::method();
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = $url;
    	$log['method'] = $method;
    	$log['ip'] = \Request::ip();
    	$log['agent'] = \Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	SadikLog::create($log);
    }


    public static function logActivityLists()
    {
    	if(Auth::user()->id == 1) {
            return SadikLog::with('user')->get();
        } else {
            return SadikLog::with('user')->where('user_id', Auth::user()->id)->get();
        }

    }


}