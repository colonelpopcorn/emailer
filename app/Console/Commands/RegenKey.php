<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RegenKey extends Command
{
	protected $signature = 'emailer:secret {appname}';
	protected $description = 'Revoke and reset the secret key for the specified application.';

	public function __construct() 
	{
		// Just call base constructor for now.
		parent::__construct();
	}

	public function handle()
	{
		$appName = $this->argument('appname');
		$hash = base64_encode(hash('sha512', $appName . env('APP_KEY') . $appName, env('SECRET_SALT')));
		$this->info("Here's your key:");
		$this->line($hash);
	}
}