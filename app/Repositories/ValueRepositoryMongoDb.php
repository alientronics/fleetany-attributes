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
        if (!empty($value->attribute_id)) {var_dump($value->attribute_id);var_dump($companyId);
            $results = KeyMongoDb::where(['type' => 'file',
                    'company_id' => (int)$companyId,
                ])
                ->get();
        }
        
        return $results;
    }
}
