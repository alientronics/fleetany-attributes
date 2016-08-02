<?php
namespace App\Repositories;

class ValueRepositoryMySql extends ValueRepository
{

    
    public function validateFileCompanyId($fileName, $companyId)
    {
        $entity = $this->entity;
        
        $results = $entity::join('keys', 'values.attribute_id', '=', 'keys.id')
            ->where(['values.value' => $fileName,
                'keys.type' => 'file',
                'keys.company_id' => $companyId
            ])
            ->get();
            
        return $results;
    }
}
