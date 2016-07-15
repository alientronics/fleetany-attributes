<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase;
use App\Entities\MySql\KeyMySql;
use App\Entities\MongoDb\KeyMongoDb;

class AcceptanceKeyTestCase extends TestCase
{
    
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        return $app;
    }
    
    private function getEntity()
    {
        switch (config('database.default')) {
            case 'dynamodb' :
                return KeyMongoDb::class;
                break;
        
            case 'mongodb' :
                return KeyMongoDb::class;
                break;
        
            default :
                return KeyMySql::class;
                break;
        } 
    }
    
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

        $entity = $this->getEntity();
        
        $user = factory('App\User')->make();
    
        $this->actingAs($user)
            ->get('/api/v1/key/'.$entity::all()->last()['id']);
    
        $this->assertEquals($this->response->status(), 200);
    }

    public function testKeyUpdateSuccess()
    {

        $entity = $this->getEntity();
        
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

        $idUpdate = $entity::all()->last()['id'];
        
        $this->seeInDatabase('keys', ['entity_key' => 'vehicle' , 'description' => 'year']);
        
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
        
        $this->seeInDatabase('keys', ['entity_key' => 'vehicle.car', 'description' => 'year2']);

    }

    public function testKeyDeleteSuccess()
    {
        $entity = $this->getEntity();
        
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
        
        $idDelete = $entity::all()->last()['id'];
        
        $this->actingAs($user)
            ->delete('/api/v1/key/'.$idDelete)
            ->seeJson(['deleted']);
        
        $this->seeIsSoftDeletedInDatabase('keys', ['id' => $idDelete]);
    }
    
    /**
     * Assert that a given where condition matches a soft deleted record
     *
     * @param  string $table
     * @param  array  $data
     * @param  string $connection
     * @return $this
     */
    protected function seeIsSoftDeletedInDatabase($table, array $data, $connection = null)
    {
        $database = $this->app->make('db');
    
        $connection = $connection ?: $database->getDefaultConnection();
    
        if($connection == 'mongodb') {
            $entity = $this->getEntity();
            $register = $entity::find($data['id']);
            $count = !empty($register->deleted_at) ? 0 : 1;
        } else {
            $count = $database->connection($connection)
                ->table($table)
                ->where($data)
                ->whereNotNull('deleted_at')
                ->count();
        }
        
        $this->assertGreaterThan(0, $count, sprintf(
            'Found unexpected records in database table [%s] that matched attributes [%s].',
            $table,
            json_encode($data)
        ));
    
        return $this;
    }
}
