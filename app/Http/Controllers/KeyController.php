<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\MongoDb\KeyControllerMongoDB;
use App\Http\Controllers\Mysql\KeyControllerMySql;

class KeyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (config('database.default') == 'mongodb') {
            $this->controller = new KeyControllerMongoDB();
        } else {
            $this->controller = new KeyControllerMySql();
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
