<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\MongoDb\EntityValueControllerMongoDB;
use App\Http\Controllers\Mysql\EntityValueControllerMySql;

class EntityValueController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (config('database.default') == 'mongodb') {
            $this->controller = new EntityValueControllerMongoDB();
        } else {
            $this->controller = new EntityValueControllerMySql();
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
}
