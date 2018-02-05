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
    protected $signature = 'emailer:salt {keyword}'; /*[rounds] Maybe later...*/

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a super secret salt to put in your .env file. Necessary for authentication of apps.';

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
        //$rounds = $this->argument('rounds');

        $hash = base64_encode(hash('sha512', str_random(rand(20, 20)), $keyword));

        /*
        // Maybe later...
        if ($rounds != null) 
        {
            $this->info('Running crypto hashes ' . $rounds . ' times...');

            for ($i = 0; $i < $rounds; $i++) 
            {
                $hash = hash('sha512', $hash, $keyword); 
            }

        }
        */

        $this->setEnvKey("SECRET_SALT", $hash);
    }

    private function setEnvKey($key, $value) 
    {
        try 
        {
            $envFile = '.env';
            $contents = file_get_contents($envFile);

            if (strpos($contents, $key) !== false) 
            {
                $oldValue = env($key);
                $newContents = str_replace("{$key}={$oldValue}", "{$key}=${value}\n", $contents);
                $this->info("Key already exists, generating and saving new key.");
            }
            else
            {
                $newContents = ($contents .= "\n{$key}={$value}\n");
                $this->info("No previous key found, generating new key.");
            }            

            $fileBuffer = fopen('.env', 'w');
            fwrite($fileBuffer, $newContents);
            fclose($fileBuffer);
            $this->info("New key saved to env file.");

        }

        catch (Exception $e)
        {
            $this->error('Unable to read or write to .env file!');
        }
        
    }
}
