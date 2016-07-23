<?php

namespace App\Entities\DynamoDb;

use \Nord\Lumen\DynamoDb\Domain\Model\DynamoDbModel as Model;

class KeyDynamoDb extends Model
{
    
    protected $primaryKey = 'id';
    protected $table = 'keys';
    
    protected $fillable = [
        'id', 'company_id', 'entity_key', 'description', 'type', 'options',
    ];
    
}
