<?php

namespace App\Http\Controllers\MongoDb;

use App\Key;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\MongoDb\KeyMongoDb;

class KeyControllerMongoDB extends Controller
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

    public function index($company_id, $entity_key = '-', $description = '-')
    {
        $Keys = KeyMongoDb::where('company_id', $company_id);
  
        if ($entity_key != '-') {
            $Keys = $Keys->whereIn('entity_key', $this->getEntityKeys($entity_key));
        }
        
        if ($description != '-') {
            $Keys = $Keys->where('description', 'like', '%'.$description.'%');
        }
        
        $Keys = $Keys->get();
        
        if (!empty($Keys)) {
            foreach ($Keys as $i => $Key) {
                $Keys[$i]['id'] = $Key['_id'];
                $Keys[$i]['entity-key'] = $Key['entity_key'];
            }
        }
        
        return response()->json($Keys);
    }
  
    public function get($idKey)
    {
        $Key = KeyMongoDb::find($idKey);
        $Key['id'] = $idKey;

        return response()->json($Key);
    }
  
    public function create(Request $request)
    {
        KeyMongoDb::create($request->all());
  
        return response()->json('created');
  
    }
  
    public function delete($idKey)
    {
        $Key = KeyMongoDb::find($idKey);
        $Key->delete();
 
        return response()->json('deleted');
    }
  
    public function update(Request $request, $idKey)
    {
        $Key = KeyMongoDb::find($idKey);
        $Key->fill($request->all());
        $Key->save();
  
        return response()->json('updated');
    }
}
