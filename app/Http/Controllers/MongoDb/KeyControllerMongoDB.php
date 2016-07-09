<?php

namespace App\Http\Controllers\MongoDb;

use App\Key;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
  
        $Keys = Key::select('*', 'entity_key as entity-key', 'entity_key as entity-key')
                    ->where('keys.company_id', $company_id);
  
        if ($entity_key != '-') {
            $Keys = $Keys->whereIn('keys.entity_key', $this->getEntityKeys($entity_key));
        }
        
        if ($description != '-') {
            $Keys = $Keys->where('keys.description', 'like', '%'.$description.'%');
        }
        
        $Keys = $Keys->get();
        
        Storage::put('file.txt', 'Contents');

        return response()->json($Keys);
    }
  
    public function get($idKey)
    {
  
        $Key  = Key::find($idKey);

        return response()->json($Key);
    }
  
    public function create(Request $request)
    {
  
        Key::create($request->all());
  
        return response()->json('created');
  
    }
  
    public function delete($idKey)
    {
        $Key  = Key::find($idKey);
        $Key->delete();
 
        return response()->json('deleted');
    }
  
    public function update(Request $request, $idKey)
    {
        $Key  = Key::find($idKey);
        $Key->fill($request->all());
        $Key->save();
  
        return response()->json('updated');
    }
}
