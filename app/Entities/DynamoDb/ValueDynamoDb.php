<?php

namespace App\Entities\DynamoDb;

use \Nord\Lumen\DynamoDb\Domain\Model\DynamoDbModel as Model;

class ValueDynamoDb extends Model
{
    
    protected $primaryKey = 'id';
    protected $table = 'values';
    
    protected $fillable = [
        'entity_key', 'entity_id', 'attribute_id', 'value',
    ];
    
    protected $guarded = [
        'id',
    ];
}
