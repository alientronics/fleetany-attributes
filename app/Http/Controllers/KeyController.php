<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\MongoDb\KeyControllerMongoDb;
use App\Http\Controllers\MySql\KeyControllerMySql;
use App\Http\Controllers\DynamoDb\KeyControllerDynamoDb;

class KeyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        switch (config('database.default')) {
            case 'dynamodb' :
                $this->controller = new KeyControllerDynamoDb();
                break;
            
            case 'mongodb' :
                $this->controller = new KeyControllerMongoDb();
                break;
                
            default :
                $this->controller = new KeyControllerMySql();
                break;
        }
    }

    public function index($company_id, $entity_key = '-', $description = '-')
    {
        return $this->controller->index($company_id, $entity_key, $description);
    }
  
    public function get($idKey)
    {
        return $this->controller->get($idKey);
    }
  
    public function create(Request $request)
    {
        return $this->controller->create($request);
    }
  
    public function delete($idKey)
    {
        return $this->controller->delete($idKey);
    }
  
    public function update(Request $request, $idKey)
    {
        return $this->controller->update($request, $idKey);
    }
}
