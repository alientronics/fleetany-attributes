<?php

namespace App\Http\Controllers\MongoDb;

use App\Entities\MongoDb;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\MongoDb\ValueMongoDb;
use App\Repositories\ValueRepository;
use App\Repositories\ValueRepositoryMongoDb;

class ValueControllerMongoDb extends Controller
{
    
    private $valueRepository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->valueRepository = new ValueRepositoryMongoDb(ValueMongoDb::class);
    }
    
    public function get($entity_key, $entity_id)
    {
        return $this->valueRepository->get($entity_key, $entity_id);
    }
    
    public function set(Request $request, $entity_key, $entity_id)
    {
        return $this->valueRepository->set($request, $entity_key, $entity_id);
    }
    
    public function validateFileAccessPermission(Request $request)
    {
        return $this->valueRepository->validateFileAccessPermission($request);
    }
}
