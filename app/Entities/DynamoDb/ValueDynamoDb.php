<?php

namespace App\Entities\DynamoDb;

use \Nord\Lumen\DynamoDb\Domain\Model\DynamoDbModel as Model;

class ValueDynamoDb extends Model
{
    
    protected $compositeKey = ['entity_key', 'entity_id', 'attribute_id'];
    protected $table = 'values';
    
    protected $fillable = [
        'entity_key', 'entity_id', 'attribute_id', 'value',
    ];
}
