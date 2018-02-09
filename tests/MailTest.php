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
        MailThief::hijack();

        $this->json('POST', "/api/send/testapp/test", [
            'key' => 'HFgnmthxqKepBsQNng1RlxuZq2nAVYfZ0YJFzXsFaSe4eW+p35MBsK8G64AX2cMTWZa3E4INWAigOBJ+C2sliA==',
            'app_name' => 'nottestapp',
            'subject' => 'Mail Subject',
            'adjective' => 'super good'
        ]);

        $this->assertEquals(
            json_encode(["response" => "Unable to find an app with that name!"]), $this->response->getContent()
        );
        $this->assertEquals(null, MailThief::lastMessage());
    }

    public function testBadKeyErrorIfBadKeySupplied()
    {
        MailThief::hijack();

        $this->json('POST', "/api/send/testapp/test", [
            'key' => 'not the right key',
            'app_name' => 'testapp',
            'subject' => 'Mail Subject',
            'adjective' => 'super good'
        ]);

        $this->assertEquals(
            json_encode(["response" => "App key does not match app name! Regenerate key and try again!"]), $this->response->getContent()
        );
        $this->assertEquals(null, MailThief::lastMessage());
    }

    public function testMailSentWhenGoodRequestSupplied()
    {
        MailThief::hijack();

        $this->json('POST', "/api/send/testapp/test", [
            'key' => 'HFgnmthxqKepBsQNng1RlxuZq2nAVYfZ0YJFzXsFaSe4eW+p35MBsK8G64AX2cMTWZa3E4INWAigOBJ+C2sliA==',
            'app_name' => 'testapp',
            'subject' => 'Mail Subject',
            'adjective' => 'super good'
        ]);

        $this->assertEquals(
            json_encode(["response" => "Mail sent successfully!"]), $this->response->getContent()
        );
        $this->assertTrue(MailThief::hasMessageFor('stest@test.com'));
        $this->assertTrue(MailThief::lastMessage()->contains('<h1>This is a super good test!</h1>'));
        $this->assertEquals('Mail Subject', MailThief::lastMessage()->subject);

    }

    public function tearDown() 
    { 
        parent::tearDown();

        file_put_contents(__DIR__ . '/../database/database.sqlite', '');        
    }
}
