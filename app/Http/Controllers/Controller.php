<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    //
    
    public function getEntityKeys($entity_key)
    {
        $entity_key = explode(".", $entity_key);
        if (!empty($entity_key[1])) {
            $entity_key[1] = $entity_key[0].".".$entity_key[1];
        }
        return $entity_key;
    }
    
    protected function saveFiles(Request $request, $files)
    {
        if (!empty($files)) {
            foreach ($files as $file_attribute) {
                if ($request->hasFile($file_attribute)) {
                    $file = $request->file($file_attribute);
                    Storage::put($file->getClientOriginalName(), file_get_contents($file));
                }
            }
        }
    }
}
