<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\json_encode;
use Illuminate\Http\Response;

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
    
    public static function download(Request $request)
    {
        $data = $request->all();

        if (empty($data['file'])) {
            return null;
        }

        $fileName = urldecode(base64_decode($data['file']));

        if (Storage::has($fileName)) {
            $contents = Storage::get($fileName);
            $mimeType = Storage::mimeType($fileName);
            return (new Response($contents, 200))->header('Content-Type', $mimeType);
        } else {
            return (new Response("", 200));
        }
    }
}
