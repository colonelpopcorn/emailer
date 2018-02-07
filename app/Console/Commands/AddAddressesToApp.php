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
            $app_names[$key] = [$key, $value->name];
        }

        if (count($apps) <= 0) 
        {
            $this->error("No apps to associate with addresses!");
            return;
        }

        $appHeaders = ['Index', 'App Name'];

        $this->table($appHeaders, $app_names);

        $app_id = $this->ask('Select an app by index:');

        $addresses = DB::select('SELECT * FROM addresses WHERE addresses.id != ? LIMIT 50',
         [$apps[$app_id]->from_address_id]);

        $address_names = [];

        foreach ($addresses as $key => $value) {
            $address_names[$key] = [$value->id, $value->name, $value->address];
        }

        $addressHeaders = ['Index', 'Name', 'Address'];

        $this->table($addressHeaders, $address_names);
        $address_id = $this->ask("Select an address by index: ");

        $quickCheck = DB::select('SELECT * FROM app_addresses WHERE app_id = ? AND address_id = ?', [$app_id, $address_id]);

        if (count($quickCheck) > 0)
        {
            $this->error("Cannot insert an address that's already associated with {$apps[$app_id]->name}!");
            return;
        }

        DB::insert('INSERT INTO app_addresses (app_id, address_id) VALUES (?, ?)', [$app_id, $address_id]);

        $this->info("Successfully updated app addresses for {$apps[$app_id]->name}!");
    }
}
