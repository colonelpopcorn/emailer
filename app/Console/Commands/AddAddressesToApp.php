<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        
    }
}
