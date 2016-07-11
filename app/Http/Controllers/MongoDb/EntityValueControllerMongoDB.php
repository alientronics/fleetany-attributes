<?php

namespace App\Http\Controllers\MongoDb;

use App\Value;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\MongoDb\ValueMongoDb;

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
  
        $Values = ValueMongoDb::whereIn('entity_key', $this->getEntityKeys($entity_key))
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
                } elseif ($key != 'api_token') {
                    $fields['entity_key'] = $entity_key;
                    $fields['entity_id'] = $entity_id;
                    $fields['attribute_id'] = $key;
                    $fields['value'] = $value;
        
                    $update = ValueMongoDb::where('entity_key', $entity_key)
                                ->where('entity_id', $entity_id)
                                ->where('attribute_id', $key)
                                ->update($fields);
                    
                    if (empty($update)) {
                        ValueMongoDb::create($fields);
                    }
                }
            }
        }
  
        $this->saveFiles($request, $files);

        return response()->json('created');
  
    }
}
