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
    }

    public function send(Request $request, $key, $template) 
    {
        Mail::send($template.'generated', $request, function($message) {

        });

    }

    //
}
