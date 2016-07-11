<?php

namespace App\Entities\MongoDb;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class KeyMongoDb extends Eloquent
{
    protected $collection = 'keys';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'entity_key', 'description', 'type', 'options',
    ];
}
