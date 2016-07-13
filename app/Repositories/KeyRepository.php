<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class KeyRepository
{
    private $entity;
    
    public function __construct($entity)
    {
        $this->entity = $entity;
    }
    
    public function index($company_id, $entity_key = '-', $description = '-')
    {
    
        $entity = $this->entity;
        
        $Keys = $entity::select('*', 'entity_key as entity-key', 'entity_key as entity-key')
            ->where('keys.company_id', $company_id);
    
        if ($entity_key != '-') {
            $Keys = $Keys->whereIn('keys.entity_key', HelperRepository::getEntityKeys($entity_key));
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
        $entity = $this->entity;
        $Key  = $entity::find($idKey);
    
        return response()->json($Key);
    }
    
    public function create(Request $request)
    {
        $entity = $this->entity;
        $entity::create($request->all());
    
        return response()->json('created');
    
    }
    
    public function delete($idKey)
    {
        $entity = $this->entity;
        $Key  = $entity::find($idKey);
        $Key->delete();
    
        return response()->json('deleted');
    }
    
    public function update(Request $request, $idKey)
    {
        $entity = $this->entity;
        $Key  = $entity::find($idKey);
        $Key->fill($request->all());
        $Key->save();
    
        return response()->json('updated');
    }
}
