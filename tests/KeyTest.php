<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Entities\MySql;
use App\Entities\MySql\KeyMySql;

class KeyTest extends TestCase
{
    
    //use DatabaseMigrations;

    public function testPingApi()
    {
        $this->get('/');

        $this->assertEquals(
            $this->response->getContent(), $this->app->version()
        );
    }

    public function testKeysGetFail()
    {
        $this->get('/api/v1/keys/1/vehicle/description');

        $this->assertEquals($this->response->status(), 401);

    }

    public function testKeysGetSuccess()
    {

        $user = factory('App\User')->make();

        $this->actingAs($user)
            ->get('/api/v1/keys/1/vehicle/description');

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

    public function testKeyGetSuccess()
    {
    
        $user = factory('App\User')->make();
    
        $this->actingAs($user)
            ->get('/api/v1/key/'.KeyMySql::all()->last()['id']);
    
        $this->assertEquals($this->response->status(), 200);
    }

    public function testKeyUpdateSuccess()
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

        $idUpdate = KeyMySql::all()->last()['id'];
        
        $this->seeInDatabase('keys', ['id' => $idUpdate, 'entity_key' => 'vehicle' , 'description' => 'year']);
        
        $keyUpdated = [
            'company_id'  => 1,
            'entity_key'  => 'vehicle.car',
            'description'  => 'year2',
            'type'  => 'string',
            'options' => 'first'
        ];
        
        $this->actingAs($user)
            ->put('/api/v1/key/'.$idUpdate, $keyUpdated)
            ->seeJson(['updated']);
        
        $this->seeInDatabase('keys', ['id' => $idUpdate, 'entity_key' => 'vehicle.car', 'description' => 'year2']);

    }

    public function testKeyDeleteSuccess()
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
        
        $idDelete = KeyMySql::all()->last()['id'];
        
        $this->actingAs($user)
            ->delete('/api/v1/key/'.$idDelete)
            ->seeJson(['deleted']);
        
        $this->seeIsSoftDeletedInDatabase('keys', ['id' => $idDelete]);
    }
}
