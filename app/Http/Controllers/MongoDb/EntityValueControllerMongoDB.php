<?php

namespace App\Http\Controllers\MongoDb;

use App\Value;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EntityValueControllerMongoDB extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function get($entity_key, $entity_id)
    {
  
        $Values = Value::whereIn('entity_key', $this->getEntityKeys($entity_key))
                        ->where('entity_id', $entity_id)
                        ->get();

        return response()->json($Values);
  
    }
  
    public function set(Request $request, $entity_key, $entity_id)
    {

        $files = [];
        if (!empty($request->all())) {
            foreach ($request->all() as $key => $value) {
                if ($request->hasFile($key)) {
                    $files[] = $key;
                } elseif (is_numeric($key)) {
                    $fields['entity_key'] = $entity_key;
                    $fields['entity_id'] = $entity_id;
                    $fields['attribute_id'] = $key;
                    $fields['value'] = $value;
        
                    $update = Value::where('entity_key', $entity_key)
                                ->where('entity_id', $entity_id)
                                ->where('attribute_id', $key)
                                ->update($fields);
                    
                    if (empty($update)) {
                        Value::create($fields);
                    }
                }
            }
        }
  
        if (!empty($files)) {
            foreach ($files as $file_attribute) {
                if ($request->hasFile($file_attribute)) {
                    $file = $request->file($file_attribute);
                    Storage::put($file->getClientOriginalName(), file_get_contents($file));
                }
            }
        }

        return response()->json('created');
  
    }
}
