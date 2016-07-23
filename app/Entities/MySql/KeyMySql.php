<?php

namespace App\Entities\MySql;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeyMySql extends Model
{
    use SoftDeletes;
    
    protected $table = 'keys';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'company_id', 'entity_key', 'description', 'type', 'options',
    ];
}
