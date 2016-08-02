<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\MongoDb\ValueControllerMongoDb;
use App\Http\Controllers\MySql\ValueControllerMySql;
use App\Http\Controllers\DynamoDb\ValueControllerDynamoDb;
use App\Repositories\HelperRepository;

class ValueController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        switch (config('database.driver')) {
            case 'dynamodb':
                $this->controller = new ValueControllerDynamoDb();
                break;
            
            case 'mongodb':
                $this->controller = new ValueControllerMongoDb();
                break;
                
            default:
                $this->controller = new ValueControllerMySql();
                break;
        }
    }

    public function get($entity_key, $entity_id)
    {
        return $this->controller->get($entity_key, $entity_id);
    }
  
    public function set(Request $request, $entity_key, $entity_id)
    {
        return $this->controller->set($request, $entity_key, $entity_id);
    }
  
    public function download(Request $request)
    {
        if (!$this->controller->validateFileAccessPermission($request)) {
            return response('Unauthorized.', 401);
        }
        return HelperRepository::download($request);
    }
}
