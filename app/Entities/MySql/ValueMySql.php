<?php

namespace App\Entities\MySql;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ValueMySql extends Model
{
    use SoftDeletes;
    
    protected $table = 'values';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_key', 'entity_id', 'attribute_id', 'value',
    ];
}
