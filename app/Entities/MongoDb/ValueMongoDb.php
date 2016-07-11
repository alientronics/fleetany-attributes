<?php

namespace App\Entities\MongoDb;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class ValueMongoDb extends Eloquent
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $collection = 'values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_key', 'entity_id', 'attribute_id', 'value',
    ];
}
