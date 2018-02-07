<?php

namespace App\Http\Controllers;

use DB;
use Mail;

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
    }

    public function index()
    {
        return json_encode("Emailer is an application!");
    }

    public function send(Request $request, $name, $template) 
    {
        $this->validate($request, [
            'app_name' => 'required',
            'key' => 'required',
            'subject' => 'required'
        ]);

        $appName = $request('app_name');
        $subject = $request('subject');

        $app = DB::select('SELECT * FROM apps WHERE name = ? LIMIT ?', [ $name, 1 ]);
        if (!count($app) > 0)
            return json_encode("Unable to find an app with that name!");
        else
            $app = $app[0];

        if (base64_decode($request['key']) != hash('sha512', $appName . env('APP_KEY') . $appName, env('SECRET_SALT')))
            return json_encode("App key does not match app name! Regenerate key and try again!");

        $toAddresses = DB::select('SELECT * FROM addresses JOIN app_addresses ON addresses.id = app_addresses.address_id WHERE app_addresses.app_id = ?', 
            [$app->id]);

        $fromAddress = DB::select('SELECT * FROM addresses JOIN app_addresses ON addresses.id = app_addresses.address_id WHERE app_addresses.app_id = ? LIMIT ?', 
            [$app->from_address_id, 1]);
        
        Mail::send($template.'generated', $request, function($message) use ($toAddresses, $fromAddress, $subject) {
            foreach ($toAddresses as $key => $value) {
                $message->to($value["address"]);
            }

            $message->from($fromAddress[0]["address"]);
            $message->subject($subject);
        });

    }

    //
}
