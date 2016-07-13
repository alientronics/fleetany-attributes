<?php

namespace App\Http\Controllers\MySql;

use App\Entities\MySql;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\MySql\KeyMySql;
use App\Repositories\KeyRepository;

class KeyControllerMySql extends Controller
{
    
    private $keyRepository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->keyRepository = new KeyRepository(KeyMySql::class);
    }

    public function index($company_id, $entity_key = '-', $description = '-')
    {
        return $this->keyRepository->index($company_id, $entity_key, $description);
    }
  
    public function get($idKey)
    {
        return $this->keyRepository->get($idKey);
    }
  
    public function create(Request $request)
    {
        return $this->keyRepository->create($request);
    }
  
    public function delete($idKey)
    {
        return $this->keyRepository->delete($idKey);
    }
  
    public function update(Request $request, $idKey)
    {
        return $this->keyRepository->update($request, $idKey);
    }
}
