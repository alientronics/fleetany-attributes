<?php
namespace App\Repositories;

class ValueRepositoryMongoDb extends ValueRepository
{

    
    public function validateFileCompanyId($fileName, $companyId)
    {
        $entity = $this->entity;

        $results = $entity::where(['value' => $fileName,
                'company_id' => $companyId,
            ])
            ->get();
        
        return $results;
    }
}
