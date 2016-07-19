<?php
namespace App\Repositories;

use Illuminate\Http\Request;

class KeyRepositoryDynamo extends KeyRepository
{
    public function index($company_id, $entity_key = '-', $description = '-')
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
            }
        }
        
        return response()->json($Keys);
    }
    
    public function get($idKey)
    {
        $entity = $this->entity;

        $Key = $entity::where('id', (int)$idKey);
        $Key = $Key->get()->first();
        
        if (!empty($Key)) {
            $Key['id'] = $idKey;
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
        $model->setId($this->getLastRecordId() + 1);
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
    
    private function getLastRecordId()
    {
        $entity = $this->entity;
        $Key = $entity::where([]);
        $Key = $Key->get()->last();
        
        $idLastRecord = empty($Key) ? 0 : $Key['id'];
        
        return $idLastRecord;
    }
}
