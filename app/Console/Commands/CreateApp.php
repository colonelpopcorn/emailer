<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateApp extends Command
{
	protected $signature = 'emailer:createapp {appname} {from}';
	protected $description = 'Create an app and get a secret key for making requests';

	public function __construct() 
	{
		// Just call base constructor for now.
		parent::__construct();
	}

	public function handle()
	{
		$appName = $this->argument('appname');
		$from = $this->argument('from');

		$this->info('Searching for address...');
		$address_id = DB::query('SELECT id FROM addresses WHERE address LIKE ? LIMIT ?', [$from, 1]);

		if (address_id == null) 
		{
			// Prompt the user to create a new address entry...


		}

		$secretKey = hash('sha256', $appName . env('APP_KEY') . $appName, env('SECRET_SALT'));

		DB::insert('INSERT into apps (name, description, from_address_id) VALUES (?, ?, ?)', [$appName, null, $address_id]);
		$this->info('New app successfully created! Here\'s your secret, keep it safe!');
		$this->line($secretKey);
	}
}