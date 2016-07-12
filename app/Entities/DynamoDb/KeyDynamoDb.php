<?php

namespace App\Entities\DynamoDb;

use \Nord\Lumen\DynamoDb\Domain\Model\DynamoDbModel as Model;

class ValueDynamoDb extends Model
{
    
    protected $compositeKey = ['company_id', 'entity_key'];
    protected $table = 'keys';
    
    protected $fillable = [
        'company_id', 'entity_key', 'description', 'type', 'options',
    ];
}
