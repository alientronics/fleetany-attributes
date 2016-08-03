<?php

namespace App\Http\Controllers\MySql;

use App\Entities\MySql;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\MySql\ValueMySql;
use App\Repositories\ValueRepository;
use App\Repositories\ValueRepositoryMySql;

class ValueControllerMySql extends Controller
{
    
    private $valueRepository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->valueRepository = new ValueRepositoryMySql(ValueMySql::class);
    }
    
    public function get($entity_key, $entity_id)
    {
        return $this->valueRepository->get($entity_key, $entity_id);
    }
    
    public function set(Request $request, $entity_key, $entity_id, $company_id)
    {
        return $this->valueRepository->set($request, $entity_key, $entity_id, $company_id);
    }
    
    public function validateFileAccessPermission(Request $request)
    {
        return $this->valueRepository->validateFileAccessPermission($request);
    }
}
