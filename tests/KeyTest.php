<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class KeyTest extends TestCase
{
    
    use DatabaseMigrations;

    public function testPingApi()
    {
        $this->get('/');

        $this->assertEquals(
            $this->response->getContent(), $this->app->version()
        );
    }

    public function testKeyGetFail()
    {
        $this->get('/api/v1/key');

        $this->assertEquals($this->response->status(), 401);

    }

    public function testKeyGetSuccess()
    {

        $user = factory('App\User')->make();

        $this->actingAs($user)
            ->get('/api/v1/key');

        $this->assertEquals($this->response->status(), 200);
    }

    public function testKeyPostSuccess()
    {

        $user = factory('App\User')->make();

        $key = [
            'company_id'  => 1,
            'entity_key'  => 'vehicle',
            'description'  => 'year',
            'type'  => 'numeric',
            'options' => ''
        ];

        $this->actingAs($user)
            ->post('/api/v1/key', $key)
            ->seeJson(['created']);

        $this->seeInDatabase('keys', ['entity_key' => 'vehicle' , 'description' => 'year']);
    }

}
