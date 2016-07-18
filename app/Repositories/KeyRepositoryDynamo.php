<?php
namespace App\Repositories;

use Illuminate\Http\Request;

class KeyRepositoryDynamo extends KeyRepository
{
    public function index($company_id, $entity_key = '-', $description = '-')
    {
    
        $entity = $this->entity;

        $Keys = $entity::where('company_id', $company_id);
    
        if ($entity_key != '-') {
            $Keys = $Keys->whereIn('entity_key', HelperRepository::getEntityKeys($entity_key));
        }
    
        if ($description != '-') {
            $Keys = $Keys->where('description', 'like', '%'.$description.'%');
        }
    
        $Keys = $Keys->get();
    
        return response()->json($Keys);
    }
    
    public function get($idKey)
    {
        $entity = $this->entity;
        
        $Key = $entity::where('id', $idKey);
        $Key = $Key->get()->first();
        
        return response()->json($Key);
    }
    
    public function create(Request $request)
    {
        $entity = $this->entity;
       
        $model = new $entity($request->all());
        $model->save();
    
        return response()->json('created');
    }
    
    public function delete($idKey)
    {
        $entity = $this->entity;
        $Key = $entity::where('id', $idKey);
        $Key = $Key->get()->first();
        $Key->delete();
    
        return response()->json('deleted');
    }
    
    public function update(Request $request, $idKey)
    {
        $entity = $this->entity;
        $Key = $entity::where('id', $idKey);
        $Key = $Key->get()->first();
        $Key->fill($request->all());
        $Key->save();
    
        return response()->json('updated');
    }
}
