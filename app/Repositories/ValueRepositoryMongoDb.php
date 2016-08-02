<?php
namespace App\Repositories;

use App\Entities\MongoDb\KeyMongoDb;
class ValueRepositoryMongoDb extends ValueRepository
{

    
    public function validateFileCompanyId($fileName, $companyId)
    {
        $entity = $this->entity;

        $value = $entity::where(['value' => $fileName])
            ->get()->first();
        
        $results = [];
        if (!empty($value->attribute_id)) {var_dump("chegou");
            $results = KeyMongoDb::where(['type' => 'file',
                    'company_id' => $companyId,
                    'id' => $value->attribute_id
                ])
                ->get();
        }
        
        return $results;
    }
}
