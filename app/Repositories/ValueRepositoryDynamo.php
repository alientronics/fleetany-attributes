<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Entities\DynamoDb\KeyDynamoDb;

class ValueRepositoryDynamo extends ValueRepository
{
    public function get($entity_key, $entity_id)
    {
        $entity_keys = HelperRepository::getEntityKeys($entity_key);
        
        if (count($entity_keys) > 1) {
            $Keys1 = $this->searchValues($entity_keys[0], $entity_id);
            $Keys2 = $this->searchValues($entity_keys[1], $entity_id);
            $Keys = $Keys1->merge($Keys2);
        } else {
            $Keys = $this->searchValues($entity_key, $entity_id);
        }
        
        $entity = $this->entity;
        
        $Values = $entity::where('entity_key', $entity_key)
            ->where('entity_id', (int) $entity_id)
            ->get();
    
        return response()->json($Values);
    
    }
    
    private function searchValues($entity_key, $entity_id)
    {
        $entity = $this->entity;
        
        $Values = $entity::where('entity_key', $entity_key)
            ->where('entity_id', (int) $entity_id)
            ->get();
        
        return $Values;
    }
    
    public function set(Request $request, $entity_key, $entity_id, $company_id)
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
                    $fields['company_id'] = $company_id;

                    $record = $entity::where('entity_key', $entity_key)
                        ->where('entity_id', $entity_id)
                        ->where('attribute_id', $key)
                        ->get()
                        ->first();
    
                    if (empty($record)) {
                        $idRecord = HelperRepository::getDynamoDbLastRecordId($entity) + 1;
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
    
    public function validateFileCompanyId($fileName, $companyId)
    {
        $entity = $this->entity;

        $results = $entity::where(['value' => (string)$fileName,
                'company_id' => (int)$companyId,
            ])
            ->get();

        return $results;
    }
}
