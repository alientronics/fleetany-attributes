<?php

namespace Tests\DynamoDb;

use Tests\AcceptanceValueTestCase;
use App\Entities\DynamoDb\ValueDynamoDb;
use App\Entities\DynamoDb\KeyDynamoDb;

class DynamoDbValueTest extends AcceptanceValueTestCase
{
    
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';
        $app['config']['database.driver'] = 'dynamodb';
        return $app;
    }

    /**
     * Assert that a given where condition exists in the database.
     *
     * @param  string  $table
     * @param  array  $data
     * @param  string|null $onConnection
     * @return $this
     */
    protected function seeInDatabase($table, array $data, $onConnection = null)
    {
        if(!empty($data)) {
            $key = KeyDynamoDb::where([
                "entity_key" => $data['entity_key'],
                "id" => $data['attribute_id']
            ])->get()->first();
            
            foreach($data as $index => $element) {
                if((is_numeric($element) && $index != "value") || 
                        ($key->type == "numeric" && $index == "value")) {
                    $data[$index] = (int) $element;
                }
            }
        }
        
        $Key = ValueDynamoDb::where($data);
        $Key = $Key->get()->first();
        
        if (empty($Key)) {
            return sprintf(
                'Unable to find row in database table [%s] that matched attributes [%s].', $table, json_encode($data)
            );
        } else {
            return true;
        }
    }
}
