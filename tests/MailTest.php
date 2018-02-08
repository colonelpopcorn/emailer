<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use MailThief\Facades\MailThief;

class MailTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() 
    {
        parent::setUp();

        Artisan::call('db:seed');

    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAppNameErrorIfAppNameIncorrect()
    {

        $this->json('POST', "/api/send/testapp/test", [
            'key' => 'cCU1RH9/aTETh7p1xqFMvTZQoMQQG4sQ5cDoSuR9KG+s5F4gbNLp3e7YA2oYYL7+vVSpGg439TN9nTqazBRu1w==',
            'app_name' => 'nottestapp',
            'subject' => 'Mail Subject',
            'adjective' => 'super good'
        ]);

        $this->assertEquals(
            json_encode(["response" => "Unable to find an app with that name!"]), $this->response->getContent()
        );
    }

    public function testBadKeyErrorIfBadKeySupplied()
    {
        $this->json('POST', "/api/send/testapp/test", ['key' => 'not the right key',
            'app_name' => 'testapp',
            'subject' => 'Mail Subject',
            'adjective' => 'super good'
        ]);

        $this->assertEquals(
            json_encode(["response" => "App key does not match app name! Regenerate key and try again!"]), $this->response->getContent()
        );
    }

    public function tearDown() 
    {
        parent::tearDown();

        file_put_contents(__DIR__ . '/../database/database.sqlite', '');
    }
}
