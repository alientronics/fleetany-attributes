<?php

namespace App\Http\Controllers;

use App\Value;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EntityValueController extends Controller
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
  
        $Values = Value::where('entity_key', $entity_key)
                        ->where('entity_id', $entity_id)
                        ->get();

        return response()->json($Values);
  
    }
  
    public function set(Request $request, $entity_key, $entity_id)
    {
  
        foreach ($request->input('attributes') as $key => $value) {
         
            $fields['entity_key'] = $entity_key;
            $fields['entity_id'] = $entity_id;
            $fields['attribute_id'] = $key;
            $fields['value'] = $value;

            $update = Value::where('entity_key', $entity_key)
                        ->where('entity_id', $entity_id)
                        ->where('attribute_id', $key)
                        ->update($fields);
            
            if(empty($update)) {
                Value::create($fields);
            }

        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            Storage::put($file->getClientOriginalName(), file_get_contents($file));
        }

        return response()->json('created');
  
    }
}
