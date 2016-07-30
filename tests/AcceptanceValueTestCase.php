<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
    
    public function testPingApi()
    {
        $this->get('/');
    
        $this->assertEquals(
            $this->response->getContent(),
            $this->app->version()
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
    
        $data = ['1' => '2015', '2' => 'BMW', '3' => '120hp'];
    
        $this->actingAs($user)
        ->post('/api/v1/values/vehicle/1', $data)
        ->seeJson(['created']);
    
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => '2015']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => 'BMW']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => '120hp']);
    }
    
    /* based on https://github.com/kidshenlong/comic-cloud-lumen/blob/master/tests/api/ApiTester.php */
    public function testValuePostWithFileSuccess()
    {
    
        $user = factory('App\User')->make();
    
        $data = ['1' => '2016', '2' => 'Porsche', '3' => '160hp', '4' => 'file.txt'];
    
        $file = new UploadedFile(storage_path('test/file.txt'), 'file.txt', null, null, null, true);
    
        $this->actingAs($user)
        ->call('POST', '/api/v1/values/vehicle/2', $data, [], ['4' => $file]);
    
        $this->seeJson(['created']);
    
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => '2016']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => 'Porsche']);
        $this->seeInDatabase('values', ['entity_key' => 'vehicle' , 'value' => '160hp']);
    }
    
    public function testValueWithModelPostSuccess()
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
    
    public function testValueDownloadFileNotFound()
    {
    
        $user = factory('App\User')->make();
    
        $data = ['dGVzdGUudHh023'];
    
        $this->actingAs($user)
            ->post('/api/v1/values/download', $data);

        $this->assertEquals($this->response->status(), 200);
        $this->assertEquals($this->response->content(), null);
    }
    
    public function testValueDownloadFileEmpty()
    {
    
        $user = factory('App\User')->make();
    
        $data = [];
    
        $this->actingAs($user)
            ->post('/api/v1/values/download', $data);

        $this->assertEquals($this->response->status(), 200);
        $this->assertEquals($this->response->content(), null);
    }
    
    public function testValueDownloadFileSuccess()
    {
    
        $user = factory('App\User')->make();
        
        Storage::disk('local')->put('teste.txt', 'Contents');
        
        $data = ['dGVzdGUudHh0'];
    
        $this->actingAs($user)
            ->post('/api/v1/values/download', $data)
            ->seeJson();
        
        $this->assertEquals($this->response->status(), 200);
        
        Storage::disk('local')->delete('teste.txt');
    }
}
