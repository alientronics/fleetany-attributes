<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelperRepository
{
    public static function getEntityKeys($entity_key)
    {
        $entity_key = explode(".", $entity_key);
        if (!empty($entity_key[1])) {
            $entity_key[1] = $entity_key[0].".".$entity_key[1];
        }
        return $entity_key;
    }
    
    public static function saveFiles(Request $request, $files)
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
    
    public static function getDynamoDbLastRecordId($entity)
    {
        $Keys = $entity::where([]);
        $Keys = $Keys->get();
    
        $idLastRecord = 0;
        if (!empty($Keys)) {
            foreach ($Keys as $Key) {
                if ($Key['id'] > $idLastRecord) {
                    $idLastRecord = $Key['id'];
                }
            }
        }
        
        return $idLastRecord;
    }
}
