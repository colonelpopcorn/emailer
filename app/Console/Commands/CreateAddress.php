<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class CreateAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emailer:address {name} {address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an address in the addresses table.';

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
