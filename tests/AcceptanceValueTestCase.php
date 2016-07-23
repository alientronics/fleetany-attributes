<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AcceptanceValueTestCase extends TestCase
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
    
    protected function getFactory()
    {
        switch (config('database.driver')) {
            case 'dynamodb' :
                return 'App\Entities\DynamoDb\KeyDynamoDb';
                break;
        
            case 'mongodb' :
                return 'App\Entities\MongoDb\KeyMongoDb';
                break;
        
            default :
                return 'App\Entities\MySql\KeyMySql';
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
    
    public function testValueGetFail()
    {
        $this->get('/api/v1/values/trip/1');
    
        $this->assertEquals($this->response->status(), 401);
    
    }
    
    public function testValueGetSuccess()
    {
    
        $user = factory('App\User')->make();
    
        $this->actingAs($user)
        ->get('/api/v1/values/vehicle/1');
    
        $this->assertEquals($this->response->status(), 200);
    }
    
    public function testValueWithModelGetSuccess()
    {
    
        $user = factory('App\User')->make();
    
        $this->actingAs($user)
        ->get('/api/v1/values/vehicle.car/1');
    
        $this->assertEquals($this->response->status(), 200);
    }
    
    public function testValuePostSuccess()
    {

        $user = factory('App\User')->make();
        var_dump($this->getFactory());
        $key1 = factory('App\Entities\MySql\KeyMySql')->make([
            'type' => 'numeric'
        ]);
        $key2 = factory('App\Entities\MySql\KeyMySql')->make();
        $key3 = factory('App\Entities\MySql\KeyMySql')->make();
            
        $data = ['1' => '2015', '2' => 'BMW', '3' => '120hp'];
    
        $this->actingAs($user)
            ->post('/api/v1/values/vehicle/1', $data)
            ->seeJson(['created']);
    
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'attribute_id' => $key1->id , 'value' => '2015']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'attribute_id' => $key2->id , 'value' => 'BMW']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'attribute_id' => $key3->id , 'value' => '120hp']);
    }
    
    /* based on https://github.com/kidshenlong/comic-cloud-lumen/blob/master/tests/api/ApiTester.php */
    public function testValuePostWithFileSuccess()
    {
    
        $user = factory('App\User')->make();
        $key1 = factory('App\Entities\MySql\KeyMySql')->make([
            'type' => 'numeric'
        ]);
        $key2 = factory('App\Entities\MySql\KeyMySql')->make();
        $key3 = factory('App\Entities\MySql\KeyMySql')->make();
    
        $data = ['1' => '2016', '2' => 'Porsche', '3' => '160hp', '4' => 'file.txt'];
    
        $file = new UploadedFile(storage_path('test/file.txt'), 'file.txt', null, null, null, TRUE);
    
        $this->actingAs($user)
        ->call('POST', '/api/v1/values/vehicle/2', $data, [], ['file' => $file]);
    
        $this->seeJson(['created']);
    
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'attribute_id' => $key1->id , 'value' => '2016']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'attribute_id' => $key2->id , 'value' => 'Porsche']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'attribute_id' => $key3->id , 'value' => '160hp']);
    }
    
    public function testValueWithModelPostSuccess()
    {
    
        $user = factory('App\User')->make();
        $key1 = factory('App\Entities\MySql\KeyMySql')->make([
            'entity_key' => 'vehicle.car',
            'type' => 'numeric'
        ]);
        $key2 = factory('App\Entities\MySql\KeyMySql')->make([
            'entity_key' => 'vehicle.car'
        ]);
        $key3 = factory('App\Entities\MySql\KeyMySql')->make([
            'entity_key' => 'vehicle.car'
        ]);
    
        $data = ['1' => '2015', '2' => 'BMW', '3' => '120hp'];
    
        $this->actingAs($user)
            ->post('/api/v1/values/vehicle.car/1', $data)
            ->seeJson(['created']);
    
        $this->seeInDatabase('values', ['entity_key' => 'vehicle.car' , 'attribute_id' => $key1->id , 'value' => '2015']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle.car' , 'attribute_id' => $key2->id , 'value' => 'BMW']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle.car' , 'attribute_id' => $key3->id , 'value' => '120hp']);
    }
}
