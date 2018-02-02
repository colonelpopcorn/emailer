<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSalt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emailer:createsalt {keyword}'; /*[rounds] Maybe later...*/

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a super secret salt to put in your .env file. Necessary for authentication of appps.';

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
        $keyword = $this->argument('keyword');
        $rounds = $this->argument('rounds');

        $this->info('Generating salt, going to need to play a lot of CS:GO for this...');

        $hash = hash('sha-256', str_random(rand(20, 20)), $keyword);

        /*
        // Maybe later...
        if ($rounds != null) 
        {
            $this->info('Running crypto hashes ' . $rounds . ' times...');

            for ($i = 0; $i < $rounds; $i++) 
            {
                $hash = hash('sha-256', $hash, $keyword); 
            }

        }
        */

        $this->info('Spitting out secret salt because life is too short to be mad about CS:GO...');

        putenv('SECRET_SALT=' . $hash);
    }
}
