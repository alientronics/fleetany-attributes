<?php

namespace App\Http\Controllers\DynamoDb;

use App\Entities\DynamoDb;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\DynamoDb\ValueDynamoDb;
use App\Repositories\ValueRepository;

class ValueControllerDynamoDb extends Controller
{
    
    private $valueRepository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->valueRepository = new ValueRepository(ValueDynamoDb::class);
    }
    
    public function get($entity_key, $entity_id)
    {
        return $this->valueRepository->get($entity_key, $entity_id);
    }
    
    public function set(Request $request, $entity_key, $entity_id)
    {
        return $this->valueRepository->set($request, $entity_key, $entity_id);
    }
}
