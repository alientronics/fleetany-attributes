<?php
namespace App\Repositories;

use Illuminate\Http\Request;

class KeyRepositoryDynamo extends KeyRepository
{
    public function index($company_id, $entity_key = '-', $description = '-')
    {
        $entity_keys = HelperRepository::getEntityKeys($entity_key);
        
        if (count($entity_keys) > 1) {
            $Keys1 = $this->searchKeys($company_id, $entity_keys[0], $description);
            $Keys2 = $this->searchKeys($company_id, $entity_keys[1], $description);
            $Keys = $Keys1->merge($Keys2);
        } else {
            $Keys = $this->searchKeys($company_id, $entity_key, $description);
        }
        
        return response()->json($Keys);
    }
    
    private function searchKeys($company_id, $entity_key, $description) 
    {
        $entity = $this->entity;

        $Keys = $entity::where('company_id', 1);
    
        if ($entity_key != '-') {
            $Keys = $Keys->where('entity_key', $entity_key);
        }
    
        if ($description != '-') {
            $Keys = $Keys->where('description', $description);
        }
    
        $Keys = $Keys->get();

        if (!empty($Keys)) {
            foreach ($Keys as $i => $Key) {
                $Keys[$i]['entity-key'] = $Key['entity_key'];
                
                if($Key['description'] == " ") {
                    $Keys[$i]['description'] = "";
                }
                
                if($Key['options'] == " ") {
                    $Keys[$i]['options'] = "";
                }
            }
        }
        
        return $Keys;
    }
    
    public function get($idKey)
    {
        $entity = $this->entity;

        $Key = $entity::where('id', (int)$idKey);
        $Key = $Key->get()->first();
        
        if (!empty($Key)) {
            $Key['id'] = $idKey;
            
            if($Key['description'] == " ") {
                $Key['description'] = "";
            }
            
            if($Key['options'] == " ") {
                $Key['options'] = "";
            }
        }
        
        return response()->json($Key);
    }
    
    public function create(Request $request)
    {
        $entity = $this->entity;

        $inputs = $request->all();
        $inputs['description'] = empty($inputs['description']) ? " " : $inputs['description'];
        $inputs['options'] = empty($inputs['options']) ? " " : $inputs['options'];
        $inputs['company_id'] = (int) $inputs['company_id'];
        
        $model = new $entity($inputs);
        $model->setId(HelperRepository::getDynamoDbLastRecordId($entity) + 1);
        $model->save();
    
        return response()->json('created');
    }
    
    public function delete($idKey)
    {
        $entity = $this->entity;
        $Key = $entity::where('id', (int) $idKey);
        $Key = $Key->get()->first();
        $Key->delete();
    
        return response()->json('deleted');
    }
    
    public function update(Request $request, $idKey)
    {
        $entity = $this->entity;
        
        $inputs = $request->all();
        $inputs['description'] = empty($inputs['description']) ? " " : $inputs['description'];
        $inputs['options'] = empty($inputs['options']) ? " " : $inputs['options'];
        $inputs['company_id'] = (int) $inputs['company_id'];
        
        $model = new $entity($inputs);
        $model->setId((int)$idKey);
        $model->save();
    
        return response()->json('updated');
    }
}
