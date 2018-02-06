<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class AddAddressesToApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emailer:addresses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add addresses to a specific application.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $apps = DB::select('SELECT * FROM apps');
        $app_names = [];

        foreach ($apps as $key => $value) {
            $app_names[$key] = $value->name;
        }

        if (count($apps) <= 0) 
        {
            $this->error("No apps to associate with addresses!");
            return;
        }

        $app_id = $this->choice('Select an app:', $app_names, 0);

        $this->info($app_id);        
    }
}
