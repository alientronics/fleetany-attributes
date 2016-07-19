<?php
namespace App\Repositories;

use Illuminate\Http\Request;

class ValueRepositoryDynamo extends ValueRepository
{
    public function get($entity_key, $entity_id)
    {
        $entity = $this->entity;
        
        $Values = $entity::where('entity_key', $entity_key)
            ->where('entity_id', (int) $entity_id)
            ->get();
    
        return response()->json($Values);
    
    }
    
    public function set(Request $request, $entity_key, $entity_id)
    {
        $entity = $this->entity;
        
        $files = [];
        if (!empty($request->all())) {
            foreach ($request->all() as $key => $value) {
                if ($request->hasFile($key)) {
                    $files[] = $key;
                } elseif ($key != 'api_token') {
                    $fields['entity_key'] = $entity_key;
                    $fields['entity_id'] = (int) $entity_id;
                    $fields['attribute_id'] = (int) $key;
                    $fields['value'] = $value;

                    $record = $entity::where('entity_key', $entity_key)
                        ->where('entity_id', $entity_id)
                        ->where('attribute_id', $key)
                        ->get()
                        ->first();
    
                    if (empty($record)) {
                        $idRecord = HelperRepository::getLastRecordId($entity) + 1;
                    } else {
                        $idRecord = (int) $record['id'];
                    }
                    
                    $model = new $entity($fields);
                    $model->setId($idRecord);
                    $model->save();
                }
            }
        }
    
        HelperRepository::saveFiles($request, $files);
    
        return response()->json('created');
    }
}
