<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //
    
    public function getEntityKeys($entity_key) {
        $entity_key = explode(".", $entity_key);
        if(!empty($entity_key[1])) {
            $entity_key[1] = $entity_key[0].".".$entity_key[1];
        }
        return $entity_key;
    }
}
