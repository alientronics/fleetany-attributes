<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ValueTestCase extends TestCase
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
    
    public function testPingApi()
    {
        $this->get('/');
    
        $this->assertEquals(
            $this->response->getContent(), $this->app->version()
            );
    }
    
    public function testEntityValueGetFail()
    {
        $this->get('/api/v1/values/trip/1');
    
        $this->assertEquals($this->response->status(), 401);
    
    }
    
    public function testEntityValueGetSuccess()
    {
    
        $user = factory('App\User')->make();
    
        $this->actingAs($user)
        ->get('/api/v1/values/vehicle/1');
    
        $this->assertEquals($this->response->status(), 200);
    }
    
    public function testEntityValueWithModelGetSuccess()
    {
    
        $user = factory('App\User')->make();
    
        $this->actingAs($user)
        ->get('/api/v1/values/vehicle.car/1');
    
        $this->assertEquals($this->response->status(), 200);
    }
    
    public function testEntityValuePostSuccess()
    {
    
        $user = factory('App\User')->make();
    
        $data = ['1' => '2015', '2' => 'BMW', '3' => '120hp'];
    
        $this->actingAs($user)
        ->post('/api/v1/values/vehicle/1', $data)
        ->seeJson(['created']);
    
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => '2015']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => 'BMW']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => '120hp']);
    }
    
    /* based on https://github.com/kidshenlong/comic-cloud-lumen/blob/master/tests/api/ApiTester.php */
    public function testEntityValuePostWithFileSuccess()
    {
    
        $user = factory('App\User')->make();
    
        $data = ['1' => '2016', '2' => 'Porsche', '3' => '160hp', '4' => 'file.txt'];
    
        $file = new UploadedFile(storage_path('test/file.txt'), 'file.txt', null, null, null, TRUE);
    
        $this->actingAs($user)
        ->call('POST', '/api/v1/values/vehicle/2', $data, [], ['file' => $file]);
    
        $this->seeJson(['created']);
    
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => '2016']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => 'Porsche']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => '160hp']);
    }
    
    public function testEntityValueWithModelPostSuccess()
    {
    
        $user = factory('App\User')->make();
    
        $data = ['1' => '2015', '2' => 'BMW', '3' => '120hp'];
    
        $this->actingAs($user)
        ->post('/api/v1/values/vehicle.car/1', $data)
        ->seeJson(['created']);
    
        $this->seeInDatabase('values', ['entity_key' => 'vehicle.car' , 'value' => '2015']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle.car' , 'value' => 'BMW']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle.car' , 'value' => '120hp']);
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
    
        $count = $database->connection($connection)
            ->table($table)
            ->where($data)
            ->whereNotNull('deleted_at')
            ->count();
    
        $this->assertGreaterThan(0, $count, sprintf(
            'Found unexpected records in database table [%s] that matched attributes [%s].',
            $table,
            json_encode($data)
        ));
    
        return $this;
    }
}
