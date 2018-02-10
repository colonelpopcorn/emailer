# Emailer

<p align="center">![alt text](https://raw.githubusercontent.com/colonelpopcorn/emailer/master/resources/assets/emailer.png)</p>

[![Join the chat at https://gitter.im/emailer-lumen](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/emailer-lumen?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Build Status](https://travis-ci.org/colonelpopcorn/emailer.svg?branch=master)](https://travis-ci.org/colonelpopcorn/emailer)
## Getting Started
----------------

Emailer is a lightweight email microservice. The idea is to use it to handle sending emails from your applications. To get started using Emailer you will need to do five things.

1. Download Emailer
2. Fill out the .env file with your mail server settings and run `php artisan key:generate`
3. Create a template using the [Blade templating engine](https://laravel.com/docs/5.6/blade) save it as `<templatename>generated.blade.php>`
4. Run the artisan commands for Emailer in this order
	a. emailer:salt
	b. emailer:apps
	c. emailer:address (to generate an address to send to)
	d. emailer:addresses (to connect the new address with the app)
5. Then start your webserver and send a POST request to `http://<your-url>/api/send/<appname>/<templatename>`

## Roadmap
----------------

[] Create client to replace artisan commands
[] Write tests for artisan commands
[] Mock database to make tests faster
[] Refactor MailController to be more testable

## Contributing
----------------

To get started contributing, just fork this repository and clone it.

Before you check out a branch go ahead and and a remote upstream by typing `git remote add upstream https://github.com/colonelpopcorn/emailer`.

Then checkout a new branch and code away!

When you're ready to submit a pull request, first run `git pull` on the master branch and then checkout your feature branch and run `git rebase origin/master`.

If you run into any trouble just ask in our gitter chat!

## Licensing and attributions
----------------

Emailer is released under the MIT license.

The emailer logo is comprised of several creative commons assets.

* ![Janda Manatee Font by Kimberly Geswein](http://www.fontspace.com/kimberly-geswein/janda-manatee)
* ![Leterra (Letter) by francesco_rallandin](https://openclipart.org/detail/31987/architetto-lettera)
* ![Hermes by ymai](https://openclipart.org/detail/194990/hermes)
* ![wing by elpedro](https://openclipart.org/detail/65851/wing)
