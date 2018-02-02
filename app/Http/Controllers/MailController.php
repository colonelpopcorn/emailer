<?php

namespace App\Http\Controllers;

class MailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->middleware('app_validation');
    }

    public function send(Request $request, $key, $template) 
    {
        $this->validate($request, [
            'app_name' => 'required',
            'key' => 'required'
        ]);

        $app = DB::select('SELECT * FROM apps WHERE name = ?', [ $request['app_name'] ]);
        if (!count($app) > 0)
            return json_encode("Unable to find an app with that name!");
        else
            $app = $app[0];

        if ($key != hash('sha256', $appName . env('APP_KEY') . $appName, env('SECRET_SALT')))
            return json_encode("App key does not match app name! Regenerate key and try again!");
        
        Mail::send($template.'generated', $request, function($message) {


        });

    }

    //
}
