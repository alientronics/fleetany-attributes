<?php

namespace App\Entities\MongoDb;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class KeyMongoDb extends Eloquent
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
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
