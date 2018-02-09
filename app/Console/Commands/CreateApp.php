<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class CreateApp extends Command
{
	protected $signature = 'emailer:apps {appname} {from}';
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
		$address_id = DB::select('SELECT id FROM addresses WHERE address LIKE ? LIMIT ?', [$from, 1]);

		if ($address_id == null) 
		{
			// Prompt the user to create a new address entry...
			if ($this->confirm('Email address not found, create a new address?')) 
			{
				$name = $this->ask('What is the name of this person or group?');
				DB::insert('INSERT INTO addresses (name, address) VALUES (?, ?)', [$name, $from]);
				$this->info("Successfully created {$name}'s address!");
				$address_id = DB::getPdo()->lastInsertId();

			}
			else
			{
				$this->error("Cannot continue without a valid from address.");
				return;
			}

		}
		else 
		{
			$address_id = $address_id[0]->id;
		}

		$secretKey = base64_encode(hash('sha512', $appName . env('APP_KEY') . $appName, env('SECRET_SALT')));

		DB::insert('INSERT INTO apps (name, description, from_address_id) VALUES (?, ?, ?)', [$appName, null, $address_id]);
		$this->info('New app successfully created! Here\'s your secret, keep it safe!');
		$this->line($secretKey);
	}
}